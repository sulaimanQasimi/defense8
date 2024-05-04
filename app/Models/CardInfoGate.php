<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardInfoGate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='cardinfo_gates';
    protected $casts = [
        "entered_at"=> "datetime",
        "exit_at"=> "datetime",
    ];
    protected $guarded =[];
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class);
    }
}
