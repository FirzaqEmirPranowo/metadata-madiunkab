<?php

namespace App\Http\Controllers;


use App\Models\Data;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboardAdmin()
    {
        $data = Data::count();
        $disetujui = Data::where('status_id', Data::STATUS_SETUJU)->count();
        $dataPengumpulan = Data::whereIn('status_id', [Data::STATUS_PROSES_PENGUMPULAN, Data::STATUS_SETUJU])->count();
        $dataVerifikasi = Data::whereIn('status_id', [Data::STATUS_PROSES_VERIFIKASI, Data::STATUS_REVISI])->count();
        $dataSiapPublish = Data::where('status_id', '=', Data::STATUS_SIAP_PUBLIKASI)->count();
        $dataTerpublikasi = Data::where('status_id', '=', Data::STATUS_TERPUBLIKASI)->count();
        $dataTerbaru = Data::with('opd')->latest()->take(10)->get();
        $lastActivities = Activity::with('causer')->latest()->take(20)->get();
        return view('pages.contents.walidata.dashboard', compact('disetujui', 'data', 'dataPengumpulan', 'dataVerifikasi', 'dataSiapPublish', 'dataTerpublikasi', 'dataTerbaru', 'lastActivities'));
    }

    public function dashboardWalidata()
    {
        $data = Data::count();
        $disetujui = Data::where('status_id', Data::STATUS_SETUJU)->count();
        $dataPengumpulan = Data::whereIn('status_id', [Data::STATUS_PROSES_PENGUMPULAN, Data::STATUS_SETUJU])->count();
        $dataVerifikasi = Data::whereIn('status_id', [Data::STATUS_PROSES_VERIFIKASI, Data::STATUS_REVISI])->count();
        $dataSiapPublish = Data::where('status_id', '=', Data::STATUS_SIAP_PUBLIKASI)->count();
        $dataTerpublikasi = Data::where('status_id', '=', Data::STATUS_TERPUBLIKASI)->count();
        $dataTerbaru = Data::with('opd')->latest()->take(10)->get();
        $lastActivities = Activity::with('causer')->latest()->take(20)->get();
        return view('pages.contents.walidata.dashboard', compact('disetujui', 'data', 'dataPengumpulan', 'dataVerifikasi', 'dataSiapPublish', 'dataTerpublikasi', 'dataTerbaru', 'lastActivities'));
    }

    public function dashboardProdusen()
    {
        $opdId = auth()->user()->opd_id;
        $data = Data::where('opd_id', $opdId)->count();
        $dataPengumpulan = Data::where('opd_id', $opdId)->whereIn('status_id', [Data::STATUS_PROSES_PENGUMPULAN, Data::STATUS_SETUJU])->count();
        $dataVerifikasi = Data::where('opd_id', $opdId)->whereIn('status_id', [Data::STATUS_PROSES_VERIFIKASI, Data::STATUS_REVISI])->count();
        $dataTidakLengkap = Data::where('opd_id', $opdId)->where('status_id', '>=', Data::STATUS_PROSES_PENGUMPULAN)->count();
        $dataSiapPublish = Data::where('opd_id', $opdId)->where('status_id', '=', Data::STATUS_SIAP_PUBLIKASI)->count();
        $dataTerpublikasi = Data::where('opd_id', $opdId)->where('status_id', '=', Data::STATUS_TERPUBLIKASI)->count();
        $dataTerbaru = Data::where('opd_id', $opdId)->with('opd', 'status')->latest()->take(10)->get();

        return view('pages.contents.produsen.dashboard', compact('dataPengumpulan', 'data', 'dataVerifikasi', 'dataTidakLengkap', 'dataSiapPublish', 'dataTerpublikasi', 'dataTerbaru'));
    }
}
