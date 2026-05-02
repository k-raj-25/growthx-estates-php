<?php

namespace App\Filament\Resources\SiteEnquiryResource\Pages;

use App\Filament\Resources\SiteEnquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteEnquiry extends EditRecord
{
    protected static string $resource = SiteEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
