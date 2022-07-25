<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use App\Imports\DataImport;
use App\Models\Data;
use App\Models\Document;
use App\Models\Opd;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use SweetAlert;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;
use ZipStream\File;


class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role_id == '1') {
            $data = Data::data_nonprodusen();
            $opd = Opd::all();
            return view('pages.contents.administrator.indexdata', compact('data', 'opd'));
        } elseif (Auth::user()->role_id == '2') {
            $data = Data::data_draft_walidata();
            $file = Document::all();
            return view('pages.contents.walidata.indexdata', compact('data', 'file'));
        } elseif (Auth::user()->role_id == '3') {
            $data = Data::data_produsen();
            $draft = Data::get_draft()->count();
            return view('pages.contents.produsen.indexdata', compact('data', 'draft'));
        }
    }

    public function show()
    {
        if (Auth::user()->role_id == '1') {
            $data = Data::data_nonprodusen();
            $opd = Opd::all();
            return view('pages.contents.administrator.indexdata', compact('data', 'opd',));
        } elseif (Auth::user()->role_id == '2') {
            $data = Data::data_draft_walidata();
            return view('pages.contents.walidata.indexdata', compact('data'));
        } elseif (Auth::user()->role_id == '3') {
            $data = Data::data_produsen();
            $draft = Data::get_draft()->count();
            return view('pages.contents.produsen.indexdata', compact('data', 'draft'));
        }
    }

    public function create()
    {
        $opd = Opd::all();
        $data = Opd::get_opd();
        return view('pages.contents.walidata.createdata', compact('opd', 'data'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $existingData = Data::where('opd_id', auth()->user()->opd_id)->where('nama_data', trim($request->nama_data))->count();
        if ($existingData > 0) {
            return redirect()->back()->with([
                Alert::error('Gagal', 'Data dengan nama tersebut sudah terdaftar pada sistem')
            ]);
        }

        $create = Data::create([
            'nama_data' => $request->nama_data,
            'opd_id' => $request->opd_id,
            'jenis_data' => $request->jenis_data,
            'sumber_data' => $request->sumber_data,
            'status_id' => Data::STATUS_DRAFT,
            'user_id' => $user_id,

        ]);

        if ($create) {
            activity()->causedBy(auth()->id())->performedOn($create)->log('Menambahkan data: ' . $create->nama_data);

            if (Auth::user()->role_id == '1') {
                return redirect('/data_administrator')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil menambahkan Data!')
                    ]);
            } elseif (Auth::user()->role_id == '2') {

                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil menambahkan Data!')
                    ]);

            } elseif (Auth::user()->role_id == '3') {
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil menambahkan Data!')
                    ]);
            }

            return redirect('/home');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                Alert::error('Gagal', 'Gagal menambahkan Data!')
            ]);
    }

    public function restore(Request $request, $id)
    {
        $data = Data::findOrFail($id);

        if (!in_array($data->status_id, [Data::STATUS_SETUJU, Data::STATUS_TOLAK])) {

            return redirect()
                ->back()
                ->with([Alert::error('Gagal', 'Data tidak dapat direstore, status harus setuju/tolak')]);
        }

        $data->update([
            'status_id' => Data::STATUS_DRAFT,
            'progress' => 0,
        ]);

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()
                    ->performedOn($data)->log('Merestore Daftar Data');
                return redirect('/data_administrator')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Direstore!')
                    ]);
            } elseif (Auth::user()->role_id == '2') {
                activity()->performedOn($data)->log('Merestore Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Direstore!')
                    ]);
            } elseif (Auth::user()->role_id == '3') {
                activity()->performedOn($data)->log('Merestore Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Direstore!')
                    ]);
            }

            return redirect('/home');

        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                Alert::error('Gagal', 'Data Gagal Direstore!')
            ]);
    }

    public function detail($id)
    {
        $data = Data::find($id);
        $detail = Data::causer_id()->where("subject_id", "=", $id);
        $opd = Opd::all();
        return view('pages.contents.walidata.detaildata', compact('data', 'opd', 'detail'));
    }

    public function edit($id)
    {
        $data = Data::find($id);
        $opd = Opd::all();
        return view('pages.contents.walidata.editdata', compact('data', 'opd'));
    }

    public function update(Request $request, $id)
    {

        $data = Data::findOrFail($id);
        $get_statusdata = $data->status_id;
        $data->update([
            'nama_data' => $request->nama_data,
            'opd_id' => $request->opd_id,
            'jenis_data' => $request->jenis_data,
            'sumber_data' => $request->sumber_data,
            'status_id' => $get_statusdata,
        ]);

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->performedOn($data)->log('Mengedit Daftar Data');
                return redirect('/data_administrator')
                    ->with([
                        Alert::info('Berhasil', 'Berhasil memperbarui Data!')
                    ]);
            } elseif (Auth::user()->role_id == '2') {
                activity()
                    ->performedOn($data)
                    ->log('Mengedit Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::info('Berhasil', 'Berhasil memperbarui Data!')
                    ]);
            } elseif (Auth::user()->role_id == '3') {
                activity()->performedOn($data)->log('Mengedit Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::info('Berhasil', 'Berhasil memperbarui Data!')
                    ]);
            }

            return redirect('/home');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                Alert::error('Gagal', 'Gagal memperbarui Data!')
            ]);
    }


    public function destroy($id)
    {
        $data = Data::findOrFail($id);
        $nama_data = $data->nama_data;

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->log('Menghapus Daftar Data ' . $nama_data);
                $data->delete();
                return redirect('/data_administrator')
                    ->with([
                        Alert::error('Berhasil', 'Berhasil Menghapus Data!')
                    ]);
            } elseif (Auth::user()->role_id == '2') {

                activity()->performedOn($data)->log('Menghapus Daftar Data ' . $nama_data);
                $data->delete();
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::error('Berhasil', 'Berhasil Menghapus Data!')
                    ]);
            } elseif (Auth::user()->role_id == '3') {
                activity()->log('Menghapus Daftar Data' . $nama_data);
                $data->delete();
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::error('Berhasil', 'Berhasil Menghapus Data!')
                    ]);
            }

            return redirect('/home');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                Alert::error('Gagal', 'Gagal memperbarui Data!')
            ]);
    }

    public function selesai_konfirmasi_walidata()
    {
        $data = Data::selesai_konfirmasi_walidata();
        $status = 'disetujui';

        return view('pages.contents.walidata.indexdata', compact('data', 'status'));
    }

    public function tolak_konfirmasi_walidata()
    {
        $data = Data::data_tolak_walidata();
        $status = 'ditolak';

        return view('pages.contents.walidata.indexdata', compact('data', 'status'));
    }

    public function get_all_opd()
    {
        $get_all = Data::data_produsen_setuju_all();
        return view('pages.contents.walidata.indexall_opd', compact('get_all'));
    }

    public function get_all_opdall(Request $request)
    {
        $data = Data::with('opd')->setuju()->opd($request->id);
        $opd = Opd::pluck('nama_opd', 'id');
        $draft = Data::where('opd_id', '=', $request->id)->where('status_id', '=', 3)->count();
        return view('pages.contents.walidata.index_get_opd', compact('data', 'opd', 'draft'));
    }


    public function getData(Request $request)
    {
        $id = decrypt($request->id);
        if ($id == 'all') {
            $data = Data::with('opd')->setuju();
            $datatables = DataTables::eloquent($data)
                ->editColumn('opd_id', function ($data) {
                    return $data->opd->nama_opd;
                })
                ->editColumn('status_id', function ($data) {
                    return $data->status->status;
                })
                ->addIndexColumn()
                ->toArray();
            $datatables['draft_counter'] = Data::where('status_id', '=', 3)->count();
        } else {
            $data = Data::with('opd')->setuju()->OPD($id);
            $datatables = DataTables::eloquent($data)
                ->editColumn('opd_id', function ($data) {
                    return $data->opd->nama_opd;
                })
                ->editColumn('status_id', function ($data) {
                    return $data->status->status;
                })
                ->addIndexColumn()
                ->toArray();
            $datatables['draft_counter'] = Data::where('opd_id', '=', $id)->where('status_id', '=', 3)->count();
        }

        return $datatables;
    }

    public function setuju(Request $request, $id)
    {
        $id = decrypt($request->id);
        $data = Data::findOrFail($id);

        $data->update([
            'status_id' => Data::STATUS_SETUJU,
        ]);
        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->performedOn($data)->log('Menyetujui Daftar Data');
                return redirect('/data_administrator')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Disetujui!')
                    ]);
            } elseif (Auth::user()->role_id == '2') {
                activity()->performedOn($data)->log('Menyetujui Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Disetujui!')
                    ]);
            } elseif (Auth::user()->role_id == '3') {
                activity()->performedOn($data)->log('Menyetujui Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Data Berhasil Disetujui!')
                    ]);
            } else {
                return redirect('/home');
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                Alert::error('Gagal', 'Data Gagal Disetujui!')
            ]);
    }

    public function alasan(Request $request, $id)
    {
        $data = Data::findOrFail($id);
        $alasan = $request->alasan;
        $data->update([
            'alasan' => $alasan,
            'status_id' => Data::STATUS_TOLAK,
        ]);

        if ($data) {
            if (Auth::user()->role_id == '1') {
                activity()->performedOn($data)->log('Menolak Daftar Data');
                return redirect('/data_administrator')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil Menolak Data dan Memberi Alasan!')
                    ]);
            } elseif (Auth::user()->role_id == '2') {
                activity()->performedOn($data)->log('Menolak Daftar Data');
                return redirect('/data_walidata/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil Menolak Data dan Memberi Alasan!')
                    ]);
            } elseif (Auth::user()->role_id == '3') {
                activity()->performedOn($data)->log('Menolak Daftar Data');
                return redirect('/data_produsen/draft')
                    ->with([
                        Alert::success('Berhasil', 'Berhasil Menolak Data dan Memberi Alasan!')
                    ]);
            }
            return redirect('/home');

        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                Alert::error('Gagal', 'Gagal Menolak Data dan Memberi Alasan!')
            ]);

    }


    public function verifikasi_data()
    {
        $verifikasi = Data::verifikasi_data();
        return view('pages.contents.produsen.indexverifikasi', compact('verifikasi'));
    }

    public function selesai_konfirmasi()
    {
        $data = Data::selesai_konfirmasi();
        $draft = Data::get_draft()->count();
        $status = 'disetujui';

        return view('pages.contents.produsen.indexdata', compact('data', 'draft', 'status'));
    }

    public function tolak_konfirmasi()
    {
        $data = Data::tolak_konfirmasi();
        $draft = Data::get_draft()->count();
        $status = 'ditolak';

        return view('pages.contents.produsen.indexdata', compact('data', 'draft', 'status'));
    }

    public function pdf()
    {
        $id = Auth::user()->opd_id;
        $data = Data::data_produsen_setuju();
        $dt = Carbon::now()->translatedFormat('l, d F Y');
        $tahun = Carbon::now()->translatedFormat('Y');
        $bln = Carbon::now()->translatedFormat('F');
        $tgl = Carbon::now()->translatedFormat('j');
        $hari = Carbon::now()->translatedFormat('l');

        $path = base_path('public/assets/img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data1 = file_get_contents($path);
        $pict = 'data:image/' . $type . ';base64,' . base64_encode($data1);
        $opd = Opd::where('id', '=', $id)->get('nama_opd');

        $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict', 'opd'));
        return $pdf->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'serif'])->stream();
    }

    public function pdf2(Request $request)
    {
        $id = decrypt($request->opd_id);
        if ($id == 'all') {
            $data = Data::with('opd')->setuju()->get();
        } else {
            $data = Data::with('opd')->setuju()->OPD($id)->get();
        }

        $dt = Carbon::now()->translatedFormat('l, d F Y');
        $tahun = Carbon::now()->translatedFormat('Y');
        $bln = Carbon::now()->translatedFormat('F');
        $tgl = Carbon::now()->translatedFormat('j');
        $hari = Carbon::now()->translatedFormat('l');

        $path = base_path('public/assets/img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data1 = file_get_contents($path);
        $pict = 'data:image/' . $type . ';base64,' . base64_encode($data1);

        if ($id == 'all') {
            $pdf = PDF::loadView('pages.contents.pdf_all', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict'));


            return $pdf->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'serif'])->stream();
        } else {
            $opd = Opd::where('id', '=', $id)->get('nama_opd');
            $pdf = PDF::loadView('pages.contents.pdf', compact('data', 'hari', 'dt', 'tgl', 'bln', 'tahun', 'pict', 'opd'));


            return $pdf->setPaper('a4')->setOptions(['defaultFont' => 'serif'])->stream();
        }
    }

    public function notif()
    {
        $notif = Data::causer_id();
        return view('pages.contents.walidata.notif', compact('notif'));
    }

    public function draft(Request $request)
    {
        $id = decrypt($request->id);
        if ($id == 'all') {
            $draft = Data::where('status_id', '=', 3)->count();
        } else {
            $draft = Data::where('opd_id', '=', $id)->where('status_id', '=', 3)->count();
        }

        return view('pages.contents.walidata.index_get_opd', compact('draft'));
    }

    public function importData(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new DataImport, $request->file('file'));

            return redirect()->back()->with([
                Alert::success('Berhasil', 'Data berhasil diimport')
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), ['importData', $exception->getCode()]);
            return redirect()->back()->with([
                Alert::error('Gagal', $exception->getMessage() . PHP_EOL . '. Pastikan Anda menggunakan template yang tepat.')
            ]);
        }
    }

    public function exportData($id)
    {
        $data = Data::with(['opd', 'berkas', 'standar', 'status'])
            ->when(auth()->user()->hasAnyRole('produsen'), fn ($q) => $q->where('opd_id', auth()->user()->opd_id))
            ->findOrFail($id);

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
        $tmpArchivePath = Storage::path('tmp/'. uniqid());
        Storage::put($tmpArchivePath, NULL);

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

        return response()->file($tmpArchivePath, [
            'Content-Type' => 'application/x-zip',
            'Content-Disposition' => 'attachment; filename="' . $data->nama_data . '.zip"',
        ]);
    }
}
