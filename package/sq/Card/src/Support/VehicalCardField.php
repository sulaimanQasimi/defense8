<?php
namespace Sq\Card\Support;

use Illuminate\Support\Str;

trait VehicalCardField
{

    private static function vehical_field(): array
    {
        return [
            'vehical_type' => trans("Vehical Type"),
            'vehical_colour' => trans("Vehical Colour"),
            'vehical_palete' => trans("Vehical Palete"),
            'vehical_chassis' => trans("Vehical Chassis"),
            'vehical_model' => trans("Vehical Model"),
            'vehical_owner' => trans("Vehical Owner"),
            'vehical_engine_no' => trans("Vehical Engine NO"),
            'vehical_registration_no' => trans("Vehical Registration NO"),
            'driver_name'=>trans("Driver Name"),
            'driver_last_name'=>trans("Driver Last Name"),
            'driver_registare_no'=>trans("Driver ID"),
            'register_date'=>trans("Disterbute Date"),
            'expire_date'=>trans("Expire Date"),
        ];
    }
    private static function vehical_translated_field($field)
    {
        return Str::of(self::vehical_field()[$field])->wrap("{", "}");
    }
    public static function vehical_allowed_field(): string
    {
        $text = "";
        foreach (self::vehical_field() as $field => $value) {
            $text .= self::vehical_translated_field($field) . " ";
        }
        return $text;
    }
    protected function vehical_render(string $context,$vehical = null ): string
    {
        return Str::of($context)
            // Vehical Infos
            ->replace($this->vehical_translated_field('vehical_type'), $vehical?->vehical_type)
            ->replace($this->vehical_translated_field('vehical_colour'), $vehical?->vehical_colour)
            ->replace($this->vehical_translated_field('vehical_palete'), $vehical?->vehical_palete)
            ->replace($this->vehical_translated_field('vehical_chassis'), $vehical?->vehical_chassis)
            ->replace($this->vehical_translated_field('vehical_model'), $vehical?->vehical_model)
            ->replace($this->vehical_translated_field('vehical_owner'), $vehical?->vehical_owner)
            ->replace($this->vehical_translated_field('vehical_engine_no'), $vehical?->vehical_engine_no)
            ->replace($this->vehical_translated_field('vehical_registration_no'), $vehical?->vehical_registration_no)
            // Driver Infos
            ->replace($this->vehical_translated_field('driver_name'), $vehical?->driver?->name)
            ->replace($this->vehical_translated_field('driver_last_name'), $vehical?->driver?->last_name)
            ->replace($this->vehical_translated_field('driver_registare_no'), $vehical?->driver?->registare_no)
            ->replace($this->vehical_translated_field('register_date'), ($vehical?->register_date)? verta($vehical->register_date)->format("Y/m/d"):'')
            ->replace($this->vehical_translated_field('expire_date'), ($vehical?->expire_date)? verta($vehical->expire_date)->format("Y/m/d"):'')
        ;
    }
}
