<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);
    }
    
}
