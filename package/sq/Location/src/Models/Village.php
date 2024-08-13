<?php

namespace Sq\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Employee\Models\CardInfo;

class Village extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function main_employee_address() :HasMany {
        return $this->hasMany(CardInfo::class,'m_village');
    }
    public function current_employee_address() :HasMany {
        return $this->hasMany(CardInfo::class,'c_village');
    }
}
