<?php

namespace App\Filament\Resources\QrResource\Pages;

use App\Filament\Resources\QrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQrs extends ListRecords
{
    protected static string $resource = QrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
