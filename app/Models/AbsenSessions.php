<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenSessions extends Model
{

    protected $table = 'absensessions'; 
    protected $fillable = ['tanggal', 'is_open','judul',];

    public function scopeOpen($query)
    {
    return $query->where('is_open', true);
    }
}
