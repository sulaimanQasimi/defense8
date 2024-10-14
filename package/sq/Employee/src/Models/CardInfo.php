<?php

namespace Sq\Employee\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Builder;
use Sq\Employee\Models\Contracts\AttendanceRelationship;
use Sq\Employee\Models\Contracts\EmployeeIDCard;
use Sq\Employee\Models\Contracts\LocationAttribute;
use Sq\Guest\Models\GuestOption;
use Sq\Card\Models\PrintCardFrame;
use Sq\Employee\Models\Contracts\CardInfoAttributes;
use Sq\Employee\Models\Contracts\EmployeeOilDisterbutionAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Sq\Query\Policy\UserDepartment;

class CardInfo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use CardInfoAttributes;
    use LocationAttribute;
    use EmployeeOilDisterbutionAttributes;
    use EmployeeIDCard;
    use AttendanceRelationship;
    protected $casts = [
        'birthday' => 'date',
    ];
    // protected $appends = [
    //     'current_month_oil_consumtion',
    //     'current_month_oil_remain',
    // ];
    protected $fillable = ['remark'];
    protected static function boot()
    {
        parent::boot();

        // Power Check while Creating
        static::creating(
            function ($cardinfo) {
                if (!in_array($cardinfo->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );

        static::created(
            function ($cardinfo) {
                $cardinfo->confirmed = false;
                $cardinfo->save();
            }
        );
        // Power Check while Updating
        static::updating(
            function ($cardinfo) {
                if (!in_array($cardinfo->department_id, UserDepartment::getUserDepartment())) {
                    return abort(403);
                }
            }
        );
    }


    /**
     *
     */
    public function employeeOptions(): BelongsToMany
    {
        return $this->belongsToMany(GuestOption::class, 'employee_option_related');
    }
    public function scaned_employee(): HasMany
    {
        return $this->hasMany(related: ScanedEmployee::class);
    }
    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function orginization(): BelongsTo
    {
        return $this->belongsTo(related: Department::class, foreignKey: 'department_id');
    }
    public function PrintCardFrame(): MorphToMany
    {
        return $this->morphToMany(related: PrintCardFrame::class, name: 'print_card_frame', table: 'printables');
    }

    public function oil_disterbutions(): HasMany
    {
        return $this->hasMany(related: \Sq\Oil\Models\OilDisterbution::class);
    }
    public function current_month_oil_disterbutions(): HasMany
    {
        return $this->hasMany(related: \Sq\Oil\Models\OilDisterbution::class)
            ->whereBetween('filled_date', [
                Carbon::parse(Verta::parse(Verta::startMonth())->toCarbon())->startOfDay(),
                Carbon::parse(Verta::parse(Verta::endMonth())->toCarbon())->endOfDay(),
            ]);
    }

}
