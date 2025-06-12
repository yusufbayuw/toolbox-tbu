<?php

namespace App\Filament\Imports;

use App\Models\CertificateParticipant;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CertificateParticipantImporter extends Importer
{
    protected static ?string $model = CertificateParticipant::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('certificate')
                ->relationship(),
            ImportColumn::make('nomor')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('nama_penerima')
                ->rules(['max:255']),
            ImportColumn::make('asal_penerima')
                ->rules(['max:255']),
            ImportColumn::make('uuid')
                ->label('UUID')
                ->rules(['max:255']),
            ImportColumn::make('uuid_val')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?CertificateParticipant
    {
        // return CertificateParticipant::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new CertificateParticipant();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your certificate participant import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
