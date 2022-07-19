<?php

namespace App\Http\Controllers\Walidata;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class VerifikasiController extends Controller
{
    public function index()
    {
        $data = Data::whereIn('status_id', [Data::STATUS_PROSES_VERIFIKASI, Data::STATUS_REVISI, Data::STATUS_SIAP_PUBLIKASI])->with(['opd', 'berkas', 'indikator', 'variabel', 'standar', 'kegiatan'])
            ->latest()
            ->get();

        return view('pages.contents.walidata.verifikasi.index', compact('data'));
    }

    public function berkas($id)
    {
        $data = Data::with(['opd', 'berkas', 'verifikasi' => fn($q) => $q->category('berkas')])->findOrFail($id);
        $existingBerkas = $data->berkas->transform(function ($b) use ($data) {
            return [
                'id' => $b->id,
                'name' => $b->name,
                'created_at' => $b->created_at,
                'previewUrl' => route('filepreview', ['payload' => Crypt::encryptString($b->path)]),
            ];
        })->toArray();

        if ($data->status_id != Data::STATUS_PROSES_VERIFIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Data tidak dapat verifikasi, karena status data bukan dalam proses verifikasi')
            ]);
        }

        return view('pages.contents.walidata.verifikasi.berkas', compact('data', 'existingBerkas'));
    }

    public function variabel($id)
    {
        $data = Data::with(['variabel', 'standar', 'verifikasi' => fn($q) => $q->category('variabel')])->findOrFail($id);

        if ($data->status_id != Data::STATUS_PROSES_VERIFIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Data tidak dapat verifikasi, karena status data bukan dalam proses verifikasi')
            ]);
        }

        return view('pages.contents.walidata.verifikasi.variabel', compact('data'));
    }

    public function indikator($id)
    {
        $data = Data::with(['indikator', 'standar', 'verifikasi' => fn($q) => $q->category('indikator')])->findOrFail($id);

        if ($data->status_id != Data::STATUS_PROSES_VERIFIKASI) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Data tidak dapat verifikasi, karena status data bukan dalam proses verifikasi')
            ]);
        }

        return view('pages.contents.walidata.verifikasi.indikator', compact('data'));
    }

    public function getKomentar($id, Request $request)
    {
        $request->validate([
            'field' => 'required',
            'category' => 'required|in:variabel,indikator,berkas,kegiatan'
        ]);

        $comment = Verifikasi::where('category', $request->get('category'))->where('data_id', $id)->where('field', $request->get('field'))
            ->first();

        return response()->json(['ok' => true, 'message' => '', 'comment' => $comment->comment ?? '']);
    }

    public function komentar($id, Request $request)
    {
        $request->validate([
            'field' => 'required',
            'category' => 'required|in:variabel,indikator,berkas,kegiatan'
        ]);

        Verifikasi::updateOrCreate(
            $data = [
                'category' => $request->get('category'),
                'data_id' => $id,
                'field' => $request->get('field')
            ],
            array_merge($data, [
                'comment' => $request->get('comment')
            ])
        );

        return response()->json(['ok' => true, 'message' => 'Komentar berhasil disimpan']);
    }

    public function verify($id, Request $request)
    {
        $request->validate([
            'field' => 'required',
            'accepted' => 'required',
            'category' => 'required|in:variabel,indikator,berkas,kegiatan'
        ]);

        Verifikasi::updateOrCreate(
            $data = [
                'category' => $request->get('category'),
                'data_id' => $id,
                'field' => $request->get('field')
            ],
            array_merge($data, [
                'accepted' => $request->get('accepted') == 'true' ? 1 : 0
            ])
        );

        return response()->json(['ok' => true, 'message' => 'Berhasil disimpan']);
    }

    public function status($id)
    {
        $data = Data::with(['verifikasi'])->find($id);

        if (!$data) {
            return response()->json(['ok' => false, 'code' => 404, 'message' => 'Data tidak ditemukan']);
        }

        if ($data->status_id != Data::STATUS_PROSES_VERIFIKASI) {
            return response()->json(['ok' => false, 'code' => -2, 'message' => 'Status data tidak valid', 'status' => $data->status_id]);
        }

        if ($data->verifikasi->count() < 1) {
            return response()->json(['ok' => false, 'code' => -1, 'message' => 'Anda belum menyelesaikan proses verifikasi']);
        }

        if ($data->verifikasi->where('accepted', 0)->count() > 0) {
            return response()->json(['ok' => true, 'code' => 0, 'message' => 'Terdapat isian yang harus direvisi, apakah Anda yakin ingin menyelesaikan proses verifikasi?']);
        }

        return response()->json(['ok' => true, 'code' => 1, 'message' => 'Tidak ditemukan isian yang harus direvisi, apakah Anda yakin ingin menyelesaikan proses verifikasi?']);
    }

    public function complete($id)
    {
        $data = Data::with(['verifikasi'])->find($id);

        if (!$data) {
            return response()->json(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        if ($data->status_id != Data::STATUS_PROSES_VERIFIKASI) {
            return response()->json(['ok' => false, 'message' => 'Status data tidak valid']);
        }

        if ($data->verifikasi->count() < 1) {
            return response()->json(['ok' => false, 'message' => 'Anda belum menyelesaikan proses verifikasi']);
        }

        $isRevisi = $data->verifikasi->where('accepted', 0)->count() > 0;
        $data->update([
            'status_id' => $isRevisi ? Data::STATUS_REVISI : Data::STATUS_SIAP_PUBLIKASI,
            'progress' => $isRevisi ? 50 : 100,
        ]);

        activity()->causedBy(auth()->id())->performedOn($data)->log('Data telah diverifikasi dengan hasil: ' . ($isRevisi ? 'revisi' : 'lolos & siap dipublikasi'));

        return response()->json(['ok' => true, 'message' => 'Data telah diubah menjadi ' . ($isRevisi ? 'revisi' : 'siap untuk dipublikasi')]);
    }
}
