<?php

namespace Sq\Guest\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;

class Host extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($host) {
                if (!in_array($host->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );
        static::updating(
            function ($host) {
                if (!in_array($host->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );



    }
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
