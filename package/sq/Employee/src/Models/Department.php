<?php

namespace Sq\Employee\Models;

use Kalnoy\Nestedset\NodeTrait;
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
    use NodeTrait;
    protected static function boot()
    {
        parent::boot();

        
        // Power Check while Creating
        static::creating(
            function ($department) {
                if (!in_array($department->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );

        // Power Check while Updating
        static::updating(
            function ($department) {
                if (!in_array($department->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );



    }

    public function getParentIdName()
    {
        return 'department_id';
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
