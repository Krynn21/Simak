<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'id_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
{
    return $this->belongsTo(Role::class, 'id_role'); // <-- sesuai nama kolom
}
public function guru()
{
    return $this->hasOne(Guru::class, 'id_user');
// Di model User.php
}
public function isAdmin()
{
    return $this->role && strtolower($this->role->name) === 'admin'; // atau 'nama_role'
}
public function absens()
{
    return $this->hasMany(Absen::class, 'id_user');
}


}
