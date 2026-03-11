<?php

namespace App\Services\License;

use App\Support\SystemBoot;
use Illuminate\Support\Facades\File;

class LicenseService
{
    public function __construct(
        private readonly SystemBoot $systemBoot,
    ) {
    }

    public function status(): array
    {
        $license = $this->systemBoot->verifyLicense();
        $integrity = $this->systemBoot->verifyIntegrity();

        $valid = $license['valid'] && $integrity['valid'];
        $status = $valid ? 'valid' : ($integrity['valid'] ? $license['status'] : $integrity['status']);
        $message = $valid ? 'Lisensi dan integritas aplikasi valid.' : ($integrity['valid'] ? $license['message'] : $integrity['message']);

        return [
            'valid' => $valid,
            'status' => $status,
            'message' => $message,
            'license' => $license,
            'integrity' => $integrity,
            'system_signature' => $this->systemBoot->systemSignature(),
            'license_source' => $license['source'] ?? null,
            'env_override_active' => $this->systemBoot->licenseKeyFromEnvironment() !== null,
        ];
    }

    public function validateProvidedKey(string $licenseKey): array
    {
        return $this->systemBoot->verifyLicense($licenseKey, 'provided');
    }

    public function activate(string $licenseKey): array
    {
        $result = $this->validateProvidedKey($licenseKey);

        if (!$result['valid']) {
            return $result;
        }

        File::ensureDirectoryExists(dirname((string) config('license.storage_key_path')));
        File::put(config('license.storage_key_path'), trim($licenseKey));

        $result['stored'] = true;
        $result['storage_path'] = config('license.storage_key_path');
        $result['env_override_active'] = $this->systemBoot->licenseKeyFromEnvironment() !== null;

        return $result;
    }

    public function systemSignature(): string
    {
        return $this->systemBoot->systemSignature();
    }

    public function storageLicensePath(): string
    {
        return (string) config('license.storage_key_path');
    }

    public function manifestPath(): string
    {
        return (string) config('license.manifest_path');
    }

    public function protectedFileHashes(): array
    {
        return $this->systemBoot->hashProtectedFiles();
    }

    public function manifestPayload(): array
    {
        return [
            'generated_at' => now()->toIso8601String(),
            'files' => $this->protectedFileHashes(),
        ];
    }
}
