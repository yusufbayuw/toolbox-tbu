<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class SystemBoot
{
    private string $pk = <<<'PEM'
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqKTHsF9DQpduW65kgq7k
f6Mu7QJ/l9GsDnF5s8U2BTNj9iUf5nRkDDbSOzZslq314CdbQ92UKiSmEy/a+wKE
014I/JiTToDeQKjxiSfDp2bBNe3qnaCqhcVw8gY6DH1xzt0SjW+h6ohphA90cUbP
MQaIiGIrWLS7qLTcLTu9r2TxEfbL7uxOCGpiWaLK4v4gXMt9hBr/Pv0ow8TQ//qa
artwhsyfsHEqXfKB6v6ZpWfX65bxl9bWTrsAtIR6jy+tFYFPDoms2clCq7uuorex
y5okc+Ihbp/TuUEDXl3caEsk9FeUj7X40fkgyEJHYqtp/nIGcgRJxGG4x+AfK47A
EQIDAQAB
-----END PUBLIC KEY-----
PEM;

    public function systemSignature(): string
    {
        $domain = $this->normalizedDomain();
        $path = realpath(base_path()) ?: base_path();

        return hash('sha256', $domain.'|'.$path);
    }

    public function licenseKeyFromEnvironment(): ?string
    {
        $value = env('LICENSE_KEY');

        return is_string($value) && trim($value) !== '' ? trim($value) : null;
    }

    public function licenseKeyFromStorage(): ?string
    {
        $path = config('license.storage_key_path');

        if (!is_string($path) || !File::exists($path)) {
            return null;
        }

        $value = trim((string) File::get($path));

        return $value !== '' ? $value : null;
    }

    public function activeLicenseKey(): ?array
    {
        if ($license = $this->licenseKeyFromEnvironment()) {
            return ['key' => $license, 'source' => 'env'];
        }

        if ($license = $this->licenseKeyFromStorage()) {
            return ['key' => $license, 'source' => 'file'];
        }

        return null;
    }

    public function verifyLicense(?string $licenseKey = null, ?string $source = null): array
    {
        $resolved = $licenseKey !== null
            ? ['key' => trim($licenseKey), 'source' => $source ?? 'provided']
            : $this->activeLicenseKey();

        if (!$resolved || trim((string) $resolved['key']) === '') {
            return $this->licenseResult(false, 'missing', 'Lisensi belum diaktivasi.', null, $resolved['source'] ?? null);
        }

        $parts = explode('.', (string) $resolved['key'], 2);

        if (count($parts) !== 2) {
            return $this->licenseResult(false, 'malformed', 'Format license key tidak valid.', null, $resolved['source']);
        }

        $payloadJson = self::base64UrlDecode($parts[0]);
        $signature = self::base64UrlDecode($parts[1]);

        if ($payloadJson === false || $signature === false) {
            return $this->licenseResult(false, 'malformed', 'License key tidak dapat dibaca.', null, $resolved['source']);
        }

        $verified = openssl_verify($payloadJson, $signature, $this->pk, OPENSSL_ALGO_SHA256);

        if ($verified !== 1) {
            return $this->licenseResult(false, 'signature_mismatch', 'Signature lisensi tidak valid.', null, $resolved['source']);
        }

        $payload = json_decode($payloadJson, true);

        if (!is_array($payload)) {
            return $this->licenseResult(false, 'malformed', 'Payload lisensi tidak valid.', null, $resolved['source']);
        }

        $systemSignature = Arr::get($payload, 'signature');

        if (!is_string($systemSignature) || $systemSignature !== $this->systemSignature()) {
            return $this->licenseResult(false, 'binding_mismatch', 'Lisensi tidak cocok dengan domain atau path instalasi ini.', $payload, $resolved['source']);
        }

        $expires = Arr::get($payload, 'expires');

        if (is_string($expires) && trim($expires) !== '') {
            $expiryDate = CarbonImmutable::parse($expires)->endOfDay();

            if ($expiryDate->isPast()) {
                return $this->licenseResult(false, 'expired', 'Lisensi sudah kedaluwarsa.', $payload, $resolved['source']);
            }
        }

        return $this->licenseResult(true, 'valid', 'Lisensi valid.', $payload, $resolved['source']);
    }

    public function verifyIntegrity(): array
    {
        $manifestPath = config('license.manifest_path');

        if (!is_string($manifestPath) || !File::exists($manifestPath)) {
            return [
                'valid' => false,
                'status' => 'manifest_missing',
                'message' => 'Manifest integritas belum dibuat.',
                'manifest_path' => $manifestPath,
                'mismatches' => [],
            ];
        }

        $manifest = require $manifestPath;

        if (!is_array($manifest) || !isset($manifest['files']) || !is_array($manifest['files'])) {
            return [
                'valid' => false,
                'status' => 'manifest_invalid',
                'message' => 'Manifest integritas rusak atau tidak valid.',
                'manifest_path' => $manifestPath,
                'mismatches' => [],
            ];
        }

        $current = $this->hashProtectedFiles();
        $expected = $manifest['files'];
        $mismatches = [];

        foreach ($expected as $file => $hash) {
            if (($current[$file] ?? null) !== $hash) {
                $mismatches[$file] = [
                    'expected' => $hash,
                    'actual' => $current[$file] ?? null,
                ];
            }
        }

        foreach ($current as $file => $hash) {
            if (!array_key_exists($file, $expected)) {
                $mismatches[$file] = [
                    'expected' => null,
                    'actual' => $hash,
                ];
            }
        }

        if ($mismatches !== []) {
            return [
                'valid' => false,
                'status' => 'integrity_failed',
                'message' => 'Terdapat file terlindungi yang berubah tanpa rehash.',
                'manifest_path' => $manifestPath,
                'mismatches' => $mismatches,
            ];
        }

        return [
            'valid' => true,
            'status' => 'valid',
            'message' => 'Integritas file valid.',
            'manifest_path' => $manifestPath,
            'mismatches' => [],
            'generated_at' => $manifest['generated_at'] ?? null,
        ];
    }

    public function protectedFiles(): array
    {
        return config('license.protected_files', []);
    }

    public function hashProtectedFiles(): array
    {
        $hashes = [];

        foreach ($this->protectedFiles() as $file) {
            $path = base_path($file);

            if (File::exists($path)) {
                $hashes[$file] = hash_file('sha256', $path);
            } else {
                $hashes[$file] = null;
            }
        }

        ksort($hashes);

        return $hashes;
    }

    public static function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    public static function base64UrlDecode(string $value): string|false
    {
        $padding = strlen($value) % 4;

        if ($padding > 0) {
            $value .= str_repeat('=', 4 - $padding);
        }

        return base64_decode(strtr($value, '-_', '+/'), true);
    }

    private function normalizedDomain(): string
    {
        $configuredUrl = (string) config('app.url', '');
        $host = parse_url($configuredUrl, PHP_URL_HOST);

        if (is_string($host) && $host !== '') {
            return strtolower($host);
        }

        $trimmed = trim(strtolower($configuredUrl));

        return preg_replace('#^https?://#', '', $trimmed) ?: 'unknown-domain';
    }

    private function licenseResult(bool $valid, string $status, string $message, ?array $payload, ?string $source): array
    {
        return [
            'valid' => $valid,
            'status' => $status,
            'message' => $message,
            'payload' => $payload,
            'source' => $source,
            'system_signature' => $this->systemSignature(),
        ];
    }
}
