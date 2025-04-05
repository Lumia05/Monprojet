<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CongeResource\Pages;
use App\Filament\Resources\CongeResource\RelationManagers;
use App\Models\Conge;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CongeResource extends Resource
{
    protected static ?string $model = Conge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Enregistrement Du Pointage')
                ->schema([
                    Select::make('user_id')
                        ->relationship('user' , 'id')
                        ->required(),
                    Select::make('status')
                        ->options([
                            'en_attente' => 'en attente',
                            'approuve' => 'Approuve',
                            'rejete' => 'Rejeter'
                        ])
                        ->default('en_attente')
                        ->required(),
                    Select::make('type')
                        ->options([
                            'conge_paye' => 'Conges Paye',
                            'conge_sans_solde' => 'Conges sans solde',
                        ])
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->sortable()
                ->searchable(),
                TextColumn::make('date_debut'),
                TextColumn::make('date_fin'),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
