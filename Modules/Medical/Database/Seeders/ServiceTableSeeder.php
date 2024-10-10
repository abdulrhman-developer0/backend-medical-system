<?php

namespace Modules\Medical\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Medical\Entities\Service;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $services = [
            [
                'name' => 'قياس سكر',
                'price' => 20,
                'description' => 'اختبار مستوى السكر في الدم.'
            ],
            [
                'name' => 'قياس ضغط',
                'price' => 20,
                'description' => 'قياس ضغط الدم.'
            ],
            [
                'name' => 'إبرة خارجية',
                'price' => 25,
                'description' => 'إجراء حقن خارجية.'
            ],
            [
                'name' => 'تخريم بدون حلق',
                'price' => 35,
                'description' => 'تخريم الأذن بدون استخدام حلقة.'
            ],
            [
                'name' => 'تخريم مع حلق',
                'price' => 60,
                'description' => 'تخريم الأذن مع استخدام حلقة.'
            ],
            [
                'name' => 'تنظيف جرح',
                'price' => 120,
                'description' => 'تنظيف الجروح لإزالة الأوساخ.'
            ],
            [
                'name' => 'غيار جرح مع خياطة غرزة واحدة',
                'price' => 150,
                'description' => 'تغيير الضمادة لجروح مع غرزة واحدة.'
            ],
            [
                'name' => 'غيار جرح مع خياطة غرزتين',
                'price' => 200,
                'description' => 'تغيير الضمادة لجروح مع غرزتين.'
            ],
            [
                'name' => 'قياس طول',
                'price' => 20,
                'description' => 'قياس الطول بدقة.'
            ],
            [
                'name' => 'قياس وزن',
                'price' => 20,
                'description' => 'قياس الوزن بدقة.'
            ],
            [
                'name' => 'فحص فصيلة',
                'price' => 60,
                'description' => 'فحص فصيلة الدم.'
            ],
            [
                'name' => 'معالجة الجروح والتقرحات',
                'price' => 250,
                'description' => 'علاج الجروح والتقرحات الجلدية.'
            ],
            [
                'name' => 'فك غرزة واحدة',
                'price' => 50,
                'description' => 'إزالة غرزة واحدة من الجرح.'
            ],
            [
                'name' => 'فك غرزتين',
                'price' => 120,
                'description' => 'إزالة غرزتين من الجرح.'
            ],
            [
                'name' => 'تخطيط قلب',
                'price' => 200,
                'description' => 'إجراء تخطيط كهربائي للقلب.'
            ],
        ];



        Service::insert($services);
    }
}
