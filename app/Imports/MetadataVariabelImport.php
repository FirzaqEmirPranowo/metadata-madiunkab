<?php

namespace App\Imports;

use App\Models\MetadataVariabel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MetadataVariabelImport implements ToModel, WithMultipleSheets, WithStartRow
{

    public function sheets(): array
    {
        return [
            0 => new MetadataVariabelImport(),
        ];
    }

    public function heading()
    {

    }

    public function model(array $row)
    {
        return new MetadataVariabel([
            //
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}
