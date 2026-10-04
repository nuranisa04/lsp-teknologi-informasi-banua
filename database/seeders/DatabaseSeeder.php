<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'nama_role' => 'Admin LSP'
        ]);

        $pimpinanRole = Role::firstOrCreate([
            'nama_role' => 'Pimpinan'
        ]);


        User::updateOrCreate(
            [
                'email' => 'admin@lsp.local'
            ],
            [
                'id_role' => $adminRole->id_role,
                'nama' => 'Admin LSP',
                'password' => Hash::make('password'),
                'no_whatsapp' => null,
                'status' => 'aktif',
            ]
        );


        User::updateOrCreate(
            [
                'email' => 'pimpinan@lsp.local'
            ],
            [
                'id_role' => $pimpinanRole->id_role,
                'nama' => 'Pimpinan',
                'password' => Hash::make('password'),
                'no_whatsapp' => null,
                'status' => 'aktif',
            ]
        );
    }
}