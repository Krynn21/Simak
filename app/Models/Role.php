<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // ini sudah benar

    protected $fillable = [
        'id',
        'name',
    ];
}

