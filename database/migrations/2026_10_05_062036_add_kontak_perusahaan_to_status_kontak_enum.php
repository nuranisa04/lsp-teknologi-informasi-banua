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
        Schema::table('data_perusahaan', function (Blueprint $table) {
            $table->enum('status_kontak', [
                'Belum Diverifikasi',
                'Kontak Perusahaan',
                'Terverifikasi PIC',
                'Bukan PIC',
                'Tidak Dapat Dihubungi',
            ])->default('Belum Diverifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (
            DB::table('data_perusahaan')
                ->where('status_kontak', 'Kontak Perusahaan')
                ->exists()
        ) {
            throw new RuntimeException(
                'Reclassify company contacts before rolling back this migration.'
            );
        }

        Schema::table('data_perusahaan', function (Blueprint $table) {
            $table->enum('status_kontak', [
                'Belum Diverifikasi',
                'Terverifikasi PIC',
                'Bukan PIC',
                'Tidak Dapat Dihubungi',
            ])->default('Belum Diverifikasi')->change();
        });
    }
};
