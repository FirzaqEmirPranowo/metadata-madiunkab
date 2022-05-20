<?php

namespace App\Imports;

use App\Models\Opd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class OpdImport implements ToModel, WithHeadingRow

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // HeadingRowFormatter::default('none');
    public function model(array $row)
    {
        $opd = Opd::create([
            'nama_opd'     => $row['Nama OPD'],
        ]);
        activity()->performedOn($opd)->log('Menambahkan OPD');
    }
}
