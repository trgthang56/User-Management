<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 30; $i++){
            Task::factory()->create([
                'name' => fake()->sentence(),
                'user_id' => collect(range(1, 200))->random(fake()->numberBetween(1, 10))->implode(','),
                'description' => fake()->text(),
                'status' => fake()->randomElement(['0', '1', '2']),
                'estimation' => fake()->numberBetween(1, 10),
                'effort' => fake()->numberBetween(1, 10),
                'start_date' => fake()->dateTimeBetween('2024-01-01', '2024-12-31'),
                'end_date' => fake()->dateTimeBetween('2024-01-01', '2024-12-31'),
                'created_by' => 1,
            ]);
        }
    }
}
