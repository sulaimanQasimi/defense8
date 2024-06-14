<?php
namespace Card\Contracts;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use Illuminate\Support\Str;

trait GunCardField
{
    private static function gun_field(): array
    {
        return [
            "gun_type" => __("Gun Type"),
            "gun_no" => __("Gun No"),
            "range" => __("Gun Range"),
            "gun_recieved_date" => __("Gun Recieved Date"),
        ];
    }

    protected static function gun_translated_field($field)
    {
        return Str::of(self::gun_field()[$field])->wrap("{", "}");
    }
    public static function gun_allowed_field(): string
    {
        $text = "";
        foreach (self::gun_field() as $field => $value) {
            $text .= self::gun_translated_field($field) . " ";
        }
        return $text;
    }
}
