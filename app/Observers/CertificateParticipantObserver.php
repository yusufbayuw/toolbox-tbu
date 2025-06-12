<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\CertificateParticipant;

class CertificateParticipantObserver
{
    /**
     * Handle the CertificateParticipant "created" event.
     */
    public function created(CertificateParticipant $certificateParticipant): void
    {
        $certificateParticipant->uuid = $certificateParticipant->id.Str::uuid()->toString();
        $certificateParticipant->uuid_val = $certificateParticipant->id.Str::uuid()->toString();
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
