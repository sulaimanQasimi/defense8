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
            'blood_group' => trans("Blood Group"),
            "main_province" => trans("Province"),
            "main_district" => trans("District"),
            "phone" => trans("Phone"),
            'special_gun' => "نوع سلاح برای کارت ویژه",
            'special_black_mirror' => "شیشه سیاه برای کارت ویژه",
            'special_vehical' => "نوع واسطه برای کارت ویژه",
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
            ->replace($this->info_translated_field('grand_father_name'), $this->employee->grand_father_name)
            ->replace($this->info_translated_field('department'), $this->employee->orginization?->fa_name)
            ->replace($this->info_translated_field('job_structure'), $this->employee->job_structure)
            ->replace($this->info_translated_field('national_id'), PrintCardField::ltr( $this->employee->national_id ))
            ->replace($this->info_translated_field('degree'), $this->employee->degree)
            ->replace($this->info_translated_field('birthday'), PrintCardField::ltr( ($this->employee?->birthday) ? verta($this->employee->birthday)->format("Y/m/d") : '' ))
            ->replace($this->info_translated_field('grade'), $this->employee->grade)
            ->replace($this->info_translated_field('registare_no'), PrintCardField::ltr( $this->employee->registare_no ))
            ->replace($this->info_translated_field('gate'), $this->employee->gate?->fa_name)


            /**
             * برای کارت های ویژه کارمندان ومقامات وزارت دفاع ملی
             */
            ->replace($this->info_translated_field('special_gun'), $this->employee->special_gun)
            ->replace($this->info_translated_field('special_black_mirror'), $this->employee->special_black_mirror)
            ->replace($this->info_translated_field('special_vehical'), $this->employee->special_vehical)


            // Unverfied Fields

            ->replace($this->info_translated_field('blood_group'), PrintCardField::ltr( match ($this->employee?->blood_group) {
                'OM' => 'O-',
                'OP' => 'O+',
                'AM' => 'A-',
                'AP' => 'A+',
                'BM' => 'B-',
                'BP' => 'B+',
                'ABM' => 'AB-',
                'ABP' => 'AB+',
                default => ''
            } ))

            ->replace($this->info_translated_field("main_province"), $this->employee?->main_province?->name)
            ->replace($this->info_translated_field("main_district"), $this->employee?->main_district?->name)

            ->replace($this->info_translated_field("phone"), PrintCardField::ltr( $this->employee->phone ))

        ;
    }
}
