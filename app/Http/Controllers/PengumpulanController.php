<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Data;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\Province;

class PengumpulanController extends Controller
{
    public function pengumpulan()
    {
        $data = Data::where('status_id', 1)->with(['opd', 'berkas', 'indikator', 'variabel'])->get();

        return view('pages.contents.produsen.pengumpulan.index', compact('data'));
    }

    public function detailData($id)
    {
        $data = Data::with(['opd', 'berkas'])->findOrFail($id);
        $opds = Opd::get();
        $existingBerkas = $data->berkas->transform(function ($b) use ($data) {
            return [
                'name' => $b->name,
                'size' => $b->size,
                'previewUrl' => route('filepreview', ['payload' => Crypt::encryptString($b->path)]),
                'deleteUrl' => route('delete-berkas', [$data->id, $b->id]),
            ];
        })->toArray();

        if ($data->status_id != 1) {
            return redirect()->back()->with('errors', 'Status Data belum selesai');
        }

        return view('pages.contents.produsen.pengumpulan.edit-data', compact('data', 'opds', 'existingBerkas'));
    }

    public function simpanData($id, Request $request)
    {
        $validated = $request->validate([
            'nama_data' => 'required|string',
            'sumber_data' => 'required|string'
        ]);

        $data = Data::findOrFail($id);

        $data->update($validated);

        return redirect()->back();
    }

    public function metaVariabel()
    {
        return view('pages.contents.produsen.pengumpulan.variabel');
    }

    public function standarData($id, Request $request)
    {
        $data = Data::with(['opd', 'standar'])->findOrFail($id);

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

            if (!empty($data->standar) && $data->progress + 25 < 100) {
                $data->increment('progress', 25);
            }
        }

        return view('pages.contents.produsen.pengumpulan.standar', compact('data'));
    }

    public function uploadBerkas($id, Request $request)
    {
        $request->validate([
            'berkas' => 'required|file'
        ]);

        $data = Data::findOrFail($id);

        if ($data->status_id != 1) {
            return response()->json(['message' => 'invalid'], 403);
        }

        $storedPath = $request->file('berkas')->store('berkas');

        if (!$storedPath) {
            return response([], 500);
        }

        $berkas = $data->berkas()->create([
            'name' => $request->file('berkas')->getClientOriginalName(),
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
        $data = Data::findOrFail($id);

        if (in_array(strtolower($data->jenis_data), ['variabel', 'indikator'])) {
            $data->with(strtolower($data->jenis_data));
        }

        return view('pages.contents.produsen.pengumpulan.' . strtolower($data->jenis_data), compact('data'));
    }

    public function tambahIndikator($id)
    {
        $data = Data::findOrFail($id);
        return view('pages.contents.produsen.pengumpulan.form-indikator', compact('data'));
    }

    public function simpanIndikator($id, Request $request)
    {
        $data = Data::findOrFail($id);

        $data->indikator()->create($request->all());

        return redirect()->route('metadata', $id);
    }

    public function tambahVariabel($id)
    {
        $data = Data::findOrFail($id);
        return view('pages.contents.produsen.pengumpulan.form-variabel', compact('data'));
    }

    public function simpanVariabel($id, Request $request)
    {
        $data = Data::findOrFail($id);

        $data->variabel()->create($request->all());

        return redirect()->route('metadata', $id);
    }

    public function kegiatan($id)
    {
        $data = Data::with(['kegiatan'])->findOrFail($id);
        $provinces = Province::pluck('name', 'code');
        return view('pages.contents.produsen.pengumpulan.kegiatan', compact('data', 'provinces'));
    }

    public function simpanKegiatan($id, Request $request)
    {
        $data = Data::with(['kegiatan'])->findOrFail($id);
        $data->kegiatan()->updateOrCreate(
            ['data_id' => $data->id],
            array_merge($request->all(), ['data_id' => $data->id]),
        );
//        dd($request->all());
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
        $data = Data::with(['kegiatan'])->findOrFail($id);

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
        $data = Data::with(['kegiatan'])->findOrFail($id);

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
}
