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
    protected function gun_render($context)
    {
        return Str::of($context)
            ->replace($this->gun_translated_field("gun_type"), $this->employee->gun_card?->gun_type)
            ->replace($this->gun_translated_field("gun_no"), $this->employee->gun_card?->gun_no)
            ->replace($this->gun_translated_field("range"), $this->employee->gun_card?->range)
            ->replace($this->gun_translated_field("gun_recieved_date"), ($this->employee->gun_card?->filled_form_date)?verta($this->employee->gun_card?->filled_form_date)->format("Y/m/d"):"")
        ;
    }
}
