<?php

namespace Sq\Card\Support;

use Illuminate\Support\Str;

trait GunCardField
{
    private static function gun_field(): array
    {
        return [
            'gun_type' => trans("Gun Type"),
            'gun_no' => trans("Gun No"),
            'range' => trans("Gun Range"),
            'gun_recieved_date' => trans("Gun Recieved Date"),
            'gun_register_date'=>'تاریخ اجرا کارت اسلحه',
            'gun_expire_date'=>'تاریخ ختم کارت اسلحه',
        ];
    }
    protected static function gun_translated_field($field)
    {
        return Str::of(self::gun_field()[$field])->wrap("{", "}");
    }
    public static function gun_allowed_field(): string
    {
        return implode(' ', array_map([self::class, 'gun_translated_field'], array_keys(self::gun_field())));
    }
    protected function gun_render($context)
    {
        return Str::of($context)
            ->replace($this->gun_translated_field("gun_type"), $this->employee->gun_card?->gun_type)
            ->replace($this->gun_translated_field("gun_no"), $this->employee->gun_card?->gun_no)
            ->replace($this->gun_translated_field("range"), $this->employee->gun_card?->range)
            ->replace($this->gun_translated_field("gun_recieved_date"), ($this->employee->gun_card?->filled_form_date) ? verta($this->employee->gun_card?->filled_form_date)->format("Y/m/d") : "")
            ->replace($this->gun_translated_field("gun_register_date"), ($this->employee->gun_card?->register_date) ? verta($this->employee->gun_card?->register_date)->format("Y/m/d") : "")
            ->replace($this->gun_translated_field("gun_expire_date"), ($this->employee->gun_card?->expire_date) ? verta($this->employee->gun_card?->expire_date)->format("Y/m/d") : "")
        ;
    }
}
