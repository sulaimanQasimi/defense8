<?php
namespace Card\Contracts;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use Illuminate\Support\Str;

trait InfoField
{

    private static function info_field(): array
    {
        return [
            "name" => trans("Name"), // Done
            "last_name" => trans("Last Name"), //Done
            "father_name" => trans("Father Name"),
            "grand_father_name" => trans("Grand Father Name"),
            "degree" => trans("Degree"),
            "grade" => trans("Grade"),
            "registare_no" => trans("Register No"),
            "national_id" => trans("National ID"),

            "birthday" => trans("Date of Birth"),
            "job_structure" => trans("Job Stracture Title"),
            "department" => trans("Department"),
            //
            "gate" => trans("Gate"),
            //
            "card_perform" => __("Preform Date"),
            "card_expired_date" => __("Expire Date"),
            //
            "gun_type" => __("Gun Type"),
            "gun_no" => __("Gun No"),
            "range" => __("Gun Range"),
            "gun_recieved_date"=>__("Gun Recieved Date"),
       ];
    }
    protected static function info_translated_field($field)
    {
        return Str::of(self::info_field()[$field])->wrap("{", "}");
    }
    public static function info_allowed_field(): string
    {
        $text = "";
        foreach (self::info_field() as $field => $value) {
            $text .= self::info_translated_field($field) . " ";
        }
        return $text;
    }
}
