<?php

namespace App\Filament\Resources\AwardRecognitionResource\Pages;

use App\Filament\Resources\AwardRecognitionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAwardRecognitions extends ListRecords
{
    protected static string $resource = AwardRecognitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
