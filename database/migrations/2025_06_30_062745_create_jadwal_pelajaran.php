<?php

// database/migrations/xxxx_xx_xx_create_jadwal_pelajaran_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('mapel_id');
            $table->string('hari'); // misal: Senin, Selasa, dst
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            // Relasi ke tabel kelas dan mapel
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwal_pelajaran');
    }
};
