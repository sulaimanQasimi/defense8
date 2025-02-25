<?php

namespace App\Models;

use App\Models\Contracts\UserChatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Nova\Auth\Impersonatable;
use Laravel\Sanctum\HasApiTokens;
use Namu\WireChat\Traits\Chatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Sq\Employee\Models\Department;
use Sq\Employee\Models\Gate;
use Sq\Guest\Models\Host;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use HasRoles;
    use HasPermissions;
    use SoftDeletes;
    use Chatable;
    //    use TwoFactorAuthenticatable;
    // use NodeTrait;
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_seen_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {});
    }
    public function host(): HasOne
    {
        return $this->hasOne(Host::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id');
    }
    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class);
    }
    public function gates(): BelongsToMany
    {
        return $this->belongsToMany(Gate::class);
    }
    public function guest_allowed_doors(): BelongsToMany
    {
        return $this->belongsToMany(Gate::class,'user_guest_door');
    }
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
    public function isGate()
    {
        return $this->gate;
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function canImpersonate()
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Determine if the user can be impersonated.
     *
     * @return bool
     */
    public function canBeImpersonated()
    {
        return true;
    }

    public function canComment(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function canCreateChats(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function canCreateGroups(): bool
    {
        return $this->hasRole('super-admin');
    }
}
