<?php

namespace Sq\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Village extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

}
