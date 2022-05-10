<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use LogsActivity;
    use HasFactory;
    protected $table = 'activitylog';

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
