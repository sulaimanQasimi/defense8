<?php

namespace App\Models;

use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OilDisterbution extends Model
{
    use HasFactory;
    use HasCardInfo;
    protected $guarded=[];
    protected $casts =[
        "filled_date"=> "date",
    ];
}
