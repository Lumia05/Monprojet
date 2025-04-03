<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                FileUpload::make('profil')
                    ->label('Profile')
                    ->avatar(),
                
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('telephone'),
                Select::make('sexe')->options([
                    'F' => 'Feminin',
                    'M' => 'Masculin'
                ]),
                DatePicker::make('date_de_naissance')
                    ->displayFormat('d/m/Y'),
                Select::make('role')->options([
                    'employee' => 'Employee',
                    'admin' => 'Administrateur',
                    'super_admin' => 'Super administrateur'
                ])

                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profil')
                    ->label('Profile')
                    ->circular()
                    ->size(70)
                    ->default('https://ui-avatars.com/api/?name=User&background=random')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name'),
                    // ->primary()
                    // ->searchable()
                    // ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone'),
                Tables\Columns\TextColumn::make('sexe')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->sortable(),
                Tables\Columns\TextColumn::make('adresse')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('poste')
                    ->searchable()
                    ->sortable(),
                
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
