<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // load courses.csv and insert into courses table
        $file = fopen(database_path('courses.csv'), 'r');
        $header = fgetcsv($file);
        while ($row = fgetcsv($file)) {
            $row = array_combine($header, $row);
            Course::factory()->create($row);
        }
    }
}
