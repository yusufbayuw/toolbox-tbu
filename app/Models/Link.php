<?php

namespace App\Models;

use App\Observers\LinkObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(LinkObserver::class)]
class Link extends Model
{
    protected $casts = [
        'links' => 'json',
    ]; 
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(LinkTheme::class);
    }
}
