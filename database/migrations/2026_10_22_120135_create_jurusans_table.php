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
        Schema::create('jurusan_mitra', function (Blueprint $table) {
            $table->id('id_jurusan');
            $table->unsignedBigInteger('id_mitra');
            $table->string('nama_jurusan');
            $table->string('no_telepon', 30)->nullable();
            $table->string('jenis_kontak')->nullable();
            $table->string('status_kontak', 40)->default('Belum Diverifikasi');
            $table->timestamps();

            $table->foreign('id_mitra')->references('id_mitra')->on('data_mitra')->cascadeOnDelete();
            $table->index(['id_mitra', 'nama_jurusan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_mitra');
    }
};
