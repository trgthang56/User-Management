<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'user_id' => collect(range(1, 200))->random($this->faker->numberBetween(1, 10))->implode(','),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(['0', '1', '2']),
            'estimation' => $this->faker->numberBetween(1, 10),
            'effort' => $this->faker->numberBetween(1, 10),
            'start_date' => $this->faker->dateTimeBetween('2024-01-01', '2024-12-31'),
            'end_date' => $this->faker->dateTimeBetween('2024-01-01', '2024-12-31'),
        ];
    }
}
