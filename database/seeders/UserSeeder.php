<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('12345678'),
        ]);

        $superadmin->assignRole('superadmin');

        $walidata = User::create([
            'name' => 'Walidata',
            'email' => 'walidata@mail.com',
            'password' => bcrypt('12345678'),
        ]);

        $walidata->assignRole('walidata');

        $produsen = User::create([
            'name' => 'Produsen',
            'email' => 'produsen@mail.com',
            'password' => bcrypt('12345678'),
        ]);

        $produsen->assignRole('produsen');
    }
}
