<?php

namespace Sq\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\CardInfoGate;

class District extends Model
{

    use HasFactory;
    use SoftDeletes;
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function Villages() : HasMany {
        return $this->hasMany(Village::class);
    }

    public function main_employee_address() :HasMany {
        return $this->hasMany(CardInfo::class,'m_district');
    }
    public function current_employee_address() :HasMany {
        return $this->hasMany(CardInfo::class,'c_district');
    }
}
