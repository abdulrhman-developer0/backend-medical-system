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
                ['nameEn' => 'examination', 'nameAr' => 'كشف'],
                ['nameEn' => 'followUp', 'nameAr' => 'متابعة'],
                ['nameEn' => 'emergency', 'nameAr' => 'طوارئ'],
            ],
            'paymentTypes' => [
                ['nameEn' => 'cash', 'nameAr' => 'نقدا'],
                ['nameEn' => 'network', 'nameAr' => 'شبكة'],
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
                'complexName' => 'مجمع سندس الطبي',
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
