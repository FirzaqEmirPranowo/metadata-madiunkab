<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        return view('portal.landingpage.beranda');
    }

    public function tentang()
    {
        return view('portal.landingpage.tentang');
    }

    public function data()
    {
        return view('portal.landingpage.data');
    }

    public function berita()
    {
        return view('portal.landingpage.berita');
    }
    public function ckan()
    {
        return view('portal.landingpage.ckan');
    }
    // public function ckan()
    // {
    //     return redirect('login');
    // }
}
