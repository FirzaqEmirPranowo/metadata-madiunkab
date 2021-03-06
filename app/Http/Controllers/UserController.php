<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Role;
use Illuminate\Http\Request;
// use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('opd')->with('role')->get();
        return view('pages.contents.administrator.indexusers', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opd = Opd::all();
        $role = Role::all();
        $data = User::with('opd')->with('role')->get();


        // dd($data);
        return view('pages.contents.administrator.createuser', (compact('data', 'opd', 'role')));
    }

    public function store(Request $request)
    {
        if ($request->role_id == '1') {
            $administrator = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $administrator->assignRole('administrator');
            activity()->performedOn($administrator)->log('membuat user (admin): '. $request->username);
        } elseif ($request->role_id == '2') {
            $walidata = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $walidata->assignRole('walidata');
            activity()->performedOn($walidata)->log('membuat user (walidata): ' . $request->username);
        } elseif ($request->role_id == '3') {
            $produsen = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $produsen->assignRole('produsen');
            activity()->performedOn($produsen)->log('membuat user (produsen): ' . $request->username);
        }

        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $byid = User::findOrFail($id);
        $opd = Opd::all();
        // dd($byid);
        return view('pages.contents.administrator.edituser', compact('byid', 'opd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $user = User::findOrFail($id);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        if ($request->role_id == '1') {
            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $user->assignRole('administrator');
            activity()->log('Update User');
            return redirect('/user');
        } elseif ($request->role_id == '2') {
            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $user->assignRole('walidata');
            activity()->log('Update User');
            return redirect('/user');
        } elseif ($request->role_id == '3') {
            $user->update([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $user->assignRole('produsen');
            activity()->log('Update User');
            return redirect('/user');
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        activity()->log('Mengapus user: '. $user->username);
        $user->delete();

        return redirect('/user');
    }
}
