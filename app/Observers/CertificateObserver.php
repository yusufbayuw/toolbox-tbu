<?php

namespace App\Observers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;

class CertificateObserver
{
    /**
     * Handle the Certificate "created" event.
     */
    public function created(Certificate $certificate): void
    {
        //
    }

    /**
     * Handle the Certificate "updated" event.
     */
    public function updated(Certificate $certificate): void
    {

        // Handle file_tandatangan update
        if ($certificate->isDirty('file_tandatangan')) {
            $this->deleteFile($certificate->getOriginal('file_tandatangan'));
        }

        // Handle background_image update
        if ($certificate->isDirty('background_image')) {
            $this->deleteFile($certificate->getOriginal('background_image'));
        }
    }

    /**
     * Handle the Certificate "deleted" event.
     */
    public function deleted(Certificate $certificate): void
    {
        $this->deleteFile($certificate->file_tandatangan);
        $this->deleteFile($certificate->background_image);
    }

    /**
     * Handle the Certificate "restored" event.
     */
    public function restored(Certificate $certificate): void
    {
        //
    }

    /**
     * Handle the Certificate "force deleted" event.
     */
    public function forceDeleted(Certificate $certificate): void
    {
        //
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
