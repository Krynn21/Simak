<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas'; // Jika nama tabel Anda bukan 'gurus', sesuaikan di sini
    protected $primaryKey = 'id'; // Jika primary key Anda bukan 'id', sesuaikan di sini
    public $timestamps = true; // Jika Anda menggunakan timestamps (created_at, updated_at)

    protected $fillable = ['nama_kelas', 'tingkat'];

    public function gurus()
    {
        return $this->hasMany(Guru::class, 'id_kelas');
    }
    public function tingkat()
{
    return $this->belongsTo(Tingkat::class,'id_tingkat');
}
}
