<?php

namespace App\Observers;

use App\Models\CardHolder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CardHolderObserver
{
    public function created(CardHolder $cardHolder): void
    {
        $cardHolder->uuid = $cardHolder->id.Str::uuid()->toString();
        $cardHolder->uuid_val = $cardHolder->id.Str::uuid()->toString();

        $type = 'png';
        $filename = $cardHolder->uuid_val.'.'.$type;
        $filepath = 'card/'.date('Y').'/'.date('m').'/qr/'.$filename;

        $qrCode = QrCode::size(500)->format($type);
        $qr = $qrCode->generate(config('base_urls.base_card_val').'/'.$cardHolder->uuid_val);
        Storage::disk(config('base_urls.default_disk'))->put($filepath, $qr);

        $cardHolder->qrcode_val = $filepath;
        $cardHolder->saveQuietly();
    }

    public function updated(CardHolder $cardHolder): void
    {
        if ($cardHolder->isDirty('foto')) {
            $this->deleteFile($cardHolder->getOriginal('foto'));
        }
    }

    public function deleted(CardHolder $cardHolder): void
    {
        $this->deleteFile($cardHolder->foto);
        $this->deleteFile($cardHolder->qrcode_val);
    }

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk(config('base_urls.default_disk'))->exists($path)) {
            Storage::disk(config('base_urls.default_disk'))->delete($path);
        }
    }
}
