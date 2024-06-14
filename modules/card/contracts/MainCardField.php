<?php
namespace Card\Contracts;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use Illuminate\Support\Str;

trait MainCardField
{

    private static function main_field(): array
    {
        return [
            "card_perform" => __("Preform Date"),
            "card_expired_date" => __("Expire Date"),
            "gun_type" => __("Gun Type"),
            "gun_no" => __("Gun No"),
            "range" => __("Gun Range"),
            "gun_recieved_date"=>__("Gun Recieved Date"),
       ];

    }

    protected static function main_translated_field($field)
    {
        return Str::of(self::info_field()[$field])->wrap("{", "}");
    }
    public static function main_allowed_field(): string
    {
        $text = "";
        foreach (self::main_field() as $field => $value) {
            $text .= self::main_translated_field($field) . " ";
        }
        return $text;
    }
}
