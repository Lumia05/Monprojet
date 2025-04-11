<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\HeureSupResource\Pages;
use App\Filament\Employee\Resources\HeureSupResource\RelationManagers;
use App\Models\HeureSup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section ;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeureSupResource extends Resource
{
    protected static ?string $model = HeureSup::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Details sur les Heures Supplementaire')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Employee')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable()
                        ->disabled()
                        ->default(auth()->id())
                        ->preload(),
                    Forms\Components\DatePicker::make('date')
                        ->required()
                        ->maxDate(now())
                        ->required(),
                    Forms\Components\TextInput::make('heures')
                        ->required()
                        ->minValue(0)
                        ->numeric(),
                    Forms\Components\Textarea::make('reason')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                        ])
                        ->default('en_attente')
                        ->disabled()
                        ->required(),
                    Forms\Components\Select::make('approved_by')
                        ->relationship('approver', 'name')
                        ->default(auth()->id())
                        ->disabled()
                        // ->visible(fn (string $operation) => $operation === 'edit')

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
            Tables\Columns\TextColumn::make('user_id')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('heures')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('approver.name')
                ->label('Approved By')
                ->default('N/A')
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->action(function (HeureSup $record) {
                    $record->update([
                        'status' => 'approve',
                        'approved_by' => auth()->id(),
                    ]);
                })
                ->color('success')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->visible(fn (HeureSup $record) => $record->status === 'pending'),
            Tables\Actions\Action::make('reject')
                ->label('Reject')
                ->action(function (HeureSup $record) {
                    // Log::info($record);
                    $record->update([
                        'status' => 'rejete',
                        'approved_by' => auth()->id(),
                    ]);
                })
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->requiresConfirmation()
                ->visible(fn (HeureSup $record) => $record->status === 'pending'),
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
            'index' => Pages\ListHeureSups::route('/'),
            'create' => Pages\CreateHeureSup::route('/create'),
            'edit' => Pages\EditHeureSup::route('/{record}/edit'),
        ];
    }
}
