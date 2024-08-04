<?php
namespace App\Support;

use Sq\Employee\Models\CardInfo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCardInfo{

    public function card_info(): BelongsTo
    {
        return $this->belongsTo(CardInfo::class);
    }

}
