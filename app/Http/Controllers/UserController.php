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

    public function index()
    {
        $this->adminOnly();

        $users = User::with('role')
            ->latest('id_user')
            ->paginate(10);

        return view(
            'users.index',
            compact('users')
        );
    }

    public function create()
    {
        $this->adminOnly();

        $roles = Role::orderBy('id_role')->get();

        return view(
            'users.tambah_user',
            compact('roles')
        );
    }

    public function store(Request $request)
    {
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
            ],

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak aktif',
                ]),
            ],
        ]);

        $data['password'] = Hash::make(
            $data['password']
        );

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }

    public function edit(User $user)
    {
        $this->adminOnly();

        $roles = Role::orderBy('id_role')->get();

        return view(
            'users.edit_user',
            compact(
                'user',
                'roles'
            )
        );
    }

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
            ],

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak aktif',
                ]),
            ],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make(
                $data['password']
            );
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil diperbarui.'
            );
    }

    public function destroy(User $user)
    {
        $this->adminOnly();

        if ($user->id_user === auth()->id()) {
            return back()->with(
                'error',
                'Akun yang sedang digunakan tidak dapat dihapus.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}