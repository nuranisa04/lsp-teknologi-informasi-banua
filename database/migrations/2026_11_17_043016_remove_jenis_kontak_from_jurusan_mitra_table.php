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
        if (Schema::hasColumn('jurusan_mitra', 'jenis_kontak')) {
            Schema::table('jurusan_mitra', function (Blueprint $table) {
                $table->dropColumn('jenis_kontak');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('jurusan_mitra', 'jenis_kontak')) {
            Schema::table('jurusan_mitra', function (Blueprint $table) {
                $table->string('jenis_kontak')->nullable();
            });
        }
    }
};
