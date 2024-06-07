<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Str
use Illuminate\Support\Str;
// model type
use App\Models\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['WebDevelopment', 'MobileAppDevelopment', 'E-commerceDevelopment','SoftwareDevelopment', 'IT_Consulting','Data_Analysis','Cybersecurity', 'UI/UX_Design','DigitalMarketing'];
        foreach ($types as $typeName) {
            $newType = new Type();
            $newType->name = $typeName;
            $newType->slug = Str::slug($newType->name, '-');
            $newType->save();
        }
    }
}