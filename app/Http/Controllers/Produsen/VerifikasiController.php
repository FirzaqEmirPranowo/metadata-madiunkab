<?php

namespace App\Http\Controllers\Produsen;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $data = Data::whereIn('status_id', [Data::STATUS_BELUM_DIPERIKSA, Data::STATUS_REVISI])
            ->with(['opd', 'berkas', 'indikator', 'variabel', 'standar', 'kegiatan'])
            ->where('opd_id', auth()->user()->opd_id)
            ->paginate();

        return view('pages.contents.produsen.verifikasi.index', compact('data'));
    }

    public function detail()
    {

    }
}
