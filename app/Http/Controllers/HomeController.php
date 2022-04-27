<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function index1()
    {
        // $role = Auth::user()->role;
        // dd($role);
        return view('pages.contents.walidata.dashboard');
    }

    public function index2()
    {
        return view('pages.contents.walidata.dashboard');
    }

    public function index3()
    {
        return view('pages.contents.walidata.dashboard');
    }
}
