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
        Schema::table('users', function (Blueprint $table): void {
            $table->string('username', 50)
                ->nullable()
                ->unique()
                ->after('nama');
        });

        DB::table('users')
            ->select(['id_user', 'email'])
            ->orderBy('id_user')
            ->chunk(100, function ($users): void {
                foreach ($users as $user) {
                    $emailPrefix = explode('@', $user->email, 2)[0];
                    $baseUsername = strtolower(
                        preg_replace('/[^a-zA-Z0-9_]+/', '_', $emailPrefix)
                        ?? ''
                    );
                    $baseUsername = trim($baseUsername, '_');
                    $baseUsername = $baseUsername !== '' ? $baseUsername : 'user';
                    $suffix = '_'.$user->id_user;
                    $username = substr(
                        $baseUsername,
                        0,
                        50 - strlen($suffix)
                    ).$suffix;

                    DB::table('users')
                        ->where('id_user', $user->id_user)
                        ->update(['username' => $username]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
