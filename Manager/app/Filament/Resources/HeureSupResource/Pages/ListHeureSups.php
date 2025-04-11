<?php

namespace App\Filament\Resources\HeureSupResource\Pages;

use App\Filament\Resources\HeureSupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeureSups extends ListRecords
{
    protected static string $resource = HeureSupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
