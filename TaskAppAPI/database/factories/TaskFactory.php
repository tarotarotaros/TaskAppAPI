<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'task_name' => $this->faker->word,
            'content' => $this->faker->sentence,
            'priority' => $this->faker->numberBetween(1, 5),
            'created_by' => 'admin',
            'updated_by' => 'admin',
            'update_count' => 0,
        ];
    }
}
