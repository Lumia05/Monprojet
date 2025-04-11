<?php

namespace App\Filament\Employee\Resources\CongeResource\Pages;

use App\Filament\Employee\Resources\CongeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConges extends ListRecords
{
    protected static string $resource = CongeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
