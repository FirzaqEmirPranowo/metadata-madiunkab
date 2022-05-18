<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Role;
use App\Models\Opd;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $getrole = Role::select('id')->where('name', '=', $row['Role'])->get();
        $role = $getrole[0]->id;
        $cek_opd = Opd::select('id')->where('nama_opd', '=', $row['OPD'])->get();
        $hasil =  $cek_opd->id;
        dd($hasil);

        if ($role == '1') {
            $administrator = User::create([
                'name' => $row['Nama'],
                'username' => $row['Username'],
                'email' => $row['Email'],
                'password' => Hash::make($row['Password']),
                'role_id' => $role,
                'opd_id' => $hasil,
            ]);
            $administrator->assignRole('administrator');
            // return redirect('/user');
        } elseif ($role == '2') {
            $walidata = User::create([
                'name' => $row['Nama'],
                'username' => $row['Username'],
                'email' => $row['Email'],
                'password' => Hash::make($row['Password']),
                'role_id' => $role,
                'opd_id' => $hasil,
            ]);
            $walidata->assignRole('walidata');
            // return redirect('/user');
        } elseif ($role == '3') {
            $produsen = User::create([
                'name' => $row['Nama'],
                'username' => $row['Username'],
                'email' => $row['Email'],
                'password' => Hash::make($row['Password']),
                'role_id' => $role,
                'opd_id' => $hasil,
            ]);
            $produsen->assignRole('produsen');
            // return redirect('/user');
        }
    }
}
