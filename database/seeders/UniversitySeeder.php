<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // load unis.json file and decode it to an array
        $unis = json_decode(file_get_contents(database_path('unis.json')), true);

        // insert each university into the universities table
        foreach ($unis as $uni) {
            $university = University::create([
                'name' => $uni['name'],
                'country' => $uni['country'],
                'homepage' => $uni['web_pages'][0],
            ]);

            // attach a random set of courses to the university
            $university->courses()->attach(
                Course::inRandomOrder()->take(rand(5, 10))->pluck('id')->toArray()
            );
        }
    }
}
