<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Role;
use App\Models\Data;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\Facades\DataTables;


class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role_id == '1') {
            $data = Data::data_nonprodusen();
            $opd = Opd::all();
            // dd($data);s
            return view('pages.contents.superadmin.indexdata', compact('data', 'opd',));
        } elseif (Auth::user()->role_id == '2') {
            $data = Data::data_draft_walidata();
            // dd($data);
            return view('pages.contents.walidata.indexdata', compact('data'));
        } elseif (Auth::user()->role_id == '3') {
            // $q = Auth::user()->id;
            $data = Data::data_produsen();
            // dd($data);

            $data2 = collect(Data::get_draft());
            $draft = $data2->count();
            // dd($draft);
            return view('pages.contents.produsen.indexdata', compact('data', 'draft'));
        }
    }


    //superadmin


    //walidata


    public function create()
    {
        $opd = Opd::all();
        $data = Opd::get_opd();
        // dd($data);
        return view('pages.contents.walidata.createdata', compact('opd', 'data'));
    }

    public function store(Request $request)
    {
        $status_id = 3;
        if (Auth::user()->role == '3' | Auth::user()->opd_id == $request->opd_id) {
            $status_id = 1;
        }
        $user_id = Auth::user()->id;
        // dd(Auth::user());
        Data::create([
            'nama_data' => $request->nama_data,
            'opd_id' => $request->opd_id,
            'jenis_data' => $request->jenis_data,
            'sumber_data' => $request->sumber_data,
            'status_id' => $status_id,
            'user_id' => $user_id,

        ]);

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata/draft');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen/draft');
        } else {
            return redirect('/home');
        }
    }

    public function edit($id)
    {
        $data = Data::find($id);
        // dd($data);
        $opd = Opd::all();
        return view('pages.contents.walidata.editdata', compact('data', 'opd'));
    }

    public function update(Request $request, $id)
    {

        // dd($request);
        $data = Data::findOrFail($id);
        $get_statusdata = Data::findOrFail($id)->status_id;
        // dd($get_statusdata);
        $data->update([
            'nama_data' => $request->nama_data,
            'opd_id' => $request->opd_id,
            'jenis_data' => $request->jenis_data,
            'sumber_data' => $request->sumber_data,
            'status_id' => $get_statusdata,
        ]);

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata/draft');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen/draft');
        } else {
            return redirect('/home');
        }
    }

    public function destroy($id)
    {
        $user = Data::findOrFail($id);
        // dd($user);
        $user->delete();

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata/draft');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen/draft');
        } else {
            return redirect('/home');
        }
    }

    public function selesai_konfirmasi_walidata()
    {
        $data = Data::selesai_konfirmasi_walidata();
        // dd($data);
        return view('pages.contents.walidata.selesai_konfirmasi_walidata', compact('data'));
    }

    public function tolak_konfirmasi_walidata()
    {
        $data = Data::data_tolak_walidata();
        // dd($data);
        return view('pages.contents.walidata.tolak_konfirmasi_walidata', compact('data'));
    }

    public function get_all_opd()
    {
        $get_all = Data::data_produsen_setuju_all();
        $verifikasi = Data::verifikasi_data();
        // dd($verifikasi);
        return view('pages.contents.walidata.indexall_opd', compact('get_all'));
    }

    public function get_all_opdall(Request $request)
    {
        $data = Data::with('opd')->setuju()->OPD($request->id);
        // ->when($request->filled('opd_id'), fn ($q) => $q->where('opd_id', $request->get('opd_id')))
        // ->get();
        $opd = Opd::pluck('nama_opd', 'id');
        // $verifikasi = Data::verifikasi_data();
        // dd($data);
        return view('pages.contents.walidata.index_get_opd', compact('data', 'opd'));
    }

    public function getData(Request $request)
    {
        $id = decrypt($request->id);
        if ($id == 'all') {
            $data = Data::with('opd')->setuju();
        } else {
            $data = Data::with('opd')->setuju()->OPD($id);
        }

        return DataTables::of($data)
            ->editColumn('opd_id', function ($data) {
                return $data->opd->nama_opd;
            })
            ->editColumn('status_id', function ($data) {
                return $data->status->status;
            })
            ->addIndexColumn()
            ->make(true);
    }


    //produsen


    public function setuju(Request $request, $id)
    {

        $data = Data::findOrFail($id);

        $setuju = 1;
        $data->update([
            'status_id' => $setuju,
        ]);

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata/draft');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen/draft');
        } else {
            return redirect('/home');
        }
    }

    public function tolak(Request $request, $id)
    {
        // $id = decrypt($request->post('id'));
        $data = Data::findOrFail($id);
        $tolak = 2;
        $data->update([
            'status_id' => $tolak,
        ]);
        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata/draft');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen/draft');
        } else {
            return redirect('/home');
        }
    }

    public function verifikasi_data()
    {
        $verifikasi = Data::verifikasi_data();
        // $verifikasi = Data::verifikasi_data();
        // dd($verifikasi);
        return view('pages.contents.produsen.indexverifikasi', compact('verifikasi'));
    }

    public function selesai_konfirmasi()
    {
        $data = Data::selesai_konfirmasi();
        $data2 = collect(Data::get_draft());
        $draft = $data2->count();
        // dd($data);

        return view('pages.contents.produsen.selesai_konfirmasi', compact('data', 'draft'));
    }

    public function tolak_konfirmasi()
    {
        $data = Data::tolak_konfirmasi();
        $data2 = collect(Data::get_draft());
        $draft = $data2->count();

        return view('pages.contents.produsen.tolak_konfirmasi', compact('data', 'draft'));
    }

    public function input_produsen()
    {
        $verifikasi = Data::verifikasi_opd();
        // $verifikasi = Data::verifikasi_data();
        // dd($verifikasi);
        return view('pages.contents.produsen.indexverifikasi', compact('verifikasi'));
    }


    public function pdf()
    {
        $data = Data::data_produsen_setuju();
        $dt = Carbon::now();
        // set some things
        $tahun = $dt->year;
        $bln = $dt->month;
        $tgl = $dt->day;
        $hari = date('D');
        $bulan = date('M');

        // dd($bulan);

        $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'bulan', 'tgl', 'bln', 'tahun'));
        return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
    }

    public function pdf2(Request $request)
    {
        $id = decrypt($request->opd_id);
        // $data = Data::with('opd')->setuju()->OPD($id)->get();
        if ($id == 'all') {
            $data = Data::with('opd')->setuju()->get();
        } else {
            $data = Data::with('opd')->setuju()->OPD($id)->get();
        }
        // $data();
        $dt = Carbon::now();
        // set some things
        $tahun = $dt->year;
        $bln = $dt->month;
        $tgl = $dt->day;
        $hari = date('D');
        $bulan = date('M');
        $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'bulan', 'tgl', 'bln', 'tahun'));


        return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
    }
}
