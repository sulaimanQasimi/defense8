<?php

namespace Sq\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Employee\Models\CardInfo;

class Province extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function districts() : HasMany {
        return $this->hasMany(District::class);
    }
    public function Villages() : HasManyThrough {
        return $this->hasManyThrough(Village::class,District::class);
    }
    public function main_employee_address() :HasMany {
        return $this->hasMany(CardInfo::class,'m_province');
    }
    public function current_employee_address() :HasMany {
        return $this->hasMany(CardInfo::class,'c_province');
    }
}
