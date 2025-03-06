<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;

class SubjectFactory extends Factory
{
    protected $model = Subject::class; // Ensure model is assigned

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('SUB###'),
            'subject_code' => $this->faker->unique()->bothify('SC###'),
            'subject_description' => $this->faker->sentence(3),
            'units' => $this->faker->numberBetween(2, 5),
        ];
    }
}
