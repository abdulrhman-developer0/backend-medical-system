<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::Factory()->create([
            'email'  => "admin@domain.com",
            'type'   => 'admin'
        ]);

        User::factory()->create([
            'email'  => "reception@domain.com",
            'type'   => 'reception'
        ]);
    }
}
