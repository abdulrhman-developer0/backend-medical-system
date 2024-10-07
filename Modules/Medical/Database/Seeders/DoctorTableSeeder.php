<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Doctor;

class DoctorTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $doctors = collect([
            [
                'name' => 'د. أحمد الفارسي',
                'clinic_id' => 1,
                'available_times' => [
                    'mon' => '09:00 AM - 12:00 PM, 02:00 PM - 05:00 PM',
                    'tue' => 'NA',
                    'wed' => '10:00 AM - 01:00 PM',
                    'thu' => 'NA',
                    'fri' => '11:00 AM - 03:00 PM',
                    'sat' => 'NA',
                    'sun' => 'NA',
                ],
            ],
            [
                'name' => 'د. سارة محمد',
                'clinic_id' => 2,
                'available_times' => [
                    'mon' => 'NA',
                    'tue' => '09:30 AM - 11:30 AM, 04:00 PM - 06:00 PM',
                    'wed' => 'NA',
                    'thu' => '10:30 AM - 02:30 PM',
                    'fri' => 'NA',
                    'sat' => 'NA',
                    'sun' => 'NA',
                ],
            ],
            [
                'name' => 'د. عمر خالد',
                'clinic_id' => 1,
                'available_times' => [
                    'mon' => '08:00 AM - 11:00 AM',
                    'tue' => 'NA',
                    'wed' => '09:00 AM - 12:00 PM, 05:00 PM - 07:00 PM',
                    'thu' => 'NA',
                    'fri' => 'NA',
                    'sat' => '10:00 AM - 02:00 PM',
                    'sun' => 'NA',
                ],
            ],
            [
                'name' => 'د. ليلى ناصر',
                'clinic_id' => 3,
                'available_times' => [
                    'mon' => 'NA',
                    'tue' => '09:00 AM - 12:00 PM, 03:00 PM - 05:00 PM',
                    'wed' => 'NA',
                    'thu' => '10:00 AM - 01:00 PM',
                    'fri' => 'NA',
                    'sat' => '09:00 AM - 11:00 AM',
                    'sun' => 'NA',
                ],
            ],
            [
                'name' => 'د. فهد بن زايد',
                'clinic_id' => 2,
                'available_times' => [
                    'mon' => '10:00 AM - 01:00 PM',
                    'tue' => 'NA',
                    'wed' => '11:00 AM - 02:00 PM',
                    'thu' => 'NA',
                    'fri' => '09:00 AM - 12:00 PM',
                    'sat' => 'NA',
                    'sun' => 'NA',
                ],
            ],
        ]);

        $doctors->each(function ($doctorData) {
            $data = collect($doctorData)
                ->except(['available_times'])
                ->toArray();

            $doctor = Doctor::create($data);


            $doctor->availableTimes()->create(
                $doctorData['available_times']
            );
        });
    }
}
