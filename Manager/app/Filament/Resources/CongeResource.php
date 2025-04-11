<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CongeResource\Pages;
use App\Filament\Resources\CongeResource\RelationManagers;
use App\Models\Conge;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CongeResource extends Resource
{
    protected static ?string $model = Conge::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Demande de conge')
                ->schema([
                    Select::make('user_id')
                        ->label('Employee')
                        ->relationship('user' , 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('status')
                        ->label('Statut')
                        ->options([
                            'en_attente' => 'en attente',
                            'approuve' => 'Approuve',
                            'rejete' => 'Rejeter'
                        ])
                        ->default('en_attente')
                        ->required()
                        ->visible(fn (string $operation) => $operation === 'edit'),
                    Select::make('approved_by')
                        ->relationship('approver' , 'name')
                        ->default(auth()->id())
                        ->visible(fn (string $operation) => $operation === 'edit'),

                    Select::make('type')
                        ->label('Type de conge')
                        
                        ->options([
                            'conge_paye' => 'Conges Paye',
                            'conge_sans_solde' => 'Conges sans solde',
                        ])
                        ->required(),
                    Textarea::make('motif')
                        ->rows(3)
                        ->columnSpan(2)
                        ->required(),
                    Forms\Components\DatePicker::make('date_debut')
                        ->required(),   
                    Forms\Components\DatePicker::make('date_fin')
                        ->required()
                        ->after('date_debut'),
                    
                        
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date_debut')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_fin')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color( fn(string $state): string => match ($state){
                        'rejete' => 'red',
                        'approuve' => 'success',
                        'en_attente' => 'violet'
                    })
                    ->searchable(),
                TextColumn::make('type')
                    ->sortable()
                    ->badge()
                    ->color( fn(string $state): string => match ($state){
                        'conge_paye' => 'success',
                        'conge_sans_solde' => 'amber'
                    })
                    ->searchable(),
                TextColumn::make('approver.name')
                    ->label('Approved By')
                    ->default('N/A')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (Conge $record) {
                        $record->update([
                            'status' => 'approuve',
                            'approver_id' => auth()->id()
                        ]);
                    })
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (Conge $record) => $record->status === 'pending'),
                
                    Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->action(function (Conge $record) {
                        $record->update([
                            'status' => 'rejected',
                            'approved_by' => auth()->id(),
                        ]);
                    })
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn (Conge $record) => $record->status === 'pending'),


                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConges::route('/'),
            'create' => Pages\CreateConge::route('/create'),
            'edit' => Pages\EditConge::route('/{record}/edit'),
        ];
    }
}
