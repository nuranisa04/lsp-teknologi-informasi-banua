<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('data_mitra')
            ->where('bidang_usaha', 'Sekolah / SMK')
            ->update(['bidang_usaha' => 'Sekolah']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('data_mitra')
            ->where('bidang_usaha', 'Sekolah')
            ->update(['bidang_usaha' => 'Sekolah / SMK']);
    }
};
