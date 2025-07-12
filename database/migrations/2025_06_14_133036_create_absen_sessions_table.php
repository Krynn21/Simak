<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensessions', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable(); // contoh: "Absen Hari Senin"
            $table->date('tanggal');
            $table->boolean('is_open')->default(false); // status absen dibuka atau tidak
            $table->timestamps();
            $table->timestamp('dibuka_pada')->nullable()->after('is_open');
            $table->timestamp('ditutup_pada')->nullable()->after('dibuka_pada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensessions');
    }
};
