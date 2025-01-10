<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseMember>
 */
class CourseMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'course_id' => $this->faker->numberBetween(1, 10), // Relasi dengan course
            'user_id' => $this->faker->numberBetween(11, 20),    // Relasi dengan user
            'roles' => $this->faker->randomElement(['std', 'ast']), // Peran (std = student, ast = assistant)
        ];
    }
}