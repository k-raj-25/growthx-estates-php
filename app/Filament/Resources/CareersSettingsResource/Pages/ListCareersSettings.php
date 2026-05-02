<?php

namespace App\Filament\Resources\CareersSettingsResource\Pages;

use App\Filament\Resources\CareersSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareersSettings extends ListRecords
{
    protected static string $resource = CareersSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
