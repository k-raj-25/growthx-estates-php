<?php

namespace App\Filament\Resources\NewsEventsItemResource\Pages;

use App\Filament\Resources\NewsEventsItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsEventsItems extends ListRecords
{
    protected static string $resource = NewsEventsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
