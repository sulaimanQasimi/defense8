<?php

namespace Sq\Card\Support;

use Illuminate\Support\Carbon;
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
            'gun_register_date' => 'تاریخ اجرا کارت اسلحه',
            'gun_expire_date' => 'تاریخ ختم کارت اسلحه',
        ];
    }
    protected static function gun_translated_field($field)
    {
        return Str::of(self::gun_field()[$field])->wrap("{", "}");
    }
    /**
     * Summary of gun_allowed_field
     * @return string
     */
    public static function gun_allowed_field(): string
    {
        return implode(' ', array_map([self::class, 'gun_translated_field'], array_keys(self::gun_field())));
    }
    /**
     * Summary of gun_render
     * @param mixed $context
     * @param mixed $gun
     * @return \Illuminate\Support\Stringable
     */
    protected function gun_render($context, $gun = null)
    {
        return Str::of($context)
            ->replace($this->gun_translated_field("gun_type"), $gun?->gun_type)
            ->replace($this->gun_translated_field("gun_no"), PrintCardField::ltr($gun?->gun_no))
            ->replace($this->gun_translated_field("range"), $gun?->range)
            ->replace($this->gun_translated_field("gun_recieved_date"), PrintCardField::ltr(($gun?->filled_form_date) ? verta($gun?->filled_form_date)->format("Y/m/d") : ""))

            ->replace($this->gun_translated_field("gun_register_date"), PrintCardField::ltr(($gun?->register_date) ? Carbon::make($gun?->register_date)->format("Y/m/d") : ""))
            ->replace($this->gun_translated_field("gun_expire_date"), PrintCardField::ltr(($gun?->expire_date) ? Carbon::make($gun?->expire_date)->format("Y/m/d") : ""));
    }
}
