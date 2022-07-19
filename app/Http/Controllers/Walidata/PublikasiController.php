<?php

namespace App\Http\Controllers\Walidata;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Services\CkanApi\Facades\CkanApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PublikasiController extends Controller
{
    public function index()
    {
        $data = Data::where('status_id', [Data::STATUS_SIAP_PUBLIKASI, Data::STATUS_TERPUBLIKASI])
            ->when(auth()->user()->hasAnyRole('produsen'), fn($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->with(['opd', 'status', 'berkas', 'indikator', 'variabel', 'standar', 'kegiatan'])
            ->latest()
            ->get();

        return view('pages.contents.walidata.publikasi.index', compact('data'));
    }

    public function organisasi($id)
    {
        $data = Data::findOrFail($id);
        $orgs = CkanApi::organization()->all();
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

    public function simpanOrganisasi(Request $request)
    {

    }
}
