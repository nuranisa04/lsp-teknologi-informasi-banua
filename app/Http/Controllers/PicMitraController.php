<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\PicMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PicMitraController extends Controller
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

    public function index(Request $request)
    {
        $query = PicMitra::with(
            'mitra'
        );

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_pic',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'jabatan',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'no_whatsapp',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas(
                        'mitra',
                        function ($mitra) use ($search) {

                            $mitra->where(
                                'nama_mitra',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

            });

        }

        $pics = $query
            ->latest('id_pic')
            ->paginate(10)
            ->withQueryString();

        return view(
            'pic.data_pic',
            compact('pics')
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

        $mitra = Mitra::orderBy(
            'nama_mitra'
        )->get();

        return view(
            'pic.tambah_data_pic',
            compact('mitra')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE - CREATE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $this->adminOnly();

        $data = $this->validateData(
            $request
        );

        DB::transaction(function () use ($data): void {
            $mitra = Mitra::query()
                ->whereKey($data['id_mitra'])
                ->lockForUpdate()
                ->firstOrFail();

            PicMitra::create([
                'id_mitra' => $data['id_mitra'],
                'nama_pic' => $data['nama_pic'],
                'jabatan' => $data['jabatan'],
                'email' => $data['email'] ?? null,
                'no_whatsapp' => $data['no_whatsapp'],
                'status' => $data['status'],
            ]);

            $mitra->syncContactStatusFromPics();
        });

        return redirect()
            ->route('pic.index')
            ->with(
                'success',
                'Data PIC berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT - UPDATE FORM
    |--------------------------------------------------------------------------
    */

    public function edit(
        PicMitra $pic
    ) {

        $this->adminOnly();

        $mitra = Mitra::orderBy(
            'nama_mitra'
        )->get();

        return view(
            'pic.edit_data_pic',
            compact(
                'pic',
                'mitra'
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
        PicMitra $pic
    ) {

        $this->adminOnly();

        $data = $this->validateData(
            $request
        );

        $previousMitraId = $pic->id_mitra;
        $mitraChanged = (int) $previousMitraId !== (int) $data['id_mitra'];

        DB::transaction(function () use (
            $data,
            $pic,
            $previousMitraId,
            $mitraChanged
        ): void {
            $mitras = Mitra::query()
                ->whereKey([$previousMitraId, $data['id_mitra']])
                ->orderBy('id_mitra')
                ->lockForUpdate()
                ->get()
                ->keyBy('id_mitra');

            $previousMitra = $mitras->get($previousMitraId);
            $nextMitra = $mitras->get($data['id_mitra']);

            if (! $previousMitra || ! $nextMitra) {
                abort(404);
            }

            $pic->update([
                'id_mitra' => $data['id_mitra'],
                'nama_pic' => $data['nama_pic'],
                'jabatan' => $data['jabatan'],
                'email' => $data['email'] ?? null,
                'no_whatsapp' => $data['no_whatsapp'],
                'status' => $data['status'],
            ]);

            if ($mitraChanged) {
                $previousMitra->syncContactStatusFromPics();
                $nextMitra->syncContactStatusFromPics();
            }
        });

        return redirect()
            ->route('pic.index')
            ->with(
                'success',
                'Data PIC berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI HAPUS
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(
        PicMitra $pic
    ) {

        $this->adminOnly();

        $pic->load('mitra');
        $statusKontakAfterDeletion = $pic->mitra->contactStatusFromPics($pic);

        return view(
            'pic.hapus_data_pic',
            compact('pic', 'statusKontakAfterDeletion')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        PicMitra $pic
    ) {

        $this->adminOnly();

        DB::transaction(function () use ($pic): void {
            $mitra = Mitra::query()
                ->whereKey($pic->id_mitra)
                ->lockForUpdate()
                ->firstOrFail();

            $pic->delete();

            $mitra->syncContactStatusFromPics();
        });

        return redirect()
            ->route('pic.index')
            ->with(
                'success',
                'Data PIC berhasil dihapus.'
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

        $data = $request->validate([

            'id_mitra' => [

                'required',

                'exists:data_mitra,id_mitra',

            ],

            'nama_pic' => [

                'required',

                'string',

                'max:255',

            ],

            'jabatan' => [

                'required',

                'string',

                'max:255',

            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'no_whatsapp' => [
                'required',
                'regex:/\A[0-9]{1,13}\z/',

            ],

            'status' => [

                'required',

                Rule::in([

                    'Aktif',

                    'Tidak Aktif',

                ]),

            ],

        ], [
            'email.email' => 'Format email PIC tidak valid.',
            'email.max' => 'Email PIC maksimal 255 karakter.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka dan maksimal 13 digit.',
        ]);

        return $data;
    }
}
