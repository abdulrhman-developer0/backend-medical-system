<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Clinic;

class ClinicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Clinic::insert([
            ['name' => 'عيادة طب الأطفال'],
            ['name' => 'عيادة الأسنان'],
            ['name' => 'عيادة الأمراض الباطنية'],
            ['name' => 'عيادة الأمراض الجلدية'],
            ['name' => 'عيادة النساء والتوليد'],
            ['name' => 'عيادة الطب العام'],
            ['name' => 'عيادة جراحة العظام'],
            ['name' => 'عيادة النفسية'],
        ]);
    }
}
