<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengumpulanController extends Controller
{
    public function struktur()
    {
        return view('pages.contents.administrator.pengumpulan.struktur-data');
    }
}
