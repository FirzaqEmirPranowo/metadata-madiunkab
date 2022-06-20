<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\InteractsWithMedia;


class Data extends Model
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'data';
    protected $fillable = [
        'id',
        'nama_data',
        'opd_id',
        'jenis_data',
        'sumber_data',
        'status_id',
        'user_id',
        'alasan',
        'progress',
    ];

    protected $guarded = [];
    public $timestamps = true;

    public function data()
    {
        return Data::select('*')
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

    public function ActivityLog()
    {
        return $this->belongsTo(ActivityLog::class);
    }

    public function standar(): HasOne
    {
        return $this->hasOne(StandarData::class);
    }

    public function meta()
    {
        return $this->hasMany(strtolower($this->jenis_data) == 'Indikator' ? MetadataIndikator::class : MetadataVariabel::class, 'data_id');
    }

    public function indikator()
    {
        return $this->hasMany(MetadataIndikator::class);
    }

    public function variabel()
    {
        return $this->hasMany(MetadataVariabel::class);
    }

    public function kegiatan()
    {
        return $this->hasOne(MetadataKegiatan::class);
    }

    public function berkas(): HasMany
    {
        return $this->hasMany(Berkas::class);
    }

    public function calculateProgress(): int
    {
        $progress = 0;
        if (!empty($this->standar)) {
            $progress += 25;
        }

        if (!blank($this->indikator) && blank($this->variabel)) {
            $progress += 25;
        }

        if (blank($this->indikator) && !blank($this->variabel)) {
            $progress += 25;
        }

        if ($this->berkas->isNotEmpty()) {
            $progress += 10;
        }

        return min(100, $progress);
    }

    public function data_nonprodusen()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "name", "user_id", "opds.id", "data.id")
            // ->where('opds.id', '=', Auth::user()->opd_id)
            ->get();
    }


    public function data_draft_walidata()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "name", "user_id", "opds.id", "data.id",)
            // ->where('opds.id', '=', Auth::user()->opd_id)
            ->where('status_id', '=', '3')
            ->get();
    }


    public function data_tolak_walidata()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "alasan", "name", "user_id", "opds.id", "data.id")
            // ->where('opds.id', '=', Auth::user()->opd_id)
            ->where('status_id', '=', '2')
            ->get();
    }


    public function selesai_konfirmasi_walidata()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "name", "user_id", "opds.id", "data.id",)
            // ->where('opds.id', '=', Auth::user()->opd_id)
            ->where('status_id', '=', '1')
            ->get();
    }


    public function data_produsen()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "name", "user_id", "opds.id", "data.id")
            ->where('status_id', '=', '3')
            ->where('opds.id', '=', Auth::user()->opd_id)
            ->get();
    }


    public function selesai_konfirmasi()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "name", "user_id", "opds.id", "data.id")
            ->where('status_id', '=', '1')
            ->where('opds.id', '=', Auth::user()->opd_id)
            ->get();
    }


    public function tolak_konfirmasi()
    {
        // return Data::where('opd_id', '=', Auth::user()->opd_id)->get();
        return DB::table("data")
            ->join("opds", function ($join) {
                $join->on("data.opd_id", "=", "opds.id");
            })
            ->join("status", function ($join) {
                $join->on("data.status_id", "=", "status.id");
            })
            ->join("users", function ($join) {
                $join->on("data.user_id", "=", "users.id");
            })
            ->select("nama_opd", "nama_data", "jenis_data", "sumber_data", "status_id", "status", "name", "alasan", "user_id", "opds.id", "data.id")
            ->where('status_id', '=', '2')
            ->where('opds.id', '=', Auth::user()->opd_id)
            ->get();
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

    public function causer_id()
    {
        return DB::table("users")
            ->join("activity_log", function ($join) {
                $join->on("users.id", "=", "activity_log.causer_id");
            })
            ->join("data", function ($join) {
                $join->on("data.id", "=", "activity_log.subject_id");
            })
            ->select("users.name", "activity_log.description", "activity_log.created_at", "subject_id", "data.nama_data")
            ->orderby("activity_log.created_at", "DESC")
            ->get();
    }


    public function verifikasi_opd()
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
            ->where('opd_id', '=', Auth::user()->opd_id)
            ->get();
    }


    public function get_draft()
    {
        return Data::where('opd_id', '=', Auth::user()->opd_id)->where('status_id', '=', 3)->get();
        // return Data::select(opd_id)
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
