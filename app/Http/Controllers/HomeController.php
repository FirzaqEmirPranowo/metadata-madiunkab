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
        $dataPengumpulan = Data::where('status_id', Data::STATUS_PROSES_PENGUMPULAN)->count();
        $dataVerifikasi = Data::where('status_id', '>=', Data::STATUS_PROSES_PENGUMPULAN)->count();
        $dataSiapPublish = Data::where('status_id', '=', Data::STATUS_SIAP_PUBLIKASI)->count();
        $dataTerbaru = Data::with('opd')->latest()->take(10)->get();
        $lastActivities = Activity::with('causer')->latest()->take(20)->get();
        return view('pages.contents.walidata.dashboard', compact('disetujui', 'data', 'dataPengumpulan', 'dataTidakLengkap', 'dataSiapPublish', 'dataTerbaru', 'lastActivities'));
    }

    public function dashboardWalidata()
    {
        $data = Data::count();
        $disetujui = Data::where('status_id', Data::STATUS_SETUJU)->count();
        $dataLengkap = Data::where('status_id')->where('progress', '>', 80)->count();
        $dataVerifikasi = Data::where('status_id', '>=', Data::STATUS_PROSES_PENGUMPULAN)->where('progress', '<', 80)->count();
        $dataSiapPublish = Data::where('status_id', '=', Data::STATUS_SIAP_PUBLIKASI)->count();
        $dataTerbaru = Data::with('opd')->latest()->take(10)->get();
        $lastActivities = Activity::with('causer')->latest()->take(20)->get();
        return view('pages.contents.walidata.dashboard', compact('disetujui', 'data', 'dataLengkap', 'dataTidakLengkap', 'dataSiapPublish', 'dataTerbaru', 'lastActivities'));
    }

    public function dashboardProdusen()
    {
        $opdId = auth()->user()->opd_id;
        $data = Data::where('opd_id', $opdId)->count();
        $disetujui = Data::where('opd_id', $opdId)->where('status_id', Data::STATUS_SETUJU)->count();
        $dataLengkap = Data::where('opd_id', $opdId)->where('status_id')->where('progress', '>', 80)->count();
        $dataTidakLengkap = Data::where('opd_id', $opdId)->where('status_id', '>=', Data::STATUS_PROSES_PENGUMPULAN)->where('progress', '<', 80)->count();
        $dataSiapPublish = Data::where('opd_id', $opdId)->where('status_id', '=', Data::STATUS_SIAP_PUBLIKASI)->count();
        $dataTerbaru = Data::where('opd_id', $opdId)->with('opd', 'status')->latest()->take(10)->get();

        return view('pages.contents.produsen.dashboard', compact('disetujui', 'data', 'dataLengkap', 'dataTidakLengkap', 'dataSiapPublish', 'dataTerbaru'));
    }
}
