<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_perusahaan', function (Blueprint $table) {

            $table->id('id_perusahaan');

            $table->string('nama_perusahaan');

            $table->string('bidang_usaha');

            $table->text('alamat');

            $table->string('website')
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->string('no_telepon', 30)
                ->nullable();

            $table->string('sumber_data')
                ->nullable();

            $table->enum('status_kontak', [
                'Belum Diverifikasi',
                'Terverifikasi PIC',
                'Bukan PIC',
                'Tidak Dapat Dihubungi'
            ])->default('Belum Diverifikasi');

            $table->enum('status', [
                'Calon',
                'Aktif',
                'Tidak Aktif'
            ])->default('Calon');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_perusahaan');
    }
};