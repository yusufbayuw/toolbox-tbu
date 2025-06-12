<?php

namespace App\Observers;

use App\Models\Go;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GoObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Go "created" event.
     */
    public function created(Go $go): void
    {
        $this->generateAndStoreQrCode($go);
    }

    /**
     * Handle the Go "updated" event.
     */
    public function updated(Go $go): void
    {
        // Handle logo update
        if ($go->isDirty('logo')) {
            $this->deleteFile($go->getOriginal('logo'));
        }

        // Handle QR code update
        $this->deleteFile($go->qr_code_image);
        $this->generateAndStoreQrCode($go);
    }

    /**
     * Handle the Go "deleted" event.
     */
    public function deleted(Go $go): void
    {
        $this->deleteFile($go->logo);
        $this->deleteFile($go->qr_code_image);
    }

    /**
     * Generate and store QR code for the Go model.
     */
    private function generateAndStoreQrCode(Go $go): void
    {
        $type = 'png';
        $uuid = Str::uuid()->toString() . '.' . $type;
        $filepath = 'go/'.date('Y') . '/' . date('m') . '/qr/' . $uuid;

        if ($go->logo) {
            # when logo uploaded
            $qrCode = QrCode::size(500)
                ->format($type)
                ->mergeString(
                    Storage::disk(config('base_urls.default_disk'))->get($go->logo),0.25
                )
                ->generate(config('base_urls.base_go') . '/' . $go->short_link);
        } else {
            $qrCode = QrCode::size(500)
            ->format($type)
            ->generate(config('base_urls.base_go') . '/' . $go->short_link);
        }

        Storage::disk(config('base_urls.default_disk'))->put($filepath, $qrCode);

        $go->updateQuietly(['qr_code_image' => $filepath]);
    }

    /**
     * Delete a file if it exists.
     */
    private function deleteFile(?string $filePath): void
    {
        if ($filePath && Storage::disk(config('base_urls.default_disk'))->exists($filePath)) {
            Storage::disk(config('base_urls.default_disk'))->delete($filePath);
        }
    }
}
