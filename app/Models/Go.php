<?php

namespace App\Models;

use App\Observers\GoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(GoObserver::class)]
class Go extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
