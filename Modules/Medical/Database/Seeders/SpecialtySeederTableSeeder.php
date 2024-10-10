<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Specialty;

class SpecialtySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $specialties = [
            ['name' => 'الطبيب العام', 'examination_cost' => 50],
            ['name' => 'طبيب الأسنان', 'examination_cost' => 60],
            ['name' => 'اخصائي الباطنة', 'examination_cost' => 100],
            ['name' => 'اخصائي الأطفال', 'examination_cost' => 100],
            ['name' => 'اخصائي جراحة عامة', 'examination_cost' => 100],
            ['name' => 'اخصائي النساء والولادة', 'examination_cost' => 100],
        ];

        Specialty::insert($specialties);
    }
}
