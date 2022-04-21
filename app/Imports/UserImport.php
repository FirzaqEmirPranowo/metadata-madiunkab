<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // return new User([
        //     'name'     => $row[0],
        //     'email'    => $row[1],
        //     'password' => Hash::make($row[2]),
        //     'role_id'    => $row[3],
        //     'opd_id'    => $row[4],
        // ]);

        if ($row[3] == '1') {
            $superadmin = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => Hash::make($row[2]),
                'role_id' => $row[3],
                'opd_id' => $row[4],
            ]);
            $superadmin->assignRole('superadmin');
            // return redirect('/user');
        } elseif ($row[3] == '2') {
            $walidata = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => Hash::make($row[2]),
                'role_id' => $row[3],
                'opd_id' => $row[4],
            ]);
            $walidata->assignRole('walidata');
            // return redirect('/user');
        } elseif ($row[3] == '3') {
            $produsen = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => Hash::make($row[2]),
                'role_id' => $row[3],
                'opd_id' => $row[4],
            ]);
            $produsen->assignRole('produsen');
            // return redirect('/user');
        }
    }
}
