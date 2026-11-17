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
        $hasStatusKontak = Schema::hasColumn('jurusan_pic', 'status_kontak');
        $hasCreatedAt = Schema::hasColumn('jurusan_pic', 'created_at');
        $hasUpdatedAt = Schema::hasColumn('jurusan_pic', 'updated_at');

        if ($hasStatusKontak) {
            Schema::table('jurusan_pic', function (Blueprint $table) {
                $table->dropColumn('status_kontak');
            });
        }

        if (! $hasCreatedAt || ! $hasUpdatedAt) {
            Schema::table('jurusan_pic', function (Blueprint $table) use ($hasCreatedAt, $hasUpdatedAt) {
                if (! $hasCreatedAt) {
                    $table->timestamp('created_at')->nullable();
                }

                if (! $hasUpdatedAt) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('jurusan_pic', 'status_kontak')) {
            Schema::table('jurusan_pic', function (Blueprint $table) {
                $table->string('status_kontak', 40)->default('Belum Diverifikasi');
            });
        }
    }
};
