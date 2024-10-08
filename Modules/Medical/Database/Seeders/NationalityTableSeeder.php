<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Nationality;

class NationalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Nationality::insert([
            ['name' => 'السعودية'],
            ['name' => 'الإمارات'],
            ['name' => 'الكويت'],
            ['name' => 'البحرين'],
            ['name' => 'قطر'],
            ['name' => 'عمان'],
            ['name' => 'بروناي'],
            ['name' => 'مصر'],
            ['name' => 'الجزائر'],
            ['name' => 'المغرب'],
            ['name' => 'تونس'],
            ['name' => 'ليبيا'],
            ['name' => 'السودان'],
            ['name' => 'تشاد'],
            ['name' => 'جزر القمر'],
            ['name' => 'جنوب أفريقيا'],
            ['name' => 'كينيا'],
            ['name' => 'نيجيريا'],
            ['name' => 'إثيوبيا'],
            ['name' => 'ماليزيا'],
            ['name' => 'إندونيسيا'],
            ['name' => 'الفلبين'],
            ['name' => 'فرنسا'],
            ['name' => 'ألمانيا'],
            ['name' => 'إيطاليا'],
            ['name' => 'إسبانيا'],
            ['name' => 'البرتغال'],
            ['name' => 'المملكة المتحدة'],
            ['name' => 'هولندا'],
            ['name' => 'بلجيكا'],
            ['name' => 'سويسرا'],
            ['name' => 'النمسا'],
            ['name' => 'الدنمارك'],
            ['name' => 'النرويج'],
            ['name' => 'السويد'],
            ['name' => 'فنلندا'],
            ['name' => 'أيرلندا'],
        ]);
    }
}
