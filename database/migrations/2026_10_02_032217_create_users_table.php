<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id('id_user');

            $table->foreignId('id_role')
                ->constrained('roles', 'id_role')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nama');

            $table->string('email')
                ->unique();

            $table->string('password');

            $table->string('no_whatsapp', 30)
                ->nullable();

            $table->enum('status', [
                'aktif',
                'tidak aktif'
            ])->default('aktif');

            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};