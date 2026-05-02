<?php

namespace App\Filament\Resources\CareersSettingsResource\Pages;

use App\Filament\Resources\CareersSettingsResource;
use Filament\Resources\Pages\EditRecord;

class EditCareersSettings extends EditRecord
{
    protected static string $resource = CareersSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
