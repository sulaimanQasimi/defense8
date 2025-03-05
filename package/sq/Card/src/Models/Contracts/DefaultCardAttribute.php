<?php

namespace Sq\Card\Models\Contracts;

class DefaultCardAttribute
{

    public static function attribute(): array
    {
        return [
            'barCode' => [
                'x' => 0,
                'y' => 0,
                'z' => 0
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
            'page' => [
                'height' => 210,
                'width' => 297,
                'dim' => 'vertical'
            ],
            'vehicalImage'=>[
                'path' => null,
                'size' => null,
                'x' => null,
                'y' => null,
            ]
        ];
    }
}
