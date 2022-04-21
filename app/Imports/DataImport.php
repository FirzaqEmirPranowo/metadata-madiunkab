<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;

class DataImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Data([
            'nama_data'     => $row[0],
            'opd_id'     => $row[1],
            'jenis_data'     => $row[2],
            'sumber_data'     => $row[3],
            'status_id'     => $row[4],
        ]);
    }
}
