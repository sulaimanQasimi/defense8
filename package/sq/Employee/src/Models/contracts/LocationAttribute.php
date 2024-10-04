<?php
namespace Sq\Employee\Models\Contracts;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sq\Location\Models\District;
use Sq\Location\Models\Province;
use Sq\Location\Models\Village;
trait LocationAttribute
{

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
}
