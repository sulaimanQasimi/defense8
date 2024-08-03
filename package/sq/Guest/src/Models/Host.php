<?php

namespace Sq\Guest\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Employee\Models\Department;

class Host extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function guests() : HasMany {
        return $this->hasMany(Guest::class);
    }
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
