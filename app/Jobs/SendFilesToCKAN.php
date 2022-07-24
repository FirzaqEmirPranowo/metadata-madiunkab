<?php

namespace App\Jobs;

use App\Services\CkanApi\Facades\CkanApi;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        foreach ($this->data->berkas as $berkas) {
            $res = CkanApi::resource()->create([
                'package_id' => $this->datasetId,
                'upload' => Storage::get($berkas->path),
                'name' => $berkas->name,
                'format' => MimeType::fromFilename($berkas->name)
            ]);

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
