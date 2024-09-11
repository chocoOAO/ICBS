<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RawWeight;

class RawWeightFactory extends Factory
{
    /**
     * The name of the model that this factory belongs to.
     *
     * @var string
     */
    protected $model = RawWeight::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'batchNumber' => $this->faker->bothify('G#########'), // 生成假的批號
            'Date' => $this->faker->date(),                        // 生成假的日期
            'time' => $this->faker->time('H:i:s'),                 // 生成假的時間
            'sid' => $this->faker->numberBetween(1, 100),          // 隨機 SID
            'sensorID' => $this->faker->numberBetween(1, 100),     // 隨機 Sensor ID
            'weight' => $this->faker->numberBetween(500, 3000)     // 隨機重量
        ];
    }
}
