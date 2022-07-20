<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PengumpulanController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\UpdownloadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Produsen;
use App\Http\Controllers\Walidata;
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
Route::get('/dataset', [PortalController::class, 'data'])->name('dataset');
Route::get('/berita', [PortalController::class, 'berita']);
Route::get('/ckan', [PortalController::class, 'ckan']);
Auth::routes();

Route::middleware(['role:administrator', 'auth:web'])->group(function () {
    Route::get('/d_administrator', [HomeController::class, 'dashboardAdmin'])->name('d_administrator');
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

Route::middleware(['role:walidata', 'auth:web'])->group(function () {
    Route::get('/d_walidata', [HomeController::class, 'dashboardWalidata'])->name('d_walidata');

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
    Route::get('/data_walidata/pengumpulan/{id}/indikator', [PengumpulanController::class, 'indikator']);
    Route::get('/data_walidata/pengumpulan/{id}/variabel', [PengumpulanController::class, 'variabel']);
    Route::get('/data_walidata/pengumpulan/{id}/standar', [PengumpulanController::class, 'standarData']);
    Route::get('/data_walidata/pengumpulan/{id}/kegiatan', [PengumpulanController::class, 'kegiatan']);

    Route::get('/data_walidata/verifikasi', [Walidata\VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/data_walidata/verifikasi/{id}/berkas', [Walidata\VerifikasiController::class, 'berkas'])->name('verifikasi.berkas');
    Route::get('/data_walidata/verifikasi/{id}/variabel', [Walidata\VerifikasiController::class, 'variabel'])->name('verifikasi.variabel');
    Route::get('/data_walidata/verifikasi/{id}/indikator', [Walidata\VerifikasiController::class, 'indikator'])->name('verifikasi.indikator');
    Route::get('/data_walidata/verifikasi/{id}/komentar', [Walidata\VerifikasiController::class, 'getKomentar'])->name('verifikasi.get-komentar');
    Route::post('/data_walidata/verifikasi/{id}/komentar', [Walidata\VerifikasiController::class, 'komentar'])->name('verifikasi.komentar');
    Route::patch('/data_walidata/verifikasi/{id}/verify', [Walidata\VerifikasiController::class, 'verify'])->name('verifikasi.verify');
    Route::get('/data_walidata/verifikasi/{id}/status', [Walidata\VerifikasiController::class, 'status'])->name('verifikasi.status');
    Route::patch('/data_walidata/verifikasi/{id}/complete', [Walidata\VerifikasiController::class, 'complete'])->name('verifikasi.complete');

    Route::group(['prefix' => '/data_walidata/publikasi', 'as' => 'publikasi.'], function() {
        Route::get('/', [Walidata\PublikasiController::class, 'index'])->name('index');
        Route::get('/{id}/organisasi', [Walidata\PublikasiController::class, 'organisasi'])->name('organisasi');
        Route::post('/{id}/organisasi', [Walidata\PublikasiController::class, 'simpanOrganisasi'])->name('organisasi.store');
        Route::post('organisasi/create', [Walidata\PublikasiController::class, 'createOrganisasi'])->name('organisasi.create');
        Route::get('/{id}/dataset', [Walidata\PublikasiController::class, 'dataset'])->name('dataset');
        Route::post('/{id}/dataset', [Walidata\PublikasiController::class, 'simpanDataset'])->name('dataset.store');
        Route::get('/{id}/review', [Walidata\PublikasiController::class, 'review'])->name('review');
        Route::post('/{id}/publish', [Walidata\PublikasiController::class, 'publish'])->name('publish');
    });

    Route::post('/data_walidata/import', [DataController::class, 'importData']);
    Route::get('/data_walidata/notif', [DataController::class, 'notif'])->name('notif');
    Route::get('/draft', [DataController::class, 'draft'])->name('draft');
});

Route::middleware(['role:produsen', 'auth:web'])->group(function () {
    Route::get('/d_produsen', [HomeController::class, 'dashboardProdusen'])->name('d_produsen');
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
    Route::get('/data_produsen/pengumpulan/{id}/indikator', [PengumpulanController::class, 'indikator'])->name('indikator');
    Route::post('/data_produsen/pengumpulan/{id}/simpan-indikator', [PengumpulanController::class, 'simpanIndikator'])->name('simpan-indikator');
    Route::post('/data_produsen/pengumpulan/{id}/upload-indikator', [PengumpulanController::class, 'importIndikator'])->name('import-indikator');
    Route::get('/data_produsen/pengumpulan/{id}/variabel', [PengumpulanController::class, 'variabel'])->name('variabel');
    Route::post('/data_produsen/pengumpulan/{id}/simpan-variabel', [PengumpulanController::class, 'simpanVariabel'])->name('simpan-variabel');
    Route::post('/data_produsen/pengumpulan/{id}/upload-variabel', [PengumpulanController::class, 'importVariabel'])->name('import-variabel');
    Route::get('/data_produsen/pengumpulan/{id}/kegiatan', [PengumpulanController::class, 'kegiatan']);
    Route::post('/data_produsen/pengumpulan/{id}/kegiatan', [PengumpulanController::class, 'simpanKegiatan'])->name('simpan-kegiatan');
    Route::post('/data_produsen/pengumpulan/{id}/kegiatan/variabel-dikumpulkan', [PengumpulanController::class, 'simpanVariabelDikumpulkan'])->name('simpan-variabel-dikumpulkan');
    Route::post('/data_produsen/pengumpulan/{id}/kegiatan/publikasi', [PengumpulanController::class, 'simpanPublikasi'])->name('simpan-publikasi');
    Route::patch('/data_produsen/pengumpulan/{id}/verifikasi', [PengumpulanController::class, 'siapVerifikasi'])->name('siap-verifikasi');

    Route::get('/data_produsen/verifikasi', [Produsen\VerifikasiController::class, 'index']);

    Route::get('/data_produsen/pengumpulan/{id}/export', [PengumpulanController::class, 'exportData'])->name('export-data');

    Route::get('/data_produsen/pengumpulan', [PengumpulanController::class, 'pengumpulan'])->name('pengumpulan');
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
    Route::get('/up-download/{id}', [UpdownloadController::class, 'download']);
});

Route::get('/ajax/provinces', [WilayahController::class, 'province'])->name('ajax.provinces');
Route::get('/ajax/cities/{provinceId?}', [WilayahController::class, 'city'])->name('ajax.cities');
Route::get('/ajax/opds', [OpdController::class, 'opds'])->name('ajax.opds');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
