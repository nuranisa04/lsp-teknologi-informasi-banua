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
        Schema::create('jurusan_pic', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jurusan');
            $table->unsignedBigInteger('id_pic');
            $table->string('status_kontak', 40)->default('Belum Diverifikasi');
            $table->primary(['id_jurusan', 'id_pic']);
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan_mitra')->cascadeOnDelete();
            $table->foreign('id_pic')->references('id_pic')->on('pic_mitra')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_pic');
    }
};
