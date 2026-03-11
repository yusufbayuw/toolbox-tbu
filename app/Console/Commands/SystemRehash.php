<?php

namespace App\Console\Commands;

use App\Services\License\LicenseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SystemRehash extends Command
{
    protected $signature = 'system:rehash';

    protected $description = 'Generate ulang manifest hash integritas file terlindungi.';

    public function __construct(
        private readonly LicenseService $licenseService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $manifest = $this->licenseService->manifestPayload();
        $manifestPath = $this->licenseService->manifestPath();

        File::ensureDirectoryExists(dirname($manifestPath));
        File::put(
            $manifestPath,
            "<?php\n\nreturn ".var_export($manifest, true).";\n"
        );

        $rows = [];

        foreach ($manifest['files'] as $file => $hash) {
            $rows[] = [$file, (string) $hash];
        }

        $this->info('Manifest integritas berhasil di-generate.');
        $this->line($manifestPath);
        $this->newLine();
        $this->table(['File', 'SHA256'], $rows);

        return self::SUCCESS;
    }
}
