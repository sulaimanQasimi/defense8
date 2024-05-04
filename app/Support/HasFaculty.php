<?php
namespace App\Support;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasFaculty{
    
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}