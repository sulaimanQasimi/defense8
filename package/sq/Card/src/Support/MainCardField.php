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
            "muthanna"=>__("Muthanna")
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

        ->replace($this->main_translated_field('muthanna'), ($this->mainCard?->muthanna) ? __("Muthanna") : '')

        ->replace($this->main_translated_field('card_perform'), ($this->mainCard?->card_perform) ? verta($this->mainCard?->card_perform)->format("Y/m/d") : "N/A")

            ->replace($this->main_translated_field('card_expired_date'), ($this->mainCard?->card_expired_date) ? verta($this->mainCard?->card_expired_date)->format("Y/m/d") : "N/A");
    }
}
