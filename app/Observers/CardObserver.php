<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Facades\Storage;

class CardObserver
{
    public function updated(Card $card): void
    {
        if ($card->isDirty('file_tandatangan')) {
            $this->deleteFile($card->getOriginal('file_tandatangan'));
        }

        if ($card->isDirty('background_front')) {
            $this->deleteFile($card->getOriginal('background_front'));
        }

        if ($card->isDirty('background_back')) {
            $this->deleteFile($card->getOriginal('background_back'));
        }
    }

    public function deleted(Card $card): void
    {
        $this->deleteFile($card->file_tandatangan);
        $this->deleteFile($card->background_front);
        $this->deleteFile($card->background_back);
    }

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk(config('base_urls.default_disk'))->exists($path)) {
            Storage::disk(config('base_urls.default_disk'))->delete($path);
        }
    }
}
