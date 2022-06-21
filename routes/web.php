<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PengumpulanController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\UpdownloadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use App\Imports\DataImport;
use App\Imports\OpdImport;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/masuk', function () {
    return redirect('login');
});
Route::get('/', [PortalController::class, 'index']);
Route::get('/tentang', [PortalController::class, 'tentang']);
Route::get('/datas', [PortalController::class, 'data']);
Route::get('/berita', [PortalController::class, 'berita']);
Route::get('/ckan', [PortalController::class, 'ckan']);
Auth::routes();
// Route::get('/d_administrator', [App\Http\Controllers\HomeController::class, 'index'])->name('d_administrator');
// Route::get('/d_walidata', [App\Http\Controllers\HomeController::class, 'index'])->name('d_walidata');
// Route::get('/d_produsen', [App\Http\Controllers\HomeController::class, 'index'])->name('d_produsen');

// Route::middleware('role:administrator')->get('/d_administrator', function () {
//         return 'Dashboard';
//     })->name('d_administrator');

Route::middleware(['role:administrator'])->group(function () {
    Route::get('/d_administrator', [HomeController::class, 'index1'])->name('d_administrator');
    Route::get('/data_administrator', [DataController::class, 'index'])->name('data_administrator');
    Route::get('/data_administrator/create', [DataController::class, 'create'])->name('data_administrator');
    Route::post('/data_administrator/store', [DataController::class, 'store'])->name('data_administrator');
    Route::get('/data_administrator/edit/{id}', [DataController::class, 'edit'])->name('data_administrator');
    Route::post('/data_administrator/update/{id}', [DataController::class, 'update'])->name('data_administrator');
    Route::get('/data_administrator/destroy/{id}', [DataController::class, 'destroy'])->name('data_administrator');
    // Route::resource('data_administrator', DataController::class);
    Route::get('/data_administrator/get_all_opdall', [DataController::class, 'get_all_opdall'])->name('data_administrator');

    Route::post('/data/import', function () {
        Excel::import(new DataImport, request()->file('file'));
        return back();
    });
    Route::get('/data_administrator/verifikasi_data', [DataController::class, 'verifikasi_data'])->name('data_administrator');


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


    Route::get('/upload-download', [UpdownloadController::class, 'index'])->name('user');
    Route::get('/upload', [UpdownloadController::class, 'upload'])->name('user');
    Route::post('/upload-proses', [UpdownloadController::class, 'proses_upload'])->name('user');
    Route::get('/upload-hapus/{id}', [UpdownloadController::class, 'destroy'])->name('user');
    Route::get('/download/{id}', [UpdownloadController::class, 'download'])->name('user');
});

Route::middleware(['role:walidata'])->group(function () {
    Route::get('/d_walidata', [HomeController::class, 'index2'])->name('d_walidata');

    Route::get('/data_walidata/draft', [DataController::class, 'index'])->name('draft');
    Route::get('/data_walidata/create', [DataController::class, 'create'])->name('data_walidata');
    Route::post('/data_walidata/store', [DataController::class, 'store'])->name('data_walidata');
    Route::get('/data_walidata/edit/{id}', [DataController::class, 'edit'])->name('edit_walidata');
    Route::get('/data_walidata/detail/{id}', [DataController::class, 'detail'])->name('detail_walidata');
    Route::post('/data_walidata/update/{id}', [DataController::class, 'update'])->name('data_walidata');
    Route::get('/data_walidata/destroy/{id}', [DataController::class, 'destroy'])->name('data_walidata');
    Route::get('/data_walidata/get_all_opdall', [DataController::class, 'get_all_opdall'])->name('data_walidata');

    Route::get('/get_data_opd', [DataController::class, 'get_all_opd'])->name('data_walidata');
    Route::get('/get_all_opdall', [DataController::class, 'get_all_opdall'])->name('data_walidata');
    Route::get('/get_all_opdall/cari/{id}', [DataController::class, 'cari_opd'])->name('data_walidata');

    // Route::post('/data_walidata/export-pdf', [DataController::class, 'pdf2'])->name('data_walidata');
    Route::get('/data_walidata/export-pdf2', [DataController::class, 'pdf2'])->name('data_walidata');
    Route::get('/data_walidata/verifikasi_data', [DataController::class, 'verifikasi_data'])->name('data_walidata');
    Route::get('/data_walidata/tolak_konfirmasi_walidata', [DataController::class, 'tolak_konfirmasi_walidata'])->name('tolak_konfirmasi_walidata');
    Route::get('/data_walidata/selesai_konfirmasi_walidata', [DataController::class, 'selesai_konfirmasi_walidata'])->name('selesai_konfirmasi_walidata');
    Route::get('/data_walidata/restore/{id}', [DataController::class, 'restore'])->name('data_walidata');
    Route::get('getData', [DataController::class, 'getData'])->name('getData');

    Route::get('/data_walidata/pengumpulan', [PengumpulanController::class, 'pengumpulan']);
    Route::get('/data_walidata/pengumpulan/{id}/data', [PengumpulanController::class, 'detailData']);
    Route::get('/data_walidata/pengumpulan/{id}/variabel', [PengumpulanController::class, 'variabel'])->name('variabel');
    Route::get('/data_walidata/pengumpulan/{id}/standar', [PengumpulanController::class, 'standarData'])->name('standar');


    Route::post('/data_walidata/import', function () {
        Excel::import(new DataImport, request()->file('file'));
        return back();
    });
    Route::get('/up-download/{id}', [UpdownloadController::class, 'download'])->name('user1');
    Route::get('/data_walidata/notif', [DataController::class, 'notif'])->name('notif');
    Route::get('/draft', [DataController::class, 'draft'])->name('draft');
});

Route::middleware('role:produsen')->group(function () {
    Route::get('/d_produsen', [HomeController::class, 'index3'])->name('d_produsen');
    Route::get('/data_produsen/draft', [DataController::class, 'index'])->name('draft');
    Route::get('/data_produsen/create', [DataController::class, 'create'])->name('data_produsen');
    Route::post('/data_produsen/store', [DataController::class, 'store'])->name('data_produsen');
    Route::get('/data_produsen/edit/{id}', [DataController::class, 'edit'])->name('data_produsen');
    Route::post('/data_produsen/update/{id}', [DataController::class, 'update'])->name('data_produsen');
    Route::get('/data_produsen/detail/{id}', [DataController::class, 'detail'])->name('detail_produsen');
    Route::post('/data_produsen/alasan/{id}', [DataController::class, 'alasan'])->name('data_produsen');
    Route::get('/data_produsen/destroy/{id}', [DataController::class, 'destroy'])->name('data_produsen');
    Route::get('/data_produsen/setuju/{id}', [DataController::class, 'setuju'])->name('data_produsen');
    Route::get('/data_produsen/tolak/{id}', [DataController::class, 'tolak'])->name('data_produsen');
    Route::get('/data_produsen/show/{id}', [DataController::class, 'show'])->name('data_produsen');
    Route::get('/data_produsen/export-pdf', [DataController::class, 'pdf'])->name('data_produsen');
    Route::get('/data_produsen/selesai_konfirmasi', [DataController::class, 'selesai_konfirmasi'])->name('setuju');
    Route::get('/data_produsen/tolak_konfirmasi', [DataController::class, 'tolak_konfirmasi'])->name('tolak');

    Route::get('/data_produsen/pengumpulan/{id}/data', [PengumpulanController::class, 'detailData']);
    Route::patch('/data_produsen/pengumpulan/{id}/data', [PengumpulanController::class, 'simpanData'])->name('simpan-data');

    Route::get('/data_produsen/pengumpulan/{id}/indikator', [PengumpulanController::class, 'indikator'])->name('indikator');
    Route::post('/data_produsen/pengumpulan/{id}/simpan-indikator', [PengumpulanController::class, 'simpanIndikator'])->name('simpan-indikator');
    Route::get('/data_produsen/pengumpulan/{id}/variabel', [PengumpulanController::class, 'variabel'])->name('variabel');
    Route::post('/data_produsen/pengumpulan/{id}/simpan-variabel', [PengumpulanController::class, 'simpanVariabel'])->name('simpan-variabel');
    Route::get('/data_produsen/pengumpulan/{id}/kegiatan', [PengumpulanController::class, 'kegiatan']);
    Route::post('/data_produsen/pengumpulan/{id}/kegiatan', [PengumpulanController::class, 'simpanKegiatan'])->name('simpan-kegiatan');
    Route::post('/data_produsen/pengumpulan/{id}/kegiatan/variabel-dikumpulkan', [PengumpulanController::class, 'simpanVariabelDikumpulkan'])->name('simpan-variabel-dikumpulkan');
    Route::post('/data_produsen/pengumpulan/{id}/kegiatan/publikasi', [PengumpulanController::class, 'simpanPublikasi'])->name('simpan-publikasi');

    Route::get('/data_produsen/pengumpulan', [PengumpulanController::class, 'pengumpulan'])->name('pengumpulan');
    Route::get('/data_produsen/indikator', [PengumpulanController::class, 'metaIndikator'])->name('meta-indikator');
    Route::view('/data_produsen/variabel/form', 'pages.contents.produsen.pengumpulan.form-variabel')->name('meta-indikator');
    Route::match(['get', 'post'], '/data_produsen/pengumpulan/{id}/standar', [PengumpulanController::class, 'standarData'])->name('standar');
    Route::post('/data_produsen/{id}/upload-berkas', [PengumpulanController::class, 'uploadBerkas'])->name('upload-berkas');
    Route::delete('/data_produsen/{id}/delete-berkas/{berkasId}', [PengumpulanController::class, 'deleteBerkas'])->name('delete-berkas');

    Route::post('/data_produsen/import', function () {
        Excel::import(new DataImport, request()->file('file'));
        return back();
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/filepreview', [FileController::class, 'preview'])->name('filepreview');
});

Route::get('/ajax/provinces', [WilayahController::class, 'province'])->name('ajax.provinces');
Route::get('/ajax/cities/{provinceId?}', [WilayahController::class, 'city'])->name('ajax.cities');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
