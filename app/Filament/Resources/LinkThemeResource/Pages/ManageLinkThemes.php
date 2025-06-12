<?php

namespace App\Filament\Resources\LinkThemeResource\Pages;

use App\Filament\Resources\LinkThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLinkThemes extends ManageRecords
{
    protected static string $resource = LinkThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
