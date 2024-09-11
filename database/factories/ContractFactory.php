<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'm_KUNAG' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'm_NAME' => $this->faker->text,
            'name_b' => $this->faker->name(). '-代',
            'type' => $this->faker->numberBetween(1, 3),
            'begin_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'bank_name' => $this->faker->name(), // Ensure this line is correct
            'bank_branch' => $this->faker->text,
            'bank_account' => $this->faker->bankAccountNumber,
            'salary' => $this->faker->randomFloat(2, 0, 10000),
            'office_tel' => $this->faker->phoneNumber,
            'home_tel' => $this->faker->phoneNumber,
            'mobile_tel' => $this->faker->phoneNumber,
            'memo1' => $this->faker->sentence,
            'memo2' => $this->faker->sentence,
            'creator' => $this->faker->userName,
            'last_editor' => $this->faker->userName,
            'modified_log' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
