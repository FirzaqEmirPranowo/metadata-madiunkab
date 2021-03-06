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
        collect([
            'Setuju',
            'Tolak',
            'Draf',
            'Proses Pengumpulan',
            'Lengkap',
            'Proses Verifikasi',
            'Revisi',
            'Siap Publikasi',
            'Terpublikasi'
        ])->map(fn ($status) => Status::create(compact('status')));
    }
}
