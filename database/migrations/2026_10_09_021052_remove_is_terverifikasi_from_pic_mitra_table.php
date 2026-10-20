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
        Schema::table('pic_mitra', function (Blueprint $table): void {
            $table->dropColumn('is_terverifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pic_mitra', function (Blueprint $table): void {
            $table->boolean('is_terverifikasi')
                ->default(false)
                ->after('no_whatsapp');
        });
    }
};
