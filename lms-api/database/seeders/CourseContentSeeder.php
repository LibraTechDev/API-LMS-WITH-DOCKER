<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseContent;

class CourseContentSeeder extends Seeder
{
    public function run()
    {
        CourseContent::factory()->count(10)->create();
    }
}