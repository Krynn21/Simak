<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('guru', function (Blueprint $table) {
        $table->id();

        // Foreign key ke users
        $table->unsignedBigInteger('id_user');
        $table->unsignedBigInteger('id_mapel')->nullable();
        $table->unsignedBigInteger('id_kelas')->nullable();

        $table->string('alamat');
        $table->timestamps();

        // Letakkan foreign key SETELAH kolom didefinisikan (lebih rapi dan aman)
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('set null');
        $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
