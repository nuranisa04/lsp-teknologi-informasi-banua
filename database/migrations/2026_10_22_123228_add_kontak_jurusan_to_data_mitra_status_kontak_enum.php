<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_mitra', function (Blueprint $table) {
            $table->enum('status_kontak', [
                'Belum Diverifikasi', 'Kontak Mitra', 'Kontak Jurusan',
                'Terverifikasi PIC', 'Bukan PIC', 'Tidak Dapat Dihubungi',
            ])->nullable()->default('Belum Diverifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('data_mitra')->where('status_kontak', 'Kontak Jurusan')->exists()) {
            throw new RuntimeException('Ubah status kontak jurusan sebelum membatalkan migration ini.');
        }

        Schema::table('data_mitra', function (Blueprint $table) {
            $table->enum('status_kontak', [
                'Belum Diverifikasi', 'Kontak Mitra', 'Terverifikasi PIC',
                'Bukan PIC', 'Tidak Dapat Dihubungi',
            ])->nullable()->default('Belum Diverifikasi')->change();
        });
    }
};
