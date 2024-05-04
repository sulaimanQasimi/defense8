<?php

namespace App\Models;

use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintCardFrame extends Model
{
    use HasFactory;
    use SoftDeletes;
 }
