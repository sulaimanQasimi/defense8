<?php

namespace Sq\Card\Models;

use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
                    $card->attr = [
                        'barCode' => [
                            'x' => null,
                            'y' => null,
                            'z' => null
                        ],
                        'backImage' => null,
                        'ministry' => [
                            'fontSize' => null,
                            'fontFamily' => null,
                            'title' => null,
                            'path' => null,
                            'x' => null,
                            'y' => null,
                            'size' => null,
                        ],
                        'government' => [
                            'fontFamily' => null,
                            'fontSize' => null,
                            'title' => null,
                            'path' => null,
                            'x' => null,
                            'y' => null,
                            'size' => null,
                        ],
                        'profile' => [
                            'path' => 'logo.png',
                            'size' => null,
                            'x' => null,
                            'y' => null,

                        ],
                        'signature' => [
                            'path' => null,
                            'size' => null,
                            'x' => null,
                            'y' => null,

                        ],
                        "header" => [
                            'backgroundColor' => null
                        ],
                        'content' => [
                            'background' => null,
                            'fontColor' => null,
                            'fontSize' => null,
                        ],
                        'qrcode' => [
                            'x' => null,
                            'y' => null,
                            'size' => null,
                            "width" => 128,
                            "height" => 128,
                            "colorDark" => "#000000",
                            "colorLight" => "#ffffff",
                            "correctLevel" => "QRCode.CorrectLevel.H",
                        ],
                    ];
                    $card->ip_address = config('app.url');
                    $card->save();
                }
            }
        );
    }
}
