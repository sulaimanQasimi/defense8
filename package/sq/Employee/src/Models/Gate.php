<?php

namespace Sq\Employee\Models;

use Sq\Guest\Models\Guest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Sq\Query\Policy\UserDepartment;

class Gate extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Power Check while Creating
        static::creating(
            function ($gate) {
                if (!in_array($gate->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );

        // Power Check while Updating
        static::updating(
            function ($gate) {
                if (!in_array($gate->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );
    }
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class, 'guest_gate_passed')->withTimestamps();
    }
    public function cardInfos()
    {
        return $this->hasMany(CardInfo::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function scaned_employee(): HasMany
    {
        return $this->hasMany(related: ScanedEmployee::class);
    }
}
