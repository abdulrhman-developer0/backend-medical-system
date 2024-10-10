<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $settings = [
            'visitTypes' => [
                'examination' => ['nameEn' => 'examination' , 'nameAr' => 'كشف'],
                'followUp' => ['nameEn' => 'followUp' , 'nameAr' => 'متابعة'],
                'emergency' => ['nameEn' => 'emergency' , 'nameAr' => 'طوارئ'],
            ],
            // 'workingHours' => [
            //     'weekDays' => [
            //         'sunday' => 'الأحد',
            //         'monday' => 'الاثنين',
            //         'tuesday' => 'الثلاثاء',
            //         'wednesday' => 'الأربعاء',
            //         'thursday' => 'الخميس',
            //         'friday' => 'الجمعة',
            //         'saturday' => 'السبت',
            //     ],
            //     'workingDays' => ['thursday'],
            //     'hours' => '08:00 - 17:00',
            // ],
            'contactInformation' => [
                'phone' => '0123456789',
                'email' => 'info@clinic.com',
                'fax' => '0123456788',
            ],
            'invoiceSettings' => [
                'currency' => 'جنيه',
                'taxRate' => 15,
            ],
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'key'   => $key,
                'value' => $value,
            ]);
        }
    }
}
