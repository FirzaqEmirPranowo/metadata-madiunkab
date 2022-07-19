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
        $cek_opd = Opd::select('id')->where('nama_opd', '=', $row['OPD'])->first();

        if (!$cek_opd) {
            throw new \Exception('OPD tidak ditemukan');
        }
        $existingData = Data::where('opd_id', $cek_opd->id)->where('nama_data', $row['Nama Data'])->first();
        if ($existingData) {
            throw new \Exception('Data dengan nama tersebut sudah terdapat pada sistem');
        }

        $data = Data::create([
            'nama_data'     => $row['Nama Data'],
            'opd_id'     => $cek_opd->id,
            'jenis_data'     => $row['Jenis Data'],
            'sumber_data'     => $row['Sumber data'],
            'status_id'     => Data::STATUS_DRAFT,
            'user_id'     => auth()->id(),

        ]);

        activity()->performedOn($data)->log('Import Daftar Data');

        return $data;
    }
}
