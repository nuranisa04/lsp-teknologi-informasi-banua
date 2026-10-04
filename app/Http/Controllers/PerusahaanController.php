<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\PicPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PerusahaanController extends Controller
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
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Perusahaan::query();


        // Pencarian
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_perusahaan',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'bidang_usaha',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'no_telepon',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'email',
                    'like',
                    "%{$search}%"
                );
            });
        }


        // Filter status perusahaan
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        // Filter status kontak
        if ($request->filled('status_kontak')) {

            $query->where(
                'status_kontak',
                $request->status_kontak
            );
        }


        $perusahaan = $query
            ->latest('id_perusahaan')
            ->paginate(10)
            ->withQueryString();


        return view(
            'perusahaan.index',
            compact('perusahaan')
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

        $perusahaan = new Perusahaan();

        $perusahaan->setRelation(
            'pics',
            collect()
        );

        return view(
            'perusahaan.tambah_perusahaan',
            compact('perusahaan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $this->adminOnly();


        $data = $this->validateData(
            $request
        );


        DB::transaction(function () use ($data) {

            // Simpan perusahaan
            $perusahaan = Perusahaan::create([
                'nama_perusahaan' =>
                    $data['nama_perusahaan'],

                'bidang_usaha' =>
                    $data['bidang_usaha'],

                'alamat' =>
                    $data['alamat'],

                'website' =>
                    $data['website'] ?? null,

                'email' =>
                    $data['email'] ?? null,

                'no_telepon' =>
                    $data['no_telepon'] ?? null,

                'sumber_data' =>
                    $data['sumber_data'] ?? null,

                'status_kontak' =>
                    $data['status_kontak'],

                'status' =>
                    $data['status'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Jika langsung diverifikasi sebagai PIC
            |--------------------------------------------------------------------------
            */

            if (
                $data['status_kontak']
                === 'Terverifikasi PIC'
            ) {

                PicPerusahaan::create([

                    'id_perusahaan' =>
                        $perusahaan
                            ->id_perusahaan,

                    'nama_pic' =>
                        $data['nama_pic'],

                    'jabatan' =>
                        $data['jabatan'],

                    'email' =>
                        $data['email_pic']
                        ?? null,

                    'no_whatsapp' =>
                        $data['no_whatsapp_pic'],

                    'status' =>
                        'Aktif',
                ]);
            }

        });


        return redirect()
            ->route('perusahaan.index')
            ->with(
                'success',
                'Data perusahaan berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(
        Perusahaan $perusahaan
    ) {

        $perusahaan->load('pics');


        return view(
            'perusahaan.lihat_perusahaan',
            compact('perusahaan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        Perusahaan $perusahaan
    ) {

        $this->adminOnly();

        $perusahaan->load('pics');


        return view(
            'perusahaan.edit_perusahaan',
            compact('perusahaan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Perusahaan $perusahaan
    ) {

        $this->adminOnly();


        $data = $this->validateData(
            $request
        );


        DB::transaction(function () use (
            $data,
            $perusahaan
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update data perusahaan
            |--------------------------------------------------------------------------
            */

            $perusahaan->update([

                'nama_perusahaan' =>
                    $data['nama_perusahaan'],

                'bidang_usaha' =>
                    $data['bidang_usaha'],

                'alamat' =>
                    $data['alamat'],

                'website' =>
                    $data['website']
                    ?? null,

                'email' =>
                    $data['email']
                    ?? null,

                'no_telepon' =>
                    $data['no_telepon']
                    ?? null,

                'sumber_data' =>
                    $data['sumber_data']
                    ?? null,

                'status_kontak' =>
                    $data['status_kontak'],

                'status' =>
                    $data['status'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Terverifikasi sebagai PIC
            |--------------------------------------------------------------------------
            */

            if (
                $data['status_kontak']
                === 'Terverifikasi PIC'
            ) {

                $picLama =
                    $perusahaan
                        ->pics()
                        ->first();


                if ($picLama) {

                    // Update PIC yang sudah ada
                    $picLama->update([

                        'nama_pic' =>
                            $data['nama_pic'],

                        'jabatan' =>
                            $data['jabatan'],

                        'email' =>
                            $data['email_pic']
                            ?? null,

                        'no_whatsapp' =>
                            $data['no_whatsapp_pic'],

                        'status' =>
                            'Aktif',
                    ]);

                } else {

                    // Buat PIC baru
                    PicPerusahaan::create([

                        'id_perusahaan' =>
                            $perusahaan
                                ->id_perusahaan,

                        'nama_pic' =>
                            $data['nama_pic'],

                        'jabatan' =>
                            $data['jabatan'],

                        'email' =>
                            $data['email_pic']
                            ?? null,

                        'no_whatsapp' =>
                            $data['no_whatsapp_pic'],

                        'status' =>
                            'Aktif',
                    ]);
                }

            }

        });


        return redirect()
            ->route(
                'perusahaan.show',
                $perusahaan
            )
            ->with(
                'success',
                'Data perusahaan dan data PIC berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Perusahaan $perusahaan
    ) {

        $this->adminOnly();


        $perusahaan->delete();


        return redirect()
            ->route('perusahaan.index')
            ->with(
                'success',
                'Data perusahaan berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validateData(
        Request $request
    ): array {

        return $request->validate([

            'nama_perusahaan' => [
                'required',
                'string',
                'max:255',
            ],

            'bidang_usaha' => [
                'required',
                'string',
                'max:255',
            ],

            'alamat' => [
                'required',
                'string',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'no_telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'sumber_data' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status_kontak' => [
                'required',
                Rule::in([
                    'Belum Diverifikasi',
                    'Terverifikasi PIC',
                    'Bukan PIC',
                    'Tidak Dapat Dihubungi',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'Calon',
                    'Aktif',
                    'Tidak Aktif',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | VALIDASI DATA PIC
            |--------------------------------------------------------------------------
            */

            'nama_pic' => [
                'nullable',
                'required_if:status_kontak,Terverifikasi PIC',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'nullable',
                'required_if:status_kontak,Terverifikasi PIC',
                'string',
                'max:255',
            ],

            'email_pic' => [
                'nullable',
                'email',
                'max:255',
            ],

            'no_whatsapp_pic' => [
                'nullable',
                'required_if:status_kontak,Terverifikasi PIC',
                'string',
                'max:30',
            ],
        ]);
    }
}