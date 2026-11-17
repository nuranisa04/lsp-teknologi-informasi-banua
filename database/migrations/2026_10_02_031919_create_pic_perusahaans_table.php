<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pic_perusahaan', function (Blueprint $table) {

            $table->id('id_pic');

            $table->foreignId('id_perusahaan')
                ->constrained(
                    'data_perusahaan',
                    'id_perusahaan'
                )
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('nama_pic');

            $table->string('jabatan');

            $table->string('email')
                ->nullable();

            $table->string('no_whatsapp', 30);

            $table->enum('status', [
                'Aktif',
                'Tidak Aktif'
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pic_perusahaan');
    }
};