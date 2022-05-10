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
use Spatie\Activitylog\Traits\LogsActivity;

// use Alert;
use App\Http\Controllers\Director;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use App\Providers\SweetAlertServiceProvider;
use SweetAlert;
use RealRashid\SweetAlert\Facades\Alert;
// use RealRashid\SweetAlert\Facades\Alert;
// or
// use Alert;ss


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
    public function show()
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
        $create = Data::create([
            'nama_data' => $request->nama_data,
            'opd_id' => $request->opd_id,
            'jenis_data' => $request->jenis_data,
            'sumber_data' => $request->sumber_data,
            'status_id' => $status_id,
            'user_id' => $user_id,

        ]);

        if ($create) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Menambahkan Daftar Data');
                return redirect('/data_superadmin')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil menambahkan Data!')
                    ]);
                // return redirect('/data_superadmin');
            } elseif (Auth::user()->role_id == '2') {
                activity()->log('Menambahkan Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil menambahkan Data!')
                    ]);

                // return redirect('/data_walidata/draft');
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Menambahkan Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil menambahkan Data!')
                    ]);
                // return redirect('/data_produsen/draft');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error(' Gagal', 'Gagal menambahkan Data!')
                ]);
        }

        // if (Auth::user()->role_id == '1') {
        //     return redirect('/data_superadmin');
        // } elseif (Auth::user()->role_id == '2') {
        //     return redirect('/data_walidata/draft');
        // } elseif (Auth::user()->role_id == '3') {
        //     return redirect('/data_produsen/draft');
        // } else {
        //     return redirect('/home');
        // }
    }

    public function restore(Request $request, $id)
    {
        // $id = decrypt($request->id);
        $data = Data::findOrFail($id);
        // dd($data);

        $restore = 3;
        $data->update([
            'status_id' => $restore,
        ]);

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Merestore Daftar Data');
                return redirect('/data_superadmin')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Direstore!')
                    ]);
                // return redirect('/data_superadmin');
            } elseif (Auth::user()->role_id == '2') {
                activity()->log('Merestore Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Direstore!')
                    ]);
                // return redirect('/data_walidata/draft');
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Merestore Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Direstore!')
                    ]);
                // return redirect('/data_produsen/draft');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Gagal Direstore!')
                ]);
        }

        // if (Auth::user()->role_id == '1') {
        //     return redirect('/data_superadmin');
        // } elseif (Auth::user()->role_id == '2') {
        //     return redirect('/data_walidata/draft');
        // } elseif (Auth::user()->role_id == '3') {
        //     return redirect('/data_produsen/draft');
        // } else {
        //     return redirect('/home');
        // }
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

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Mengedit Daftar Data');
                return redirect('/data_superadmin')
                    ->with([
                        Alert::info('Berhasil', 'Berhasil memperbarui Data!')
                    ]);
                // return redirect('/data_superadmin');
            } elseif (Auth::user()->role_id == '2') {
                activity()->log('Mengedit Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::info('Berhasil', 'Berhasil memperbarui Data!')
                    ]);
                // return redirect('/data_walidata/draft');
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Mengedit Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::info('Berhasil', 'Berhasil memperbarui Data!')
                    ]);
                // return redirect('/data_produsen/draft');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Gagal memperbarui Data!')
                ]);
        }

        // if (Auth::user()->role_id == '1') {
        //     return redirect('/data_superadmin');
        // } elseif (Auth::user()->role_id == '2') {
        //     return redirect('/data_walidata/draft');
        // } elseif (Auth::user()->role_id == '3') {
        //     return redirect('/data_produsen/draft');
        // } else {
        //     return redirect('/home');
        // }
    }



    public function destroy($id)
    {
        $user = Data::findOrFail($id);
        // dd($user);
        $user->delete();
        // if (Auth::user()->role_id == '1') {
        //     return redirect('/data_superadmin');
        // } elseif (Auth::user()->role_id == '2') {
        //     return redirect('/data_walidata/draft');
        // } elseif (Auth::user()->role_id == '3') {
        //     return redirect('/data_produsen/draft');
        // } else {
        //     return redirect('/home');
        // }

        if ($user) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Menghapus Daftar Data');
                return redirect('/data_superadmin')
                    ->with([
                        Alert::error('Berhasil', 'Berhasil Menghapus Data!')
                    ]);
                // return redirect('/data_superadmin');
            } elseif (Auth::user()->role_id == '2') {
                activity()->log('Menghapus Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::error('Berhasil', 'Berhasil Menghapus Data!')
                    ]);
                // return redirect('/data_walidata/draft');
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Menghapus Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::error('Berhasil', 'Berhasil Menghapus Data!')
                    ]);
                // return redirect('/data_produsen/draft');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Gagal memperbarui Data!')
                ]);
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
        $id = decrypt($request->id);
        $data = Data::findOrFail($id);

        $setuju = 1;
        $data->update([
            'status_id' => $setuju,
        ]);
        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Menyetujui Daftar Data');
                return redirect('/data_superadmin')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Disetujui!')
                    ]);
                // return redirect('/data_superadmin');
            } elseif (Auth::user()->role_id == '2') {
                activity()->log('Menyetujui Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Disetujui!')
                    ]);
                // return redirect('/data_walidata/draft');
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Menyetujui Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Disetujui!')
                    ]);
                // return redirect('/data_produsen/draft');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Gagal Disetujui!')
                ]);
        }

        // if (Auth::user()->role_id == '1') {
        //     return redirect('/data_superadmin');
        // } elseif (Auth::user()->role_id == '2') {
        //     return redirect('/data_walidata/draft');
        // } elseif (Auth::user()->role_id == '3') {
        //     return redirect('/data_produsen/draft');
        // } else {
        //     return redirect('/home');
        // }
    }

    public function alasan(Request $request, $id)
    {
        // $id = decrypt($request->post('id'));
        $data = Data::findOrFail($id);
        $alasan = $request->alasan;
        $tolak = 2;
        $data->update([
            'alasan' => $alasan,
            'status_id' => $tolak,
        ]);

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Menolak Daftar Data');
                return redirect('/data_superadmin')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil Menolak Data dan Memberi Alasan!')
                    ]);
                // return redirect('/data_superadmin');
            } elseif (Auth::user()->role_id == '2') {
                activity()->log('Menolak Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil Menolak Data dan Memberi Alasan!')
                    ]);
                // return redirect('/data_walidata/draft');
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Menolak Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil Menolak Data dan Memberi Alasan!')
                    ]);
                // return redirect('/data_produsen/draft');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Gagal Menolak Data dan Memberi Alasan!')
                ]);
        }
        // if (Auth::user()->role_id == '1') {
        //     return redirect('/data_superadmin');
        // } elseif (Auth::user()->role_id == '2') {
        //     return redirect('/data_walidata/draft');
        // } elseif (Auth::user()->role_id == '3') {
        //     return redirect('/data_produsen/draft');
        // } else {
        //     return redirect('/home');
        // }
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
        $id = Auth::user()->opd_id;
        $data = Data::data_produsen_setuju();
        $dt = Carbon::now();
        // set some things
        $dt = Carbon::Now()->translatedFormat('l, d F Y');
        // set some things
        $tahun = Carbon::Now()->translatedFormat('Y');
        // dd($tahun);
        $bln = Carbon::Now()->translatedFormat('F');
        $tgl = Carbon::Now()->translatedFormat('j');
        $hari = Carbon::Now()->translatedFormat('l');

        $path = base_path('public/assets/img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data1 = file_get_contents($path);
        $pict = 'data:image/' . $type . ';base64,' . base64_encode($data1);
        $opd = Opd::where('id', '=', $id)->get('nama_opd');


        // $path = Director::baseFolder() . '/public' . $config->WebsiteLogo()->getURL();
        // $type = pathinfo($path, PATHINFO_EXTENSION);
        // $data = file_get_contents($path);
        // $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);



        $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict', 'opd'));
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
        $dt = Carbon::Now()->translatedFormat('l, d F Y');
        // set some things
        $tahun = Carbon::Now()->translatedFormat('Y');
        // dd($tahun);
        $bln = Carbon::Now()->translatedFormat('F');
        $tgl = Carbon::Now()->translatedFormat('j');
        $hari = Carbon::Now()->translatedFormat('l');

        $path = base_path('public/assets/img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data1 = file_get_contents($path);
        $pict = 'data:image/' . $type . ';base64,' . base64_encode($data1);
        $opd = Opd::where('id', '=', $id)->get('nama_opd');

        // dd($opd);



        // $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict', 'opd'));


        // return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
        if ($id == 'all') {
            $pdf = PDF::loadView('pages.contents.pdf_all', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict', 'opd'));


            return $pdf->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'serif'])->stream();
        } else {
            $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict', 'opd'));


            return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
        }
    }
}
