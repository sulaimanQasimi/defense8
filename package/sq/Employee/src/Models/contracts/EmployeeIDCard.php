<?php
namespace Sq\Employee\Models\Contracts;
use Sq\Card\Models\PrintCard;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Sq\Employee\Models\EmployeeVehicalCard;
use Sq\Employee\Models\GunCard;
use Sq\Employee\Models\MainCard;
trait EmployeeIDCard
{
    /**
     * Main Card
     */
    public function main_card(): HasMany
    {
        return $this->hasMany(MainCard::class);
    }
    public function current_id_card()
    {
        return $this->hasOne(MainCard::class)->ofMany(['id' => 'max']);

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
    public function gun_card(): HasMany
    {
        return $this->hasMany(GunCard::class);
    }
    public function print_cards(): HasMany
    {
        return $this->hasMany(PrintCard::class);
    }

}
