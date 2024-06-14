<?php
namespace Card;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use Illuminate\Support\Str;

final class PrintCardField
{

    public function __construct(private Employee $employee, private Frame $frame)
    {

    }


    private function replace(string $context): string
    {
        return Str::of($context)
            ->replace($this->translateField('name'), $this->employee->name)
            ->replace($this->translateField('father_name'), $this->employee->father_name)
            ->replace($this->translateField('last_name'), $this->employee->last_name)
            ->replace($this->translateField('department'), $this->employee->orginization?->fa_name)
            ->replace($this->translateField('job_structure'), $this->employee->job_structure)
            ->replace($this->translateField('national_id'), $this->employee->national_id)
            ->replace($this->translateField('degree'), $this->employee->degree)

            ->replace($this->translateField('grade'), $this->employee->grade)
            ->replace($this->translateField('registare_no'), $this->employee->registare_no)


            ->replace($this->translateField('card_perform'), ($this->employee->main_card?->card_perform) ? verta($this->employee->main_card?->card_perform)->format("Y/m/d") : "N/A")
            ->replace($this->translateField('card_expired_date'), ($this->employee->main_card?->card_expired_date) ? verta($this->employee->main_card?->card_expired_date)->format("Y/m/d") : "N/A")
            // Gate
            ->replace($this->translateField('gate'), $this->employee->gate?->fa_name)
            ->replace($this->translateField("gun_type"),'')
            ->replace($this->translateField("gun_no"),"")
            ->replace($this->translateField("range"),"")
            ->replace($this->translateField("gun_recieved_date"),"")




        ;
    }

    public function __get($name)
    {
        if ($name == 'details') {
            return $this->replace($this->frame->details);
        }
        if ($name == 'remark') {
            return $this->replace($this->frame->remark);
        }
    }


    private static function field(): array
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
    public static function translateField($field)
    {
        return Str::of(self::field()[$field])->wrap("{", "}");
    }
    public static function allowedField(): string
    {
        $text = "";
        foreach (self::field() as $field => $value) {
            $text .= self::translateField($field) . " ";
        }
        return $text;
    }
}
