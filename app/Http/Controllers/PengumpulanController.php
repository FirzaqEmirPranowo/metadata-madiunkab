<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use App\Imports\MetadataIndikatorImport;
use App\Imports\MetadataVariabelImport;
use App\Models\Berkas;
use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Indonesia\Models\Province;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PengumpulanController extends Controller
{
    public function pengumpulan()
    {
        $data = Data::whereIn('status_id', [Data::STATUS_SETUJU, Data::STATUS_REVISI])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->with(['opd', 'status', 'berkas', 'indikator', 'variabel', 'standar', 'kegiatan'])
            ->latest()
            ->get();

        return view('pages.contents.produsen.pengumpulan.index', compact('data'));
    }

    public function detailData($id)
    {
        $data = Data::with(['opd', 'berkas'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if ($data->status_id == Data::STATUS_REVISI) {
            $data->load('verifikasi');
        }

        $existingBerkas = $data->berkas->map(function ($b) use ($data) {
            return [
                'name' => $b->name,
                'size' => $b->size,
                'previewUrl' => route('filepreview', ['payload' => Crypt::encryptString($b->path)]),
                'deleteUrl' => route('delete-berkas', [$data->id, $b->id]),
            ];
        })->toArray();

        if (!in_array($data->status_id, [Data::STATUS_SETUJU, Data::STATUS_BELUM_LENGKAP, Data::STATUS_REVISI, Data::STATUS_SIAP_PUBLIKASI])) {
            return redirect()->back()->with('errors', 'Status Data belum selesai');
        }

        return view('pages.contents.produsen.pengumpulan.edit-data', compact('data', 'existingBerkas'));
    }

    public function standarData($id, Request $request)
    {
        $data = Data::with(['opd', 'standar'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if ($request->filled('definisi')) {
            $validated = $request->validate([
                'konsep' => 'required|string',
                'definisi' => 'required|string',
                'klasifikasi' => 'required|string',
                'ukuran' => 'required|string',
                'satuan' => 'required|string'
            ]);

            $data->standar()->updateOrCreate(
                ['data_id' => $data->id],
                array_merge(['data_id' => $data->id], $validated)
            );

            $data->refresh();

            Alert::success('Berhasil', 'Standar data berhasil disimpan');
        }

        return view('pages.contents.produsen.pengumpulan.standar', compact('data'));
    }

    public function uploadBerkas($id, Request $request)
    {
        $request->validate([
            'berkas' => 'required|file'
        ]);

        $data = Data::when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))->findOrFail($id);

        if ($data->status_id != Data::STATUS_SETUJU && $data->status_id != Data::STATUS_REVISI) {
            return response()->json(['message' => 'invalid'], 403);
        }

        $fileName = date('Ymdhis') . '-' . $request->file('berkas')->getClientOriginalName();
        $storedPath = $request->file('berkas')->storeAs('berkas', $fileName);

        if (!$storedPath) {
            return response([], 500);
        }

        $berkas = $data->berkas()->create([
            'name' => $fileName,
            'size' => Storage::size($storedPath),
            'path' => $storedPath
        ]);

        return response()->json([
            'name' => $berkas->name,
            'size' => $berkas->size
        ]);
    }

    public function deleteBerkas($dataId, $berkasId)
    {
        $berkas = Berkas::findOrFail($berkasId);

        if (Storage::exists($berkas->path)) {
            $berkas->delete();
            Storage::delete($berkas->path);
        }

        return response()->noContent();
    }

    public function metadata($id)
    {
        $data = Data::when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))->findOrFail($id);

        if (in_array(strtolower($data->jenis_data), ['variabel', 'indikator'])) {
            $data->with(strtolower($data->jenis_data));
        }

        return view('pages.contents.produsen.pengumpulan.' . strtolower($data->jenis_data), compact('data'));
    }

    public function indikator($id)
    {
        $data = Data::with(['indikator', 'standar'])->findOrFail($id);

        if ($data->status_id == Data::STATUS_REVISI) {
            $data->load('verifikasi');
        }

        return view('pages.contents.produsen.pengumpulan.form-indikator', compact('data'));
    }

    public function importIndikator($id, Request $request)
    {
        $data = Data::findOrFail($id);

        $indikatorData = Excel::toCollection(new MetadataIndikatorImport($data->id), $request->file('metadata'));

        $meta = data_get($indikatorData, '0.0', []);
        if ($meta->count() < 12) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Berkas excel tidak valid. Data kosong! Pastikan Anda menggunakan template yang sudah disediakan')
            ]);
        }

        $import = new MetadataIndikatorImport($data->id);
        $import->model($meta->all());

        return redirect()->back()->with([
            Alert::success('Berhasil', 'Import metadata berhasil. Silahkan periksa kembali hasil import metadata')
        ]);
    }

    public function simpanIndikator($id, Request $request)
    {
        $data = Data::with(['indikator'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        $formData = $request->all();

        if ($request->hasFile('metode_image')) {
            $formData['metode'] = $request->file('metode_image')->storeAs('public/metode', date('Ymdhis') . '-' . $request->file('metode_image')->getClientOriginalName());
        }

        $data->indikator()->updateOrCreate(
            ['data_id' => $data->id],
            array_merge($formData, ['data_id' => $data->id])
        );

        Alert::success('Berhasil', 'Metadata berhasil disimpan');

        return redirect()->back();
    }

    public function variabel($id)
    {
        $data = Data::with(['variabel', 'standar'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if ($data->status_id == Data::STATUS_REVISI) {
            $data->load('verifikasi');
        }

        return view('pages.contents.produsen.pengumpulan.form-variabel', compact('data'));
    }

    public function importVariabel($id, Request $request)
    {
        if (!$request->hasFile('metadata')) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Berkas excel tidak valid. Data kosong! Pastikan Anda menggunakan template yang sudah disediakan')
            ]);
        }

        $data = Data::findOrFail($id);

        $indikatorData = Excel::toCollection(new MetadataVariabelImport($data->id), $request->file('metadata'));

        $meta = data_get($indikatorData, '0.0', []);
        if ($meta->count() < 14) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Berkas excel tidak valid. Data kosong! Pastikan Anda menggunakan template yang sudah disediakan')
            ]);
        }

        $import = new MetadataVariabelImport($data->id);
        $import->model($meta->all());

        return redirect()->back()->with([
            Alert::success('Berhasil', 'Import metadata berhasil. Silahkan periksa kembali hasil import metadata')
        ]);
    }

    public function simpanVariabel($id, Request $request)
    {
        $data = Data::when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        $data->variabel()->updateOrCreate(
            ['data_id' => $data->id],
            array_merge($request->all(), ['data_id' => $data->id])
        );

        return redirect()->back();
    }

    public function kegiatan($id)
    {
        $data = Data::with(['kegiatan'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);
        $provinces = Province::pluck('name', 'code');
        return view('pages.contents.produsen.pengumpulan.kegiatan', compact('data', 'provinces'));
    }

    public function simpanKegiatan($id, Request $request)
    {
        $data = Data::with(['kegiatan'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);
        $data->kegiatan()->updateOrCreate(
            ['data_id' => $data->id],
            array_merge($request->all(), ['data_id' => $data->id]),
        );

        return redirect()->back()->withInput();
    }

    public function simpanVariabelDikumpulkan($id, Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'definisi' => 'required|string',
            'konsep' => 'required|string',
            'referensi_waktu' => 'required|date',
        ]);
        $data = Data::with(['kegiatan'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if (empty($data->kegiatan)) {
            $data->kegiatan()->create([
                'variabel_dikumpulkan' => [$validated]
            ]);
        } else {
            $variable = $data->kegiatan->variabel_dikumpulkan;
            $variable[] = $validated;
            $data->kegiatan->update(['variabel_dikumpulkan' => $variable]);
        }

        return response()->noContent();
    }

    public function simpanPublikasi($id, Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'rencana_rilis' => 'required|date',
        ]);
        $data = Data::with(['kegiatan'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if (empty($data->kegiatan)) {
            $data->kegiatan()->create([
                'rencana_publikasi' => [$validated]
            ]);
        } else {
            $daftarPublikasi = $data->kegiatan->rencana_rilis;
            $daftarPublikasi[] = $validated;
            $data->kegiatan->update(['rencana_rilis' => $daftarPublikasi]);
        }

        return response()->noContent();
    }

    public function siapVerifikasi($id)
    {
        $data = Data::with(['kegiatan', 'standar'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

        if (in_array(strtolower($data->jenis_data), ['variabel', 'indikator'])) {
            $data->with(strtolower($data->jenis_data));
        }

        if ($data->calculateProgress() < 60) {
            return response()->json(['ok' => false, 'message' => 'Mohon lengkapi isian metadata terlebih dahulu sebelum lanjut ke proses verifikasi']);
        }

        if ($data->status_id == Data::STATUS_BELUM_DIPERIKSA) {
            return response()->json(['ok' => false, 'message' => 'Data ini sedang dalam proses verifikasi']);
        }

        $data->update(['progress' => 100, 'status_id' => Data::STATUS_BELUM_DIPERIKSA]);

        return response()->json(['ok' => true, 'message' => 'Sukses! Data dalam tahap verifikasi']);
    }

    public function exportData($id)
    {
        $data = Data::when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))->findOrFail($id);

        return Excel::download(new DataExport($data), 'testexcel-' . Str::random(10) . '.xlsx');
    }
}
