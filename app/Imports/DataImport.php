<?php

namespace App\Imports;

use App\Models\Data;
use App\Models\Opd;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DataImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DataImport(),
        ];
    }

    public function model(array $row)
    {
        if (!isset($row['OPD'])) {
            throw new \Exception('Data tidak valid');
        }

        $cek_opd = Opd::select('id')->where('nama_opd', '=', $row['OPD'])->first();

        if (!$cek_opd) {
            throw new \Exception('OPD '. $row['OPD']  .' tidak ditemukan');
        }

        $existingData = Data::where('opd_id', $cek_opd->id)->where('nama_data', $row['Nama Data'])->first();
        if ($existingData) {
            throw new \Exception('Data dengan nama '. $row['Nama Data']  . '  sudah terdapat pada sistem');
        }

        $data = Data::create([
            'nama_data'     => $row['Nama Data'],
            'opd_id'     => $cek_opd->id,
            'jenis_data'     => $row['Jenis Data'],
            'sumber_data'     => $row['Sumber data'],
            'status_id'     => Data::STATUS_DRAFT,
            'user_id'     => auth()->id(),

        ]);

        activity()
            ->causedBy(auth()->id())
            ->performedOn($data)
            ->log('mengimport data');

        return $data;
    }
}
