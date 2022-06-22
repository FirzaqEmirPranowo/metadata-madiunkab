<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class VerifikasiController extends Controller
{
    public function index()
    {
        $data = Data::whereIn('status_id', [4, 5])->with(['opd', 'berkas', 'indikator', 'variabel', 'standar', 'kegiatan'])->paginate();

        return view('pages.contents.walidata.verifikasi.index', compact('data'));
    }

    public function berkas($id)
    {
        $data = Data::with(['opd', 'berkas', 'verifikasi' => fn ($q) => $q->category('berkas')])->findOrFail($id);
        $existingBerkas = $data->berkas->transform(function ($b) use ($data) {
            return [
                'id' => $b->id,
                'name' => $b->name,
                'created_at' => $b->created_at,
                'previewUrl' => route('filepreview', ['payload' => Crypt::encryptString($b->path)]),
            ];
        })->toArray();

        if (!in_array($data->status_id, [1, 4, 5, 6])) {
            return redirect()->back()->with('errors', 'Status Data belum selesai');
        }

        return view('pages.contents.walidata.verifikasi.berkas', compact('data', 'existingBerkas'));
    }

    public function variabel($id)
    {
        $data = Data::with(['variabel', 'standar', 'verifikasi' => fn ($q) => $q->category('variabel')])->findOrFail($id);
        return view('pages.contents.walidata.verifikasi.variabel', compact('data'));
    }

    public function indikator($id)
    {
        $data = Data::with(['indikator', 'standar', 'verifikasi' => fn ($q) => $q->category('indikator')])->findOrFail($id);
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
}
