<?php

namespace App\Imports;

use App\Models\MetadataVariabel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MetadataVariabelImport implements ToModel, WithMultipleSheets, WithStartRow
{
    private int $dataId;

    public function __construct($dataId)
    {
        $this->dataId = $dataId;
    }

    public function sheets(): array
    {
        return [
            new MetadataVariabelImport($this->dataId),
        ];
    }

    public function model(array $row)
    {
        return MetadataVariabel::updateOrCreate(
            [
                'data_id' => $this->dataId
            ],
            [
                'data_id' => $this->dataId,
                'nama' => $row[1],
                'alias' => $row[2],
                'konsep' => $row[3],
                'definisi' => $row[4],
                'referensi_pemilihan' => $row[5],
                'referensi_waktu' => $row[6],
                'tipe_data' => strtolower($row[7] ?? ''),
                'ukuran' => $row[8],
                'satuan' => $row[9],
                'klasifikasi_isian' => $row[10],
                'aturan_validasi' => $row[11],
                'kalimat_pertanyaan' => $row[12],
                'umum' => $row[13] ? ($row[13] == 1 ? 1 : 0) : 0
            ]
        );
    }

    public function uniqueBy(): string
    {
        return 'nama';
    }

    public function startRow(): int
    {
        return 3;
    }
}
