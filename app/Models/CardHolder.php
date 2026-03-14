<?php

namespace App\Models;

use App\Observers\CardHolderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(CardHolderObserver::class)]
class CardHolder extends Model
{
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
