<?php

namespace App\Filament\Imports;

use App\Models\Certificate;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CertificateImporter extends Importer
{
    protected static ?string $model = Certificate::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('jenis')
                ->rules(['max:255']),
            ImportColumn::make('prefix_nomor')
                ->rules(['max:255']),
            ImportColumn::make('deskripsi'),
            ImportColumn::make('lokasi')
                ->rules(['max:255']),
            ImportColumn::make('tanggal_terbit')
                ->rules(['max:255']),
            ImportColumn::make('nama_penandatangan')
                ->rules(['max:255']),
            ImportColumn::make('jabatan_penandatangan')
                ->rules(['max:255']),
            ImportColumn::make('file_tandatangan')
                ->rules(['max:255']),
            ImportColumn::make('background_image')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Certificate
    {
        // return Certificate::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Certificate();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your certificate import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
