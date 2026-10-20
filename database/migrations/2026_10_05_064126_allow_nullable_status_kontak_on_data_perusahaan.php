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
            ])->nullable()->default('Belum Diverifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('data_perusahaan')
            ->whereNull('status_kontak')
            ->update(['status_kontak' => 'Belum Diverifikasi']);

        Schema::table('data_perusahaan', function (Blueprint $table) {
            $table->enum('status_kontak', [
                'Belum Diverifikasi',
                'Kontak Perusahaan',
                'Terverifikasi PIC',
                'Bukan PIC',
                'Tidak Dapat Dihubungi',
            ])->nullable(false)->default('Belum Diverifikasi')->change();
        });
    }
};
