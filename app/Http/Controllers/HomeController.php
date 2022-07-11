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
        return view('pages.contents.walidata.dashboard');
    }

    public function dashboardWalidata()
    {
        $data = Data::count();
        $disetujui = Data::where('status_id', Data::STATUS_SETUJU)->count();
        $dataLengkap = Data::where('status_id')->where('progress', '>', 80)->count();
        $dataTidakLengkap = Data::where('status_id', '>=', Data::STATUS_DRAFT)->where('progress', '<', 80)->count();
        $dataSiapPublish = Data::where('status_id', '=', Data::STATUS_SELESAI_VERIFIKASI)->count();
        $dataTerbaru = Data::with('opd')->latest()->take(10)->get();
        $lastActivities = Activity::with('causer')->latest()->take(20)->get();
        return view('pages.contents.walidata.dashboard', compact('disetujui', 'data', 'dataLengkap', 'dataTidakLengkap', 'dataSiapPublish', 'dataTerbaru', 'lastActivities'));
    }

    public function dashboardProdusen()
    {
        $opdId = auth()->user()->opd_id;
        $data = Data::where('user_id', $opdId)->count();
        $disetujui = Data::where('user_id', $opdId)->where('status_id', Data::STATUS_SETUJU)->count();
        $dataLengkap = Data::where('user_id', $opdId)->where('status_id')->where('progress', '>', 80)->count();
        $dataTidakLengkap = Data::where('user_id', $opdId)->where('status_id', '>=', Data::STATUS_DRAFT)->where('progress', '<', 80)->count();
        $dataSiapPublish = Data::where('user_id', $opdId)->where('status_id', '=', Data::STATUS_SELESAI_VERIFIKASI)->count();
        $dataTerbaru = Data::where('user_id', $opdId)->with('opd')->latest()->take(10)->get();

        return view('pages.contents.produsen.dashboard', compact('disetujui', 'data', 'dataLengkap', 'dataTidakLengkap', 'dataSiapPublish', 'dataTerbaru'));
    }
}
