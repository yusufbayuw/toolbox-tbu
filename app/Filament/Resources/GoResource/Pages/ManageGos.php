<?php

namespace App\Filament\Resources\GoResource\Pages;

use App\Filament\Resources\GoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGos extends ManageRecords
{
    protected static string $resource = GoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
