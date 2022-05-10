<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Opd::data_opd();
        return view('pages.contents.superadmin.indexopd', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.contents.superadmin.createopd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Opd::create([
            'nama_opd' => $request->nama_opd,
        ]);
        activity()->log('Menambahkan OPD');
        return redirect('/opd');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function show(Opd $opd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Opd::findOrFail($id);
        // dd($user);
        return view('pages.contents.superadmin.editopd', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Opd::findOrFail($id);
        $user->update([
            'nama_opd' => $request->nama_opd,
        ]);
        activity()->log('Mengedit OPD');

        return redirect('/opd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Opd::findOrFail($id);
        // dd($user);
        $user->delete();
        activity()->log('Menghapus OPD');
        return redirect('/opd');
    }
}
