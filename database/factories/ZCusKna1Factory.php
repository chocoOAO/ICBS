<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZCusKna1>
 */
class ZCusKna1Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'm_KUNAG' => Str::random(10),
            'm_NAME' => $this->faker->name(),
            'm_ADDSC' => $this->faker->address, // 生成随机地址
        ];
    }
}
