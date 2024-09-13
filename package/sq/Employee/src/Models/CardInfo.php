<?php

namespace Sq\Employee\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Sq\Guest\Models\GuestOption;
use Sq\Card\Models\PrintCardFrame;
use Sq\Employee\Models\Contracts\CardInfoAttributes;
use Sq\Employee\Models\Contracts\EmployeeOilDisterbutionAttributes;
use Sq\Location\Models\Province;
use Sq\Location\Models\District;
use Sq\Location\Models\Village;
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

class CardInfo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use CardInfoAttributes;
    use EmployeeOilDisterbutionAttributes;
    protected $casts = [
        'birthday' => 'date',
    ];
    protected $appends = [
        'current_month_oil_consumtion',
        'current_month_oil_remain',
    ];
    protected $fillable = ['remark'];

    /**
     * Main Card
     */
    public function main_card(): HasOne
    {
        return $this->hasOne(MainCard::class);
    }
    /**
     *  Employee Vehical Card
     */
    public function employee_vehical_card(): HasMany
    {
        return $this->hasMany(EmployeeVehicalCard::class);
    }

    
    /**
     *  Gun Card
     */
    public function gun_card(): HasOne
    {
        return $this->hasOne(GunCard::class);
    }


    /**
     *
     */
    public function employeeOptions(): BelongsToMany
    {
        return $this->belongsToMany(GuestOption::class, 'employee_option_related');
    }
    public function current_gate_attendance()
    {
        return $this->hasOne(Attendance::class)->where('date', now()->format('Y-m-d'));
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
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
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function PrintCardFrame(): MorphToMany
    {
        return $this->morphToMany(PrintCardFrame::class, 'print_card_frame', 'printables');
    }

    public function main_province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'm_province', 'id');
    }
    public function current_province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'c_province');
    }
    public function main_district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'm_district');
    }

    public function current_district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'c_district');
    }
    public function main_village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'm_village');
    }

    public function current_village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'c_village');
    }
    public function oil_disterbutions(): HasMany
    {
        return $this->hasMany(\Sq\Oil\Models\OilDisterbution::class);
    }
    public function current_month_oil_disterbutions(): HasMany
    {
        return $this->hasMany(\Sq\Oil\Models\OilDisterbution::class)
        ->whereBetween('filled_date',[
            // Verta::->toCarbon()
            Carbon::parse(Verta::parse(Verta::startMonth())->toCarbon())->startOfDay(),
            Carbon::parse(Verta::parse(Verta::endMonth())->toCarbon())->endOfDay(),

        ]);
    }

}
