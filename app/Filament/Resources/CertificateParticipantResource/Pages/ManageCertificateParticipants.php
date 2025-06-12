<?php

namespace App\Filament\Resources\CertificateParticipantResource\Pages;

use App\Filament\Resources\CertificateParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCertificateParticipants extends ManageRecords
{
    protected static string $resource = CertificateParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
