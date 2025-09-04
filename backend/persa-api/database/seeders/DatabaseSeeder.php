<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this ->call(RolesSeeder::class);
        $this ->call(CareerSeeder::class);
        $this ->call(CourseSeeder::class);
        $this ->call(LocationSeeder::class);
        $this ->call(PermissionTypeSeeder::class);
        $this ->call(InstructorCourseSeeder::class);
        $this ->call(ApprenticeCourseSeeder::class);
        $this ->call(PermissionSeeder::class);
    }
}
