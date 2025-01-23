<?php

namespace Sq\Employee\Models;


use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    // use HasUuids;
	protected $fillable=[
	"card_perform",
	"card_expired_date",
	];
    protected $casts = [
        "card_second_date" => 'date',
        "card_perform" => 'date',
        "card_expired_date" => 'date',
        'printed_at'=>'date'
    ];
}
