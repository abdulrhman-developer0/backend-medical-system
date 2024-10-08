<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MedicalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            SettingTableSeeder::class,
            NationalityTableSeeder::class,
            SpecialtySeederTableSeeder::class,
            ServiceTableSeeder::class,
            ClinicTableSeeder::class,
            DoctorTableSeeder::class,
        ]);
    }
}
