<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkObserver
{
    private function generateQrCode(string $url, ?string $logo = null): string
    {
        $type = 'png';
        $uuid = Str::uuid()->toString() . '.' . $type;
        $filepath = 'link/'.date('Y') . '/' . date('m') . '/qr/' . $uuid;

        $qrCode = QrCode::size(500)
            ->format($type);

        if ($logo) {
            $qrCode->mergeString(Storage::disk(config('base_urls.default_disk'))->get($logo), 0.25);
        }

        $qr = $qrCode->generate($url);
        Storage::disk(config('base_urls.default_disk'))->put($filepath, $qr);

        return $filepath;
    }

    private function updateQrCodeImage(Link $link): void
    {
        $url = config('base_urls.base_link') . '/' . $link->url_slug;
        $filepath = $this->generateQrCode($url, $link->logo);
        $link->updateQuietly(['qr_code_image' => $filepath]);
    }

    private function deleteFileIfExists(?string $path): void
    {
        if ($path && Storage::disk(config('base_urls.default_disk'))->exists($path)) {
            Storage::disk(config('base_urls.default_disk'))->delete($path);
        }
    }

    public function created(Link $link): void
    {
        $this->updateQrCodeImage($link);
    }

    public function updated(Link $link): void
    {
        if ($link->isDirty('logo')) {
            $this->deleteFileIfExists($link->getOriginal('logo'));
        }

        $this->deleteFileIfExists($link->qr_code_image);
        $this->updateQrCodeImage($link);
    }

    public function deleted(Link $link): void
    {
        $this->deleteFileIfExists($link->logo);
        $this->deleteFileIfExists($link->qr_code_image);
    }

    public function restored(Link $link): void
    {
        //
    }

    public function forceDeleted(Link $link): void
    {
        //
    }
}
