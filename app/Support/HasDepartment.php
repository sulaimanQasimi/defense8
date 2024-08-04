<?php
namespace App\Support;

use Sq\Employee\Models\Department;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDepartment{

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
