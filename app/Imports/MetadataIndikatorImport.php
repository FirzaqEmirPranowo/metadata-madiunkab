<?php

namespace App\Imports;

use App\Models\MetadataIndikator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MetadataIndikatorImport implements ToModel, WithMultipleSheets, WithStartRow
{
    private int $dataId;

    public function __construct($dataId)
    {
        $this->dataId = $dataId;
    }

    public function sheets(): array
    {
        return [
            new MetadataIndikatorImport($this->dataId),
        ];
    }

    public function uniqueBy(): string
    {
        return 'nama';
    }

    public function model(array $row)
    {
        return MetadataIndikator::updateOrCreate(
            [
                'data_id' => $this->dataId
            ],
            [
                'data_id' => $this->dataId,
                'nama' => $row[1],
                'konsep' => $row[2],
                'definisi' => $row[3],
                'interpretasi' => $row[4],
                'metode' => $row[5],
                'ukuran' => $row[6],
                'satuan' => $row[7],
                'klasifikasi_penyajian' => $row[8],
                'komposit' => $row[9] == 1 ? 1 : 0,
                'publikasi_indikator_pembangun' => $row[10],
                'nama_indikator_pembangun' => $row[11],
                'nama_variabel_pembangun' => $row[12],
                'level_estimasi' => $this->formatLevelEstimasi($row[13]),
                'umum' => $row[14] == 1 ? 1 : 0,
            ]
        );
    }

    private function formatLevelEstimasi($level)
    {
        if (empty($level)) {
            return -1;
        }

        return strtolower(trim($level));
    }

    public function startRow(): int
    {
        return 4;
    }
}
