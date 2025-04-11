<?php

namespace App\Filament\Employee\Resources\CongeResource\Pages;

use App\Filament\Employee\Resources\CongeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConge extends EditRecord
{
    protected static string $resource = CongeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
