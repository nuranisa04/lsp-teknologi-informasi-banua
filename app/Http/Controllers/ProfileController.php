<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $this->profileUser($request);
        $user->load('role');

        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $this->adminOnly($request);

        $user = $this->profileUser($request);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id_user, 'id_user'),
            ],
            'no_whatsapp' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9]+$/',
            ],
            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'email.unique' => 'Email sudah digunakan pengguna lain.',
            'no_whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
        ]);
        unset($data['profile_photo']);

        if ($request->hasFile('profile_photo')) {
            $previousPhotoPath = $user->foto_profile;
            $photoPath = $request->file('profile_photo')->store(
                'profile-photos',
                'public'
            );

            if ($photoPath === false) {
                throw new \RuntimeException('Foto profil gagal disimpan.');
            }

            $data['foto_profile'] = $photoPath;
        }

        $user->update($data);

        if (
            isset($previousPhotoPath)
            && $previousPhotoPath !== null
            && Storage::disk('public')->exists($previousPhotoPath)
            && ! Storage::disk('public')->delete($previousPhotoPath)
        ) {
            report(new \RuntimeException('Foto profil lama gagal dihapus.'));
        }

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $this->adminOnly($request);

        $user = $this->profileUser($request);

        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password_baru' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',
            ],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        $user->update([
            'password' => Hash::make($data['password_baru']),
        ]);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Password berhasil diperbarui.');
    }

    private function profileUser(Request $request): User
    {
        $user = $request->user();

        abort_unless(
            $user instanceof User
                && ($user->isAdmin() || $user->isPimpinan()),
            403
        );

        return $user;
    }

    private function adminOnly(Request $request): void
    {
        abort_unless(
            $request->user()?->isAdmin() ?? false,
            403
        );
    }
}
