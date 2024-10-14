<?php

namespace Database\Factories;

use App\Models\Assignee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssigneeFactory extends Factory
{
    protected $model = Assignee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
