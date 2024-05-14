<?php

namespace App\Models\Card;

use App\Models\Attendance;
use App\Models\Career;
use App\Models\Department;
use App\Models\Gate;
use App\Models\GuestOption;
use App\Models\PrintCardFrame;
use App\Models\Province;
use App\Models\District;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardInfo extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $casts = [
        'birthday' => 'date',
    ];
    protected $fillable = ['remark'];
    public function getJalaliBirthDateAttribute()
    {
        return verta($this->registered_at)->format("Y/m/d");

    }
    /**
     * Main Card
     */
    public function main_card(): HasOne
    {
        return $this->hasOne(MainCard::class);
    }
    /**
     * Armor Vehical Card
     */

    public function armor_vehical_card(): HasOne
    {
        return $this->hasOne(ArmorVehicalCard::class);
    }
    /**
     * Black Mirror Vehical Card
     */

    public function black_mirror_vehical_card(): HasOne
    {
        return $this->hasOne(BlackMirrorVehicalCard::class);
    }

    /**
     *  Employee Vehical Card
     */
    public function employee_vehical_card(): HasOne
    {
        return $this->hasOne(EmployeeVehicalCard::class);
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
    public function getImagePathAttribute()
    {
        return asset("storage/{$this->photo}");
    }
    public function getGateEnteredTodayAttribute()
    {
        return $this->one(Gate::class, 'cardinfo_gates')
            ->wherePivot('entered_at', '>=', now()->startOfDay())
            ->wherePivot('entered_at', '<=', now()->endOfDay())
            ->withPivot('entered_at', 'exit_at')
            ->withTimestamps()->first();
    }
    public function current_gate_attendance()
    {
        return $this->hasOne(Attendance::class)->where('date', now()->format('Y-m-d'));
    }
    public function getCurrentMonthPresentAttribute()
    {

        $start_month = Verta::startMonth()->format("Y-m-d");
        $end_month = Verta::endMonth()->format("Y-m-d");
        $database_start_month = Verta::parse($start_month)->toCarbon();
        $database_end_month = Verta::parse($end_month)->toCarbon();

        return $this->attendance()->whereBetween("date", [$database_start_month->format('Y-m-d'), $database_end_month->format('Y-m-d')])->where("state", 'P')->count();
    }
    public function getCurrentMonthUpsentAttribute()
    {

        $start_month = Verta::startMonth()->format("Y-m-d");
        $end_month = Verta::endMonth()->format("Y-m-d");
        $database_start_month = Verta::parse($start_month)->toCarbon();
        $database_end_month = Verta::parse($end_month)->toCarbon();

        return $this->attendance()->whereBetween("date", [$database_start_month->format('Y-m-d'), $database_end_month->format('Y-m-d')])->where("state", 'U')->count();
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
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


    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
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
        return $this->belongsTo(District::class, 'm_village');
    }

    public function current_village(): BelongsTo
    {
        return $this->belongsTo(District::class, 'c_village');
    }

}
