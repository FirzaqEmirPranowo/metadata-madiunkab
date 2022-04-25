<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\UserController;
use App\Imports\OpdImport;
use App\Imports\DataImport;
use App\Imports\UserImport;
// use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Opd;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/d_superadmin', [App\Http\Controllers\HomeController::class, 'index'])->name('d_superadmin');
// Route::get('/d_walidata', [App\Http\Controllers\HomeController::class, 'index'])->name('d_walidata');
// Route::get('/d_produsen', [App\Http\Controllers\HomeController::class, 'index'])->name('d_produsen');

// Route::middleware('role:superadmin')->get('/d_superadmin', function () {
//         return 'Dashboard';
//     })->name('d_superadmin');

Route::middleware(['role:superadmin'])->group(function () {
    Route::get('/d_superadmin', [HomeController::class, 'index1'])->name('d_superadmin');
    Route::get('/data_superadmin', [DataController::class, 'index'])->name('data_superadmin');
    Route::get('/data_superadmin/create', [DataController::class, 'create'])->name('data_superadmin');
    Route::post('/data_superadmin/store', [DataController::class, 'store'])->name('data_superadmin');
    Route::get('/data_superadmin/edit/{id}', [DataController::class, 'edit'])->name('data_superadmin');
    Route::post('/data_superadmin/update/{id}', [DataController::class, 'update'])->name('data_superadmin');
    Route::get('/data_superadmin/destroy/{id}', [DataController::class, 'destroy'])->name('data_superadmin');
    // Route::resource('data_superadmin', DataController::class);
    Route::get('/data_superadmin/get_all_opdall', [DataController::class, 'get_all_opdall'])->name('data_superadmin');

    Route::post('/data/import', function () {
        Excel::import(new DataImport, request()->file('file'));
        return back();
    });
    Route::get('/data_superadmin/verifikasi_data', [DataController::class, 'verifikasi_data'])->name('data_superadmin');


    Route::get('/opd', [OpdController::class, 'index'])->name('opd');
    Route::get('/opd/create', [OpdController::class, 'create'])->name('opd');
    Route::post('/opd/store', [OpdController::class, 'store'])->name('opd');
    Route::get('/opd/edit/{id}', [OpdController::class, 'edit'])->name('opd');
    Route::post('/opd/update/{id}', [OpdController::class, 'update'])->name('opd');
    Route::get('/opd/destroy/{id}', [OpdController::class, 'destroy'])->name('opd');
    // Route::resource('opd', UserController::class);
    Route::post('/opd/import', function () {
        Excel::import(new OpdImport, request()->file('file'));
        return back();
    });
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user');
    Route::post('/user/store', [UserController::class, 'store'])->name('user');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user');
    Route::get('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user');
    // Route::resource('user', UserController::class);
    Route::post('/user/import', function () {
        Excel::import(new UserImport, request()->file('file'));
        return back();
    });
});

Route::middleware(['role:walidata'])->group(function () {
    Route::get('/d_walidata', [HomeController::class, 'index2'])->name('d_walidata');
    Route::get('/data_walidata', [DataController::class, 'index'])->name('data_walidata');
    Route::get('/data_walidata/create', [DataController::class, 'create'])->name('data_walidata');
    Route::post('/data_walidata/store', [DataController::class, 'store'])->name('data_walidata');
    Route::get('/data_walidata/edit/{id}', [DataController::class, 'edit'])->name('data_walidata');
    Route::post('/data_walidata/update/{id}', [DataController::class, 'update'])->name('data_walidata');
    Route::get('/data_walidata/destroy/{id}', [DataController::class, 'destroy'])->name('data_walidata');
    Route::get('/data_walidata/get_all_opdall', [DataController::class, 'get_all_opdall'])->name('data_walidata');

    Route::get('/get_data_opd', [DataController::class, 'get_all_opd'])->name('data_walidata');
    Route::get('/get_all_opdall', [DataController::class, 'get_all_opdall'])->name('data_walidata');
    Route::get('/get_all_opdall/cari/{id}', [DataController::class, 'cari_opd'])->name('data_walidata');

    Route::post('/data_walidata/export-pdf2', [DataController::class, 'pdf2'])->name('data_walidata');
    Route::get('/data_walidata/verifikasi_data', [DataController::class, 'verifikasi_data'])->name('data_walidata');

    Route::get('getData', [DataController::class, 'getData'])->name('getData');



    Route::post('/data_walidata/import', function () {
        Excel::import(new DataImport, request()->file('file'));
        return back();
    });
});

Route::middleware('role:produsen')->group(function () {
    Route::get('/d_produsen', [HomeController::class, 'index3'])->name('d_produsen');
    Route::get('/data_produsen', [DataController::class, 'index'])->name('data_produsen');
    Route::get('/data_produsen/create', [DataController::class, 'create'])->name('data_produsen');
    Route::post('/data_produsen/store', [DataController::class, 'store'])->name('data_produsen');
    Route::get('/data_produsen/edit/{id}', [DataController::class, 'edit'])->name('data_produsen');
    Route::post('/data_produsen/update/{id}', [DataController::class, 'update'])->name('data_produsen');
    Route::get('/data_produsen/destroy/{id}', [DataController::class, 'destroy'])->name('data_produsen');
    Route::get('/data_produsen/setuju/{id}', [DataController::class, 'setuju'])->name('data_produsen');
    Route::get('/data_produsen/tolak/{id}', [DataController::class, 'tolak'])->name('data_produsen');
    Route::get('/data_produsen/export-pdf', [DataController::class, 'pdf'])->name('data_produsen');
    Route::get('/data_produsen/selesai_konfirmasi', [DataController::class, 'selesai_konfirmasi'])->name('data_produsen');
    Route::get('/data_produsen/verifikasi_data', [DataController::class, 'input_produsen'])->name('data_produsen');

    Route::post('/data_produsen/import', function () {
        Excel::import(new DataImport, request()->file('file'));
        return back();
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
