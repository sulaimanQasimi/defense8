<?php

namespace Sq\Employee\Models;

use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sq\Employee\Models\Gate;

class ScanedEmployee extends Model
{
    use HasFactory;
    use HasCardInfo;
    protected $guarded = [];
    protected $casts = [
        'scaned_at' => 'datetime'
    ];
    public function gate(): BelongsTo
    {
        return $this->belongsTo(related: Gate::class);
    }
}
