<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'category_id' => $this->faker->numberBetween(1, 10),
            'url' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'teacher_id' => $this->faker->numberBetween(1, 10),
            'max_students' => $this->faker->numberBetween(50, 200),
        ];
    }
}