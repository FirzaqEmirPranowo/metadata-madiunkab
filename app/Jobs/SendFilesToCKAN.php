<?php

namespace App\Jobs;

use App\Exports\DataExport;
use App\Services\CkanApi\Facades\CkanApi;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SendFilesToCKAN implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $datasetId;

    public function __construct($data, $datasetId)
    {
        $this->data = $data;
        $this->datasetId = $datasetId;
    }

    public function handle()
    {
        $export = new DataExport($this->data);
        if (Excel::store($export, 'exports/data-' . $this->data->id . '.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX)) {
            CkanApi::resource()->create([
                'package_id' => $this->datasetId,
                'upload' => Storage::get('exports/data-' . $this->data->id . '.xlsx'),
                'name' => 'Metadata.xlsx',
                'format' => 'XLSX',
            ]);
        }

        foreach ($this->data->berkas as $berkas) {
            $res = CkanApi::resource()->create(array_filter([
                'package_id' => $this->datasetId,
                'upload' => Storage::get($berkas->path),
                'name' => $berkas->name,
                'format' => $ext = pathinfo($berkas->name, PATHINFO_EXTENSION),
                'mimetype' => MimeType::fromExtension($ext)
            ]));

            if (isset($res['result'])) {
                $berkas->update([
                    'resource_id' => $res['result']['id']
                ]);
            } else {
                Log::error('Failed to upload file to ckan' . $berkas->id, [json_encode($res)]);
            }
        }
    }
}
