<?php

namespace App\Http\Controllers;

use Laravolt\Indonesia\Models\City;

class WilayahController extends Controller
{
    public function province()
    {
        return \Indonesia::allProvinces();
    }

    public function city($provinceId = null)
    {
        return [
            'cities' => City::when(!empty($provinceId), fn($q) => $q->where('province_code', $provinceId))->get()
        ];
    }
}
