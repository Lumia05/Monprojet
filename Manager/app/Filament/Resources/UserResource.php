<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile')
                    ->schema([
                        FileUpload::make('profil')
                            ->image()
                            ->directory('Avatar')
                            ->disk('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->maxSize(5000)
                            ->label('Profile')
                            ->extraAttributes(['class' => 'flex items-center justify-center'])
                            ->avatar(),
                    ]),
                Section::make('Extra Informations')
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(User::class, 'email', ignorable: fn ($record) => $record),
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $op) => $op === 'create')
                            ->visible(fn (string $operation) => $operation === 'create')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                        TextInput::make('telephone')
                            ->tel()
                            ->required(),
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
                        ]),
                        TextInput::make('adresse'),
                        Select::make('poste')
                            ->options([
                                'consultant' => 'Consultant' ,
                                'administrateur' => 'Administrateur'
                            ]),
                        TextInput::make('employee_code')
                            ->required()
                            ->unique(User::class, 'employee_code', ignorable: fn ($record) => $record)
                            ->maxLength(255)

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
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'employee' => 'info',
                        'admin' => 'blue',
                        'super_admin' => 'success',
                    }),
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
                Tables\Actions\Action::make('downloadBadge')
                ->label('Download Badge')
                ->icon('heroicon-o-qr-code')
                ->action(function (User $record) {
                    $fileName = 'qrcode-' . Str::uuid() . '.png';
                    $filePath = storage_path('app/public/qrcodes/' . $fileName);

                    $qrCodeBase64 = base64_encode(QrCode::format('svg')->size(200)->generate($record->employee_code));

                    // Generate the PDF
                    $pdf = Pdf::loadView('components.badge', [
                        'user' => $record,
                        'qrCodeBase64' => $qrCodeBase64,
                    ]);
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        "badge-{$record->employee_code}.pdf"
                    );
                })
                ->color('primary'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
