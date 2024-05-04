<?php

namespace App\Models;

use App\Models\Card\CardInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        "date" => 'date',
        'enter' => 'datetime',
        'exit' => 'datetime',
    ];
    public function card_info(): BelongsTo
    {
        return $this->belongsTo(CardInfo::class);
    }
    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class);
    }
    public function scopeShamsiMonth(Builder $query, $startmonth, $endmonth): void
    {
        $query->whereBetween('date', [$startmonth, $endmonth]);
    }
    public function getShamsiDayAttribute($value)
    {
        return verta($this->date)->format('d');
    }
    public function getLabelAttribute($value)
    {
        return ($this->state == "U") ? "غ" : "ح";
    }
}
