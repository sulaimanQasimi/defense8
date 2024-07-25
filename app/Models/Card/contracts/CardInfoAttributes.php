<?php
namespace App\Models\Card\Contracts;

use App\Models\Gate;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\LogOptions;

trait CardInfoAttributes
{

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
    public function getJalaliBirthDateAttribute()
    {
        return verta($this->registered_at)->format("Y/m/d");

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

}
