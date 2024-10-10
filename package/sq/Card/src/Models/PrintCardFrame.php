<?php

namespace Sq\Card\Models;

use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sq\Card\Models\Contracts\DefaultCardAttribute;

class PrintCardFrame extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'attr' => 'array',
    ];
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();

        static::created(
            function ($card) {
                if (is_null($card->attr)) {
                    $card->attr = DefaultCardAttribute::attribute();
                    $card->ip_address = config('app.url');
                    $card->save();
                }
            }
        );
    }
}
