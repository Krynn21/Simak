<?php
// app/Models/JadwalPelajaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'user_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(mapel::class, 'mapel_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

}
