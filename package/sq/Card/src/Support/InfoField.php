<?php
namespace Sq\Card\Support;

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
            "gate" => trans("Gate"),
        ];
    }
    private static function info_translated_field($field)
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
    protected function info_render($context)
    {
       return Str::of($context)
            ->replace($this->info_translated_field('name'), $this->employee->name)
            ->replace($this->info_translated_field('father_name'), $this->employee->father_name)
            ->replace($this->info_translated_field('last_name'), $this->employee->last_name)
            ->replace($this->info_translated_field('department'), $this->employee->orginization?->fa_name)
            ->replace($this->info_translated_field('job_structure'), $this->employee->job_structure)
            ->replace($this->info_translated_field('national_id'), $this->employee->national_id)
            ->replace($this->info_translated_field('degree'), $this->employee->degree)
            ->replace($this->info_translated_field('grade'), $this->employee->grade)
            ->replace($this->info_translated_field('registare_no'), $this->employee->registare_no)
            ->replace($this->info_translated_field('gate'), $this->employee->gate?->fa_name);
    }
}
