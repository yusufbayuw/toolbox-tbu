<?php

namespace App\Models;

use App\Observers\CardObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(CardObserver::class)]
class Card extends Model
{
    public function holders(): HasMany
    {
        return $this->hasMany(CardHolder::class);
    }
}
