<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function adminOnly(): void
    {
        abort_unless(
            auth()->user()->isAdmin(),
            403
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX - READ
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->adminOnly();

        $users = User::with('role')
            ->latest('id_user')
            ->paginate(10);

        return view(
            'users.data_user',
            compact('users')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->adminOnly();

        $roles = Role::orderBy(
            'id_role'
        )->get();

        return view(
            'users.tambah_data_user',
            compact('roles')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE - CREATE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ) {

        $this->adminOnly();

        $data = $request->validate([

            'id_role' => [

                'required',

                'exists:roles,id_role',

            ],

            'nama' => [

                'required',

                'string',

                'max:255',

            ],

            'email' => [

                'required',

                'email',

                'max:255',

                'unique:users,email',

            ],

            'password' => [

                'required',

                'string',

                'min:8',

            ],

            'no_whatsapp' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9]+$/',
            ],

            'status' => [

                'required',

                Rule::in([

                    'aktif',

                    'tidak aktif',

                ]),

            ],

        ], [
            'no_whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
        ]);

        $data['password'] =
            Hash::make(
                $data['password']
            );

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Data pengguna berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT - UPDATE FORM
    |--------------------------------------------------------------------------
    */

    public function edit(
        User $user
    ) {

        $this->adminOnly();

        $roles = Role::orderBy(
            'id_role'
        )->get();

        return view(
            'users.edit_data_user',
            compact(
                'user',
                'roles'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {

        $this->adminOnly();

        $data = $request->validate([

            'id_role' => [

                'required',

                'exists:roles,id_role',

            ],

            'nama' => [

                'required',

                'string',

                'max:255',

            ],

            'email' => [

                'required',

                'email',

                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore(
                    $user->id_user,
                    'id_user'
                ),

            ],

            'password' => [

                'nullable',

                'string',

                'min:8',

            ],

            'no_whatsapp' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9]+$/',
            ],

            'status' => [

                'required',

                Rule::in([

                    'aktif',

                    'tidak aktif',

                ]),

            ],

        ], [
            'no_whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            ! empty(
                $data['password']
            )
        ) {

            $data['password'] =
                Hash::make(
                    $data['password']
                );

        } else {

            unset(
                $data['password']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE USER
        |--------------------------------------------------------------------------
        */

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI HAPUS
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(
        User $user
    ) {

        $this->adminOnly();

        return view(
            'users.hapus_data_user',
            compact('user')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        User $user
    ) {

        $this->adminOnly();

        /*
        |--------------------------------------------------------------------------
        | Tidak boleh menghapus akun sendiri
        |--------------------------------------------------------------------------
        */

        if (
            $user->id_user === auth()->id()
        ) {

            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Akun yang sedang digunakan tidak dapat dihapus.'
                );

        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Data pengguna berhasil dihapus.'
            );
    }
}
