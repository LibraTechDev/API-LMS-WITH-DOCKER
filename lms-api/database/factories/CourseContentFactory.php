<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseContent>
 */
class CourseContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(6), // Judul Konten
            'description' => $this->faker->paragraph(), // Deskripsi
            'video_url' => $this->faker->optional()->url(), // URL Video (nullable)
            'file_attachment' => $this->faker->optional()->word() . '.pdf', // File (nullable)
            'course_id' => $this->faker->numberBetween(1, 10), 
            'parent_id' => null, // Induk (nullable)
        ];
    }
}