<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\CertificateParticipant;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateParticipantObserver
{
    /**
     * Handle the CertificateParticipant "created" event.
     */
    public function created(CertificateParticipant $certificateParticipant): void
    {
        $certificateParticipant->uuid = $certificateParticipant->id.Str::uuid()->toString();
        $certificateParticipant->uuid_val = $certificateParticipant->id.Str::uuid()->toString();

        // Generate a unique QR code value
        $type = 'png';
        $uuid = $certificateParticipant->uuid_val;
        $filepath = 'cert/'.date('Y') . '/' . date('m') . '/qr/' . $uuid;

        $qrCode = QrCode::size(500)
            ->format($type);

        $qr = $qrCode->generate(config('base_urls.base_cert_val').'/'.$certificateParticipant->uuid_val);
        Storage::disk(config('base_urls.default_disk'))->put($filepath, $qr);

        // Save the QR code path to the model
        $certificateParticipant->qrcode_val = $filepath;

        $certificateParticipant->saveQuietly();


    }

    /**
     * Handle the CertificateParticipant "updated" event.
     */
    public function updated(CertificateParticipant $certificateParticipant): void
    {
        //
    }

    /**
     * Handle the CertificateParticipant "deleted" event.
     */
    public function deleted(CertificateParticipant $certificateParticipant): void
    {
        //
    }

    /**
     * Handle the CertificateParticipant "restored" event.
     */
    public function restored(CertificateParticipant $certificateParticipant): void
    {
        //
    }

    /**
     * Handle the CertificateParticipant "force deleted" event.
     */
    public function forceDeleted(CertificateParticipant $certificateParticipant): void
    {
        //
    }
}
