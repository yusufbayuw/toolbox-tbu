<?php

namespace App\Console\Commands;

use App\Support\SystemBoot;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use RuntimeException;

class GenerateLicense extends Command
{
    protected $signature = 'license:create
        {system_signature : Signature sistem target}
        {--expires= : Tanggal kedaluwarsa format YYYY-MM-DD}';

    protected $description = 'Generate license key RSA untuk instalasi klien.';

    public function handle(): int
    {
        if (!app()->environment('local')) {
            $this->error('license:create hanya boleh dijalankan di environment local.');

            return self::FAILURE;
        }

        $privateKeyPath = base_path('private_key.pem');

        if (!file_exists($privateKeyPath)) {
            $this->error('private_key.pem tidak ditemukan di base path.');

            return self::FAILURE;
        }

        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));

        if ($privateKey === false) {
            $this->error('private_key.pem tidak bisa dibaca sebagai private key RSA.');

            return self::FAILURE;
        }

        $payload = [
            'version' => 1,
            'signature' => $this->argument('system_signature'),
            'issued_at' => now()->toIso8601String(),
            'expires' => $this->option('expires') ?: null,
        ];

        $payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        $signature = '';
        $signed = openssl_sign($payloadJson, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$signed) {
            throw new RuntimeException('Gagal menandatangani payload lisensi.');
        }

        $licenseKey = SystemBoot::base64UrlEncode($payloadJson).'.'.SystemBoot::base64UrlEncode($signature);

        $this->info('License key berhasil dibuat.');
        $this->newLine();
        $this->line($licenseKey);
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['version', (string) Arr::get($payload, 'version')],
                ['signature', (string) Arr::get($payload, 'signature')],
                ['issued_at', (string) Arr::get($payload, 'issued_at')],
                ['expires', (string) (Arr::get($payload, 'expires') ?: 'never')],
            ]
        );

        return self::SUCCESS;
    }
}
