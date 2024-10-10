<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Doctor;
use Modules\User\Entities\User;

class DoctorTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $doctors = collect([
            [
                'name' => 'د. أحمد الفارسي',
                'clinic_id' => 1,
                'status' => 'active',
                'specialty_id' => 1, // Assuming this is the ID for 'الطبيب العام'
                'available_times' => [
                    'mon' => ['start' => '9:00 AM', 'end' => '5:00 PM'],
                    'tue' => ['start' => '9:00 AM', 'end' => '5:00 PM'],
                    'wed' => ['start' => 'NA', 'end' => 'NA'],
                    'thu' => ['start' => '9:00 AM', 'end' => '5:00 PM'],
                    'fri' => ['start' => 'NA', 'end' => 'NA'],
                    'sat' => ['start' => '9:00 AM', 'end' => '2:00 PM'],
                    'sun' => ['start' => 'NA', 'end' => 'NA'],
                ],
            ],
            [
                'name' => 'د. سارة محمد',
                'clinic_id' => 2,
                'status' => 'active',
                'specialty_id' => 2, // Assuming this is the ID for 'طبيب الأسنان'
                'available_times' => [
                    'mon' => ['start' => '8:00 AM', 'end' => '4:00 PM'],
                    'tue' => ['start' => '8:00 AM', 'end' => '4:00 PM'],
                    'wed' => ['start' => 'NA', 'end' => 'NA'],
                    'thu' => ['start' => '8:00 AM', 'end' => '4:00 PM'],
                    'fri' => ['start' => 'NA', 'end' => 'NA'],
                    'sat' => ['start' => '8:00 AM', 'end' => '2:00 PM'],
                    'sun' => ['start' => 'NA', 'end' => 'NA'],
                ],
            ],
            // Add other doctors similarly
        ]);

        $doctors->each(function ($doctorData) {
            $data = collect($doctorData)
                ->except(['available_times'])
                ->toArray();


            $doctor = Doctor::create($data);

            $user = User::factory()->create([
                'email' => "{$doctor->id}@domain.com",
                'type'  => 'doctor'
            ]);

            ;$doctor->user_id = $user->id;
            $doctor->save();

            $doctor->availableTimes()->create(
                $doctorData['available_times']
            );
        });
    }
}
