<?php
namespace Card\Contracts;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Support\Str;

trait VehicalCardField
{

    private static function vehical_field(): array
    {
        return [
            "vehical_type" => trans("Vehical Type"),
            "vehical_colour" => trans("Vehical Colour"),
            "vehical_palete" => trans("Vehical Palete"),
            "vehical_chassis" => trans("Vehical Chassis"),
            "vehical_model" => trans("Vehical Model"),
            "vehical_owner" => trans("Vehical Owner"),
            "vehical_engine_no" => trans("Vehical Engine NO"),
            "vehical_registration_no" => trans("Vehical Registration NO"),
            'driver_name'=>trans("Driver Name"),
            'driver_last_name'=>trans("Driver Last Name"),
            'driver_registare_no'=>trans("Driver ID")
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
    protected function vehical_render(string $context): string
    {
        return Str::of($context)
            // Vehical Infos
            ->replace($this->vehical_translated_field('vehical_type'), $this->employee->employee_vehical_card?->vehical_type)
            ->replace($this->vehical_translated_field('vehical_colour'), $this->employee->employee_vehical_card?->vehical_colour)
            ->replace($this->vehical_translated_field('vehical_palete'), $this->employee->employee_vehical_card?->vehical_palete)
            ->replace($this->vehical_translated_field('vehical_chassis'), $this->employee->employee_vehical_card?->vehical_chassis)
            ->replace($this->vehical_translated_field('vehical_model'), $this->employee->employee_vehical_card?->vehical_model)
            ->replace($this->vehical_translated_field('vehical_owner'), $this->employee->employee_vehical_card?->vehical_owner)
            ->replace($this->vehical_translated_field('vehical_engine_no'), $this->employee->employee_vehical_card?->vehical_engine_no)
            ->replace($this->vehical_translated_field('vehical_registration_no'), $this->employee->employee_vehical_card?->vehical_registration_no)
            // Driver Infos
            ->replace($this->vehical_translated_field('driver_name'), $this->employee->employee_vehical_card?->driver?->name)
            ->replace($this->vehical_translated_field('driver_last_name'), $this->employee->employee_vehical_card?->driver?->last_name)
            ->replace($this->vehical_translated_field('driver_registare_no'), $this->employee->employee_vehical_card?->driver?->registare_no)
        ;
    }
}
