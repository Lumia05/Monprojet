<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Filament\Resources\PresenceResource\RelationManagers;
use App\Models\Presence;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class ;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Details De Presence')
                ->schema([
                    Select::make('user_id')
                        ->relationship('user' , 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('status')
                        ->options([
                            'absent' => 'Absent',
                            'present' => 'Present',
                            'en conge' => 'En Conge'
                        ])
                        ->default('present')
                        ->required(),
                    DatePicker::make('date')
                        ->maxDate(now())
                        ->required(),
                    TimePicker::make('heure_entr')
                        ->seconds(false),
                    TimePicker::make('heure_srt')
                        ->seconds(false)
                        ->after('heure_entr'),
                    TextInput::make('qr_token')
                        ->readOnly(),                        

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
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('heure_entr')
                    ->time()
                    ->sortable(),
                TextColumn::make('heure_srt')
                    ->time(),
                TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color( fn(string $state): string => match ($state){
                        'absent' => 'red',
                        'present' => 'success',
                        'en conge' => 'violet'
                    })
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'absent' => 'red',
                        'present' => 'success',
                        'en conge' => 'violet'
                    ]),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('to')
                            ->label('To Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($query) => $query->whereDate('date', '>=', $data['from']))
                            ->when($data['to'], fn ($query) => $query->whereDate('date', '<=', $data['to']));
                    }),
            ])
            ->actions([
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
            'index' => Pages\ListPresences::route('/'),
            'create' => Pages\CreatePresence::route('/create'),
            'edit' => Pages\EditPresence::route('/{record}/edit'),
        ];
    }
}
