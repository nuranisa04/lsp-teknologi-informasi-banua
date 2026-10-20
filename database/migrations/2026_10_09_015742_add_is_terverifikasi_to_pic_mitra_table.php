<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pic_mitra', function (Blueprint $table): void {
            $table->boolean('is_terverifikasi')
                ->default(false)
                ->after('no_whatsapp');
        });

        DB::table('pic_mitra')
            ->whereExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('data_mitra')
                    ->whereColumn('data_mitra.id_mitra', 'pic_mitra.id_mitra')
                    ->whereColumn('data_mitra.no_telepon', 'pic_mitra.no_whatsapp')
                    ->where('data_mitra.status_kontak', 'Terverifikasi PIC')
                    ->whereNotNull('data_mitra.no_telepon');
            })
            ->update(['pic_mitra.is_terverifikasi' => true]);
    }

    public function down(): void
    {
        Schema::table('pic_mitra', function (Blueprint $table): void {
            $table->dropColumn('is_terverifikasi');
        });
    }
};
