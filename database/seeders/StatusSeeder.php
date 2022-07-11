<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;


class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'status' => 'Setuju',

        ]);

        Status::create([
            'status' => 'Tolak',

        ]);

        Status::create([
            'status' => 'Draf',

        ]);

        Status::create([
            'status' => 'Proses Verifikasi'
        ]);
        Status::create([
           'status' => 'Revisi'
        ]);
        Status::create([
            'status' => 'Selesai Verifikasi'
        ]);
        Status::create([
            'status' => 'Terpublikasi'
        ]);
    }
}
