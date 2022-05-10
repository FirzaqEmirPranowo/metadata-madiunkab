<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdownloadController extends Controller
{
    public function index()
    {
        return view('pages.contents.superadmin.download');
    }
}
