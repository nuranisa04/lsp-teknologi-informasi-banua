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
        foreach (['data_mitra', 'jurusan_mitra'] as $tableName) {
            if (Schema::hasColumn($tableName, 'status_kontak')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('status_kontak');
                });
            }
        }

        if (! Schema::hasColumn('jurusan_mitra', 'jenis_kontak')) {
            Schema::table('jurusan_mitra', function (Blueprint $table) {
                $table->string('jenis_kontak')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
