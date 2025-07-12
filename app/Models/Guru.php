<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru'; // Jika nama tabel Anda bukan 'gurus', sesuaikan di sini
    protected $primaryKey = 'id'; // Jika primary key Anda bukan 'id', sesuaikan di sini
    public $timestamps = true; // Jika Anda menggunakan timestamps (created_at, updated_at)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'alamat',
        // tambahkan field lain sesuai kebutuhan
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}

public function mapel()
{
    return $this->belongsTo(Mapel::class,'id_mapel');
}

public function kelas()
{
    return $this->belongsTo(Kelas::class,'id_kelas');
}


}
