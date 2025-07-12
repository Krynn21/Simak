<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = [
        'id_user',
        'absen_session_id',
        'status',
        'keterangan',
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
public function sesi()
{
    return $this->belongsTo(AbsenSessions::class, 'absen_session_id');
}


}
