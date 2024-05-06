<?php

namespace Database\Factories\Card;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardInfo>
 */
class CardInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            "name"=>$this->faker->name(),
            "last_name"=>$this->faker->name(),
            "father_name"=>$this->faker->name(),
            "grand_father_name"=>$this->faker->name(),
            "degree"=>$this->faker->name(),
            "grade"=>$this->faker->name(),
            "photo"=>$this->faker->name(),
            "acupation"=>$this->faker->name(),
            "registare_no"=>$this->faker->unique()->numberBetween(),
            "national_id"=>$this->faker->name(),
            "phone"=>$this->faker->name(),
           "birthday"=>$this->faker->date(),

            "job_structure"=>$this->faker->name(),
            "previous_job"=>$this->faker->name(),
            "department"=>$this->faker->name(),
            "m_village"=>$this->faker->name(),
            "m_district"=>$this->faker->name(),
            "m_province"=>$this->faker->name(),

            "c_village"=>$this->faker->name(),
            "c_district"=>$this->faker->name(),
            "c_province"=>$this->faker->name(),


        ];
    }
}
