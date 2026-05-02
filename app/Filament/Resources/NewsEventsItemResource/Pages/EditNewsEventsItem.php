<?php

namespace App\Filament\Resources\NewsEventsItemResource\Pages;

use App\Filament\Resources\NewsEventsItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsEventsItem extends EditRecord
{
    protected static string $resource = NewsEventsItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
