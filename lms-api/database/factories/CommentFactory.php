<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseMember;
use App\Models\CourseContent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'content_id' => $this->faker->numberBetween(1, 10), // Relasi dengan course content
            'member_id' => $this->faker->numberBetween(1, 10), // Relasi dengan course member
            'comment' => $this->faker->sentence(3), // Isi komentar
        ];
    }
}