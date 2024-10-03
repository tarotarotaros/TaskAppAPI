<?php

namespace Database\Factories;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriorityFactory extends Factory
{
    protected $model = Priority::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
