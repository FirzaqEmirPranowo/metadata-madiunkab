<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Opd;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Data extends Model
{
    use HasFactory;

    protected $table = 'data';
    protected $fillable = [
        'id',
        'nama_data',
        'opd_id',
        'jenis_data',
        'sumber_data',
        'status_id',
    ];
    // protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = true;

    public function data()
    {
        return $users = Data::Select('*')
            ->get();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function data_produsen()
    {
        return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
    }

    public function verifikasi_data()
    {
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->select("data.id", "nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status")
            ->where("status_id", "=", 1)
            ->get();
    }

    public function get_draft()
    {
        return Data::where('opd_id', '=', Auth::user()->opd_id)->where('status_id', '=', 3)->get();
        // return $get_draf = DB::table('data')
        //     ->count('status_id')
        //     ->where('status_id', '=', 1)
        //     ->get();
    }

    public function data_produsen_setuju()
    {
        return Data::where('opd_id', '=', Auth::user()->opd_id)->where('status_id', '=', 1)->get();
    }

    public function data_produsen_setuju_all()
    {
        return Data::where('status_id', '=', 1)->get();
    }

    public function data_produsen_setuju_opd()
    {
        return Data::where('status_id', '=', 1)->get();
        // where('opd_id', '=', $id)->
    }

    public function scopeSetuju($query)
    {
        return $query->where('status_id', '=', 1);
    }

    public function scopeOPD($query, $id)
    {
        return $query->where('opd_id', '=', $id);
    }
}
