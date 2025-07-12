<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel'; // Jika nama tabel Anda bukan 'gurus', sesuaikan di sini
    protected $primaryKey = 'id'; // Jika primary key Anda bukan 'id', sesuaikan di sini
    public $timestamps = true; // Jika Anda menggunakan timestamps (created_at, updated_at)

    protected $fillable = [
        'nama_mapel',
        // tambahkan field lain sesuai kebutuhan
    ];
}
