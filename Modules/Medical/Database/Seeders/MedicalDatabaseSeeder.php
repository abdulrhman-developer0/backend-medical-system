<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Clinic;

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
            NationalityTableSeeder::class,
            ClinicTableSeeder::class,
            DoctorTableSeeder::class,
        ]);
    }
}
