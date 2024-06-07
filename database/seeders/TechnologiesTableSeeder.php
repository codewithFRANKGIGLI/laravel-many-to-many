<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = [
        'HTML/CSS',
        'JavaScript',
        'React',
        'Angular',
        'Vue.js',
        'PHP',
        'Laravel',
        'Python',
        'C#',
        'Cisco',
        'SQL',
        'NoSQL',
        'Java',
        'Spring',
        'Hibernate',
        ];
        foreach ($technologies as $technology) {
            $newTechnology = new Technology();
            $newTechnology->name = $technology;
            // slug
            $newTechnology->slug = Str::slug($newTechnology->name, '-');
            $newTechnology->save();
        }
    }
}
