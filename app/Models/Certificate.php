<?php

namespace App\Models;

use App\Observers\CertificateObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(CertificateObserver::class)]
class Certificate extends Model
{
    public function participant(): HasMany
    {
        return $this->hasMany(CertificateParticipant::class);
    }
}
