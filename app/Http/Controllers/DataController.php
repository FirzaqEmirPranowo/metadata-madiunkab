<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Role;
use App\Models\Data;
use App\Models\Status;
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
            $data = Data::with('opd')->with('status')->get();
            $opd = Opd::all();
            // dd($data);s
            return view('pages.contents.indexdata', compact('data', 'opd',));
        } elseif (Auth::user()->role_id == '2') {
            $data = Data::with('opd')->get();
            return view('pages.contents.indexdata', compact('data'));
        } elseif (Auth::user()->role_id == '3') {
            $data = Data::data_produsen();
            $data2 = collect(Data::get_draft());
            $draft = $data2->count();

            // dd($draft);
            return view('pages.contents.indexdata', compact('data', 'draft'));
        }
    }

    // public function get_all_opd()
    // {
    // $get_all = Data::data_produsen_setuju_all();
    // $verifikasi = Data::verifikasi_data();
    // dd($verifikasi);
    // return view('pages.contents.indexall_opd', compact('get_all'));
    // }

    public function get_all_opdall(Request $request)
    {
        $data = Data::with('opd')->setuju()
            ->when($request->filled('opd_id'), fn ($q) => $q->where('opd_id', $request->get('opd_id')))
            ->get();
        $opd = Opd::pluck('nama_opd', 'id');
        // $verifikasi = Data::verifikasi_data();
        // dd($get_allopd);
        return view('pages.contents.index_get_opd', compact('data', 'opd'));
    }

    public function getData(Request $request)
    {
        if ($request->id == 'all') {
            $data = Data::with('opd')->setuju();
        } else {
            $data = Data::with('opd')->setuju()->OPD($request->id);
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

    public function verifikasi_data()
    {
        $verifikasi = Data::verifikasi_data();
        // $verifikasi = Data::verifikasi_data();
        // dd($verifikasi);
        return view('pages.contents.indexverifikasi', compact('verifikasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opd = Opd::all();
        $data = Opd::get_opd();
        // dd($data);
        return view('pages.contents.createdata', compact('opd', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // 'status_data' => "0",

        // dd($request);
        $status_id = 3;
        Data::create([
            'nama_data' => $request->nama_data,
            'opd_id' => $request->opd_id,
            'jenis_data' => $request->jenis_data,
            'sumber_data' => $request->sumber_data,
            'status_id' => $status_id,

        ]);

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen');
        } else {
            return redirect('/home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Data $data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Data::findOrFail($id);
        // dd($data->opd->nama_opd);
        // dd($data->sumber_data);
        // $opd_id = Opd::all()->where($data->opd_id, '=', '');
        // dd($data);
        $opd = Opd::all();
        return view('pages.contents.editdata', compact('data', 'opd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
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
            return redirect('/data_walidata');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen');
        } else {
            return redirect('/home');
        }
    }

    public function setuju(Request $request, $id)
    {
        // dd($request);
        $data = Data::findOrFail($id);
        // dd($data);
        // $status_id = $data->status_id;
        // dd($data);
        // $get_statusdata = Data::findOrFail($id);
        $setuju = 1;
        $data->update([
            'status_id' => $setuju,
        ]);
        // dd($get_statusdata);
        // DB::table('data')->where('status_id', $data->status_id)->update([
        //     'status_id' => $setuju
        // ]);
        // $data->update([
        //     'status_id' => $setuju,
        // ]);

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen');
        } else {
            return redirect('/home');
        }
    }
    public function tolak(Request $request, $id)
    {
        $data = Data::findOrFail($id);
        $tolak = 2;
        $data->update([
            'status_id' => $tolak,
        ]);
        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen');
        } else {
            return redirect('/home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Data::findOrFail($id);
        // dd($user);
        $user->delete();

        if (Auth::user()->role_id == '1') {
            return redirect('/data_superadmin');
        } elseif (Auth::user()->role_id == '2') {
            return redirect('/data_walidata');
        } elseif (Auth::user()->role_id == '3') {
            return redirect('/data_produsen');
        } else {
            return redirect('/home');
        }
    }

    public function pdf()
    {
        $data = Data::data_produsen_setuju();
        $pdf = PDF::loadView('pages.contents.pdf', compact('data'));
        return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
    }

    public function pdf2(Request $request)
    {
        $data = Data::with('opd')->setuju()->OPD($request->opd_id)->get();
        $pdf = PDF::loadView('pages.contents.pdf', compact('data'));

        return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
    }
}
