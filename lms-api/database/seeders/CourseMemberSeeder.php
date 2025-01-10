<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseMember;

class CourseMemberSeeder extends Seeder
{
    public function run()
    {
        CourseMember::factory()->count(10)->create();
    }
}