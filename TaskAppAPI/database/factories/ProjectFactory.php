<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'is_complete' => false,
            'created_by' => 'test_user',
            'updated_by' => 'test_user',
            'update_count' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
