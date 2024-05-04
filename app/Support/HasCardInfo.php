<?php
namespace App\Support;

use App\Models\Card\CardInfo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCardInfo{
 
    public function card_info(): BelongsTo
    {
        return $this->belongsTo(CardInfo::class);
    }
       
}