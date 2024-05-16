<?php

namespace App\Models;

use App\Support\Defense\GateEumn;
use App\Support\Defense\GateTranslationEnum;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Guest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $casts = [
        'registered_at' => "datetime",
        'enter_at' => "date",
        'exit_at' => "date",

    ];
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(
            function ($guest) {
                if (auth()->user()->host) {
                    $guest->host_id = auth()->user()->host->id;
    
                    $guest->save();

                    $fetch = Guest::query()->where("year", now()->year)->orderBy("day", 'desc')->first();

                    $guest->year = now()->year;

                    $day = ($fetch) ? $fetch->day + 1 : 1;
                    $guest->day = $day;
                    $len = strlen($day);
                    $guest->barcode = "G-" . now()->format("Ym") . str_pad($day, 9 - $len, "0", STR_PAD_LEFT);

                    $guest->save();
                }
            }
        );
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }
    public function Guestoptions(): BelongsToMany
    {
        return $this->belongsToMany(GuestOption::class, 'guest_option_related');
    }
    public function guestGate(): HasMany
    {
        return $this->hasMany(GuestGate::class);
    }
    public function currentGate(): HasOne
    {
        return $this->hasOne(GuestGate::class)->where('gate_id', auth()->user()->gate->id);
    }

    public function EnterGate(): HasOne
    {
        return $this->hasOne(GuestGate::class)
            ->whereHas('gate', function ($query) {
                $query->where('level', 1)
                    ->whereNotNull('entered_at');
            });
    }


    public function ExitGate(): HasOne
    {
        return $this->hasOne(GuestGate::class)
            ->whereHas('gate', function ($query) {
                $query->where('level', 1)
                    ->whereNotNull('exit_at');
            });
    }


    protected function getStatusAttribute()
    {
        return !$this->registered_at->isBefore(Carbon::today());
    }

    public function getGateTranslationAttribute()
    {
        if ($this->enter_gate === GateEumn::Kalid) {
            return GateTranslationEnum::Kalid;
        }

        if ($this->enter_gate === GateEumn::Obaeda) {
            return GateTranslationEnum::Obaeda;
        }

        if ($this->enter_gate === GateEumn::SideWalk) {
            return GateTranslationEnum::SideWalk;
        }

        if ($this->enter_gate === GateEumn::Exit ) {
            return GateTranslationEnum::Exit;
        }
    }
    public function getJalaliComeDateAttribute()
    {
        return verta($this->registered_at)->format("Y/m/d");

    }

    public function getJalaliComeTimeAttribute()
    {
        return verta($this->registered_at)->format("h:i a");

    }
}
