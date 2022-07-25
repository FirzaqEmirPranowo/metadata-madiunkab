<?php

namespace App\Http\Controllers\Walidata;

use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use App\Jobs\PurgeTmpFiles;
use App\Jobs\SendFilesToCKAN;
use App\Models\Data;
use App\Services\CkanApi\Facades\CkanApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use ZipArchive;

class PublikasiController extends Controller
{
    public function index()
    {
        $data = Data::whereIn('status_id', [Data::STATUS_SIAP_PUBLIKASI, Data::STATUS_TERPUBLIKASI])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->with(['opd', 'status', 'publikasi'])
            ->latest()
            ->get();

        return view('pages.contents.walidata.publikasi.index', compact('data'));
    }

    public function organisasi($id)
    {
        $data = Data::with(['publikasi'])->findOrFail($id);
        $orgs = CkanApi::organization()->all(['limit' => 1000]);
        $orgs = $orgs['result'] ?? [];

        return view('pages.contents.walidata.publikasi.organisasi', compact('data', 'orgs'));
    }

    public function createOrganisasi(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string',
            'org_desc' => 'nullable|string'
        ]);

        $res = CkanApi::organization()->show($request->org_name);

        if (isset($res['success']) && $res['success']) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'OPD/Organisasi sudah tersedia di CKAN')
            ]);
        }

        $res = CkanApi::organization()->create([
            'name' => Str::slug($request->get('org_name')),
            'title' => $request->get('org_name', ''),
            'description' => $request->get('org_desc', '')
        ]);

        if (isset($res['result'])) {
            return redirect()->back()->with([
                Alert::success('Berhasil', 'OPD/Organisasi berhasil ditambahkan ke CKAN')
            ]);
        }

        return redirect()->back()->with([
            Alert::error('Gagal', 'OPD/Organisasi gagal ditambahkan di CKAN')
        ]);
    }

    public function simpanOrganisasi($id, Request $request)
    {
        $request->validate([
            'org_id' => 'required|uuid'
        ]);

        $res = CkanApi::organization()->show($request->org_id);
        if (isset($res['success']) && !$res['success']) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'OPD/Organisasi tidak tersedia pada CKAN')
            ]);
        }

        $data = Data::findOrFail($id);

        if ($data->status_id != Data::STATUS_SIAP_PUBLIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Status data belum siap untuk dipublikasi')
            ]);
        }

        $data->publikasi()->updateOrCreate(
            ['data_id' => $data->id],
            ['org_id' => $request->org_id]
        );

        Alert::success('Berhasil', 'Organisasi berhasil dipilih');

        return redirect()->back();
    }

    public function dataset($id)
    {
        $data = Data::with('publikasi')->findOrFail($id);
        $orgs = CkanApi::organization()->all(['limit' => 1000]);
        $orgs = $orgs['result'] ?? [];

        return view('pages.contents.walidata.publikasi.dataset', compact('data', 'orgs'));
    }

    public function simpanDataset($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'visibility' => 'required|numeric|in:0,1'
        ]);

        $data = Data::findOrFail($id);

        if ($data->status_id != Data::STATUS_SIAP_PUBLIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Status data belum siap untuk dipublikasi')
            ]);
        }

        $data->publikasi()->updateOrCreate(
            ['data_id' => $data->id],
            [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'visibility' => $request->get('visibility')
            ]
        );

        Alert::success('Berhasil', 'Informasi dataset berhasil disimpan');

        return redirect()->back();
    }

    public function review($id)
    {
        $data = Data::with(['publikasi', 'berkas'])->findOrFail($id);
        $orgs = CkanApi::organization()->all(['limit' => 1000]);
        $orgs = $orgs['result'] ?? [];

        return view('pages.contents.walidata.publikasi.review', compact('data', 'orgs'));
    }

    public function publish($id)
    {
        $data = Data::with(['publikasi', 'opd'])->findOrFail($id);

        if ($data->status_id != Data::STATUS_SIAP_PUBLIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Status data belum siap untuk dipublikasi')
            ]);
        }

        if (empty($data->publikasi) || empty($data->publikasi->org_id)) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Data publikasi kosong')
            ]);
        }

        $dataset = CkanApi::dataset()->create([
            'owner_org' => $data->publikasi->org_id,
            'title' => $data->publikasi->title,
            'name' => $slug = Str::slug($data->publikasi->title),
            'url' => $slug,
            'notes' => $data->publikasi->description,
            'private' => $data->publikasi->visibility == 0,
        ]);

        if (empty($dataset['result']) || (isset($dataset['success']) && !$dataset['success'])) {
            Log::error('Gagal publikasi data: '. json_encode($dataset), ['Publikasi']);

            $errorMsg = isset($dataset['error']) && isset($dataset['error']['name']) ? implode(PHP_EOL, $dataset['error']['name']) : '';
            return redirect()->back()->with([
                Alert::error('Gagal', 'Gagal mempublikasi data, Response ckan tidak valid: ' . $errorMsg)
            ]);
        }

        $data->publikasi->update([
            'dataset_id' => $dataset['result']['id'],
            'published_at' => now(),
            'slug' => $slug,
        ]);
        $data->update([
            'status_id' => Data::STATUS_TERPUBLIKASI
        ]);

        SendFilesToCKAN::dispatch($data, $dataset['result']['id']);

        return redirect()->back()->with([
            Alert::success('Berhasil', 'Data berhasil dipublikasi ke CKAN.')
        ]);
    }

    public function exportData($id)
    {
        $data = Data::with(['opd', 'berkas', 'standar', 'status'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn ($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if ($data->status_id != Data::STATUS_TERPUBLIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Data belum terpublikasi')
            ]);
        }

        if (in_array(strtolower($data->jenis_data), ['variabel', 'indikator'])) {
            $data->with(strtolower($data->jenis_data));
        }

        $export = new DataExport($data);

        if ($data->berkas->isEmpty()) {
            return Excel::download($export, $data->name . '.xlsx', \MaatWebsite\Excel\Excel::XLSX);
        }

        Excel::store($export, 'exports/data-' . $data->id . '.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);
        $filePath = Storage::path('exports/data-' . $data->id . '.xlsx');

        $archive = new ZipArchive();
        $tmpArchivePath = Storage::path('tmp/data-'. $data->id . '.tmp');
        Storage::makeDirectory('tmp');
        file_put_contents($tmpArchivePath, NULL);

        if ($archive->open($tmpArchivePath, ZipArchive::CREATE) !== TRUE) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Gagal membuat berkas zip')
            ]);
        }

        $archive->addFile($filePath, 'Informasi Data.xlsx');
        foreach ($data->berkas as $berkas) {
            $archive->addFile(Storage::path($berkas->path), 'berkas/' . $berkas->name);
        }
        $archive->close();

        PurgeTmpFiles::dispatch([$filePath, $tmpArchivePath])->delay(now()->addHours(2));

        return response()->file($tmpArchivePath, [
            'Content-Type' => 'application/x-zip',
            'Content-Disposition' => 'attachment; filename="' . $data->nama_data . '.zip"',
        ]);
    }
}
