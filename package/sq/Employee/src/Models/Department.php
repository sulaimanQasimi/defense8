<?php

namespace Sq\Employee\Models;

use Kalnoy\Nestedset\NodeTrait;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Sq\Guest\Models\Host;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Query\Policy\UserDepartment;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    use LogsActivity;
    use NodeTrait;
    protected static function boot()
    {
        parent::boot();

        // Power Check while Creating
        

        // Power Check while Updating
        static::updating(
            function ($department) {
                if (!in_array($department->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );
    }
    /**
     * Nested Loop
     * @return string
     */
    public function getParentIdName()
    {
        return 'department_id';
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(callback:
                fn(string $eventName): string => "This model has been {$eventName}");
    }

    /**
     * Parent Department of this department
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    /**
     * Sub Department of this Department
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }



    /**
     * Hosts of this Department
     */
    public function hosts(): HasMany
    {
        return $this->hasMany(Host::class);
    }


    public function gates(): HasMany
    {
        return $this->hasMany(Gate::class, 'department_id');
    }

    /**
     * Admin of this department
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
    /**
     * Each Department Have Employees
     */
    public function card_infos(): HasMany
    {
        return $this->hasMany(CardInfo::class);
    }
}
