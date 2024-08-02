<?php
namespace Sq\Card\Support;

use Illuminate\Support\Str;

trait MainCardField
{

    private static function main_field(): array
    {
        return [
            "card_perform" => __("Preform Date"),
            "card_expired_date" => __("Expire Date"),
        ];

    }

    private static function main_translated_field($field)
    {
        return Str::of(self::main_field()[$field])->wrap("{", "}");
    }
    public static function main_allowed_field(): string
    {
        $text = "";
        foreach (self::main_field() as $field => $value) {
            $text .= self::main_translated_field($field) . " ";
        }
        return $text;
    }
    protected function main_render(string $context): string
    {
        return Str::of($context)
            ->replace($this->main_translated_field('card_perform'), ($this->employee->main_card?->card_perform) ? verta($this->employee->main_card?->card_perform)->format("Y/m/d") : "N/A")
            ->replace($this->main_translated_field('card_expired_date'), ($this->employee->main_card?->card_expired_date) ? verta($this->employee->main_card?->card_expired_date)->format("Y/m/d") : "N/A");
    }
}
