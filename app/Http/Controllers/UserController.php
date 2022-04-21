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
        // dd($data);
        // dd($data);
        return view('pages.contents.indexusers', compact('data'));
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
        return view('pages.contents.createuser', (compact('data', 'opd', 'role')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->role_id == '1') {
            $superadmin = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $superadmin->assignRole('superadmin');
            return redirect('/user');
        } elseif ($request->role_id == '2') {
            $walidata = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $walidata->assignRole('walidata');
            return redirect('/user');
        } elseif ($request->role_id == '3') {
            $produsen = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $produsen->assignRole('produsen');
            return redirect('/user');
        }
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
        return view('pages.contents.edituser', compact('byid', 'opd'));
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
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $user->assignRole('superadmin');
            return redirect('/user');
        } elseif ($request->role_id == '2') {
            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $user->assignRole('walidata');
            return redirect('/user');
        } elseif ($request->role_id == '3') {
            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role_id' => $request->role_id,
                'opd_id' => $request->opd_id,
            ]);
            $user->assignRole('produsen');
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
        // dd($user);
        $user->delete();

        return redirect('/user');
    }
}
