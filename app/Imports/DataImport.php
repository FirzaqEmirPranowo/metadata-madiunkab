<?php

namespace App\Imports;

use App\Models\Data;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DataImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cek_opd = Opd::select('id')->where('nama_opd', '=', $row['OPD'])->get();
        $hasil =  $cek_opd[0]->id;
        $user_id =  Auth::user()->id;
        // dd($user_id);
        $status = 3;
        $data = Data::create([
            'nama_data'     => $row['Nama Data'],
            'opd_id'     => $hasil,
            'jenis_data'     => $row['Jenis Data'],
            'sumber_data'     => $row['Sumber data'],
            'status_id'     => $status,
            'user_id'     => $user_id,

        ]);
        activity()->performedOn($data)->log('Menambahkan Daftar Data');
    }
}
