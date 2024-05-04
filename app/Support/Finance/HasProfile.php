<?php
namespace App\Support\Finance;

use App\Models\Finance\AccountingAdministrationIncome;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasProfile{
    
    public function profile() :MorphOne {
        return  $this->morphOne(AccountingAdministrationIncome::class,'incomable');
      }
}