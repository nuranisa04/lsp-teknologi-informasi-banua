<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MitraController extends Controller
{
    private const STATUS_MITRA = [
        'Calon',
        'Aktif',
        'Tidak Aktif',
    ];

    private const STATUS_KONTAK = [
        'Belum Diverifikasi',
        'Kontak Mitra',
        'Terverifikasi PIC',
        'Bukan PIC',
        'Tidak Dapat Dihubungi',
    ];

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
        $filters = $this->validatedFilters($request);
        $query = $this->filteredMitraQuery($filters);

        if ($request->user()->isPimpinan()) {
            $query->with('user:id_user,nama');
        }

        $mitra = $query
            ->latest('id_mitra')
            ->paginate(10)
            ->withQueryString();

        $kategoriMitra = Mitra::query()
            ->select('bidang_usaha')
            ->distinct()
            ->orderBy('bidang_usaha')
            ->pluck('bidang_usaha');

        return view(
            'mitra.data_mitra',
            compact('mitra', 'kategoriMitra')
        );
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->validatedFilters($request);
        unset($filters['search']);

        $query = $this->filteredMitraQuery(
            $filters
        )
            ->with('user:id_user,nama')
            ->orderBy('id_mitra');

        return response()->streamDownload(
            function () use ($query): void {
                $output = fopen('php://output', 'w');

                if ($output === false) {
                    throw new \RuntimeException('Tidak dapat menyiapkan file CSV.');
                }

                fwrite($output, "\xEF\xBB\xBF");
                fwrite($output, "sep=;\r\n");
                fputcsv($output, [
                    'Nama Mitra',
                    'Kategori Mitra',
                    'Alamat',
                    'Website',
                    'Email',
                    'Nomor Kontak',
                    'Sumber Data',
                    'Status Kontak',
                    'Status Mitra',
                    'Diinput Oleh',
                ], ';', '"', '');
                foreach ($query->lazy() as $mitra) {
                    fputcsv($output, [
                        $this->spreadsheetSafeValue($mitra->nama_mitra),
                        $this->spreadsheetSafeValue($mitra->bidang_usaha),
                        $this->spreadsheetSafeValue($mitra->alamat),
                        $this->spreadsheetSafeValue($mitra->website ?? ''),
                        $this->spreadsheetSafeValue($mitra->email ?? ''),
                        $this->spreadsheetSafeValue($mitra->no_telepon ?? ''),
                        $this->spreadsheetSafeValue($mitra->sumber_data ?? ''),
                        $this->spreadsheetSafeValue($mitra->status_kontak ?? ''),
                        $this->spreadsheetSafeValue($mitra->status),
                        $this->spreadsheetSafeValue($mitra->user?->nama ?? 'Tidak tercatat'),
                    ], ';', '"', '');
                }

                fclose($output);
            },
            'data-mitra-'.now()->format('Ymd-His').'.csv',
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }

    /**
     * @return array{search?: string|null, status?: string|null, status_kontak?: string|null, bidang_usaha?: string|null}
     */
    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(self::STATUS_MITRA)],
            'status_kontak' => [
                'nullable',
                Rule::in([...self::STATUS_KONTAK, '__kosong__']),
            ],
            'bidang_usaha' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * @param  array{search?: string|null, status?: string|null, status_kontak?: string|null, bidang_usaha?: string|null}  $filters
     */
    private function filteredMitraQuery(array $filters): Builder
    {
        $query = Mitra::query();

        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];

            $query->where(function (Builder $query) use ($search): void {
                $query->where('nama_mitra', 'like', "%{$search}%")
                    ->orWhere('bidang_usaha', 'like', "%{$search}%")
                    ->orWhere('no_telepon', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (($filters['status_kontak'] ?? null) === '__kosong__') {
            $query->whereNull('status_kontak');
        }

        foreach (['status', 'bidang_usaha'] as $column) {
            if (filled($filters[$column] ?? null)) {
                $query->where($column, $filters[$column]);
            }
        }

        if (
            filled($filters['status_kontak'] ?? null)
            && $filters['status_kontak'] !== '__kosong__'
        ) {
            $query->where('status_kontak', $filters['status_kontak']);
        }

        return $query;
    }

    private function spreadsheetSafeValue(string $value): string
    {
        if (preg_match('/^[\s\x00]*[=+\-@]/u', $value) === 1) {
            return "'".$value;
        }

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->adminOnly();

        return view(
            'mitra.tambah_data_mitra'
        );
    }

    public function show(Mitra $mitra)
    {
        $mitra->load([
            'pics',
            'user:id_user,nama',
        ]);

        return view(
            'mitra.detail_data_mitra',
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

        $user = auth()->user();

        DB::transaction(function () use ($data, $user) {

            $mitra =
                $user->mitras()->create([

                    'nama_mitra' => $data['nama_mitra'],

                    'bidang_usaha' => $data['bidang_usaha'],

                    'alamat' => $data['alamat'],

                    'website' => $data['website']
                        ?? null,

                    'email' => $data['email']
                        ?? null,

                    'no_telepon' => $data['no_telepon']
                        ?? null,

                    'sumber_data' => $data['sumber_data']
                        ?? null,

                    'status_kontak' => $data['status_kontak'] ?? null,

                    'status' => $data['status'],
                ]);

            /*
            |--------------------------------------------------------------------------
            | Jika langsung Terverifikasi PIC
            |--------------------------------------------------------------------------
            */

            $this->syncPic($mitra, $data);

        });

        return redirect()
            ->route('mitra.index')
            ->with(
                'success',
                'Data mitra berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT - UPDATE FORM
    |--------------------------------------------------------------------------
    */

    public function edit(
        Mitra $mitra
    ) {

        $this->adminOnly();

        $mitra->load('pics');

        return view(
            'mitra.edit_data_mitra',
            compact('mitra')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Mitra $mitra
    ) {

        $this->adminOnly();

        $data = $this->validateData(
            $request
        );

        DB::transaction(function () use (
            $data,
            $mitra
        ) {

            $mitra->update([

                'nama_mitra' => $data['nama_mitra'],

                'bidang_usaha' => $data['bidang_usaha'],

                'alamat' => $data['alamat'],

                'website' => $data['website']
                    ?? null,

                'email' => $data['email']
                    ?? null,

                'no_telepon' => $data['no_telepon']
                    ?? null,

                'sumber_data' => $data['sumber_data']
                    ?? null,

                'status_kontak' => $data['status_kontak'] ?? null,

                'status' => $data['status'],
            ]);

            $this->syncPic($mitra, $data);

        });

        return redirect()
            ->route('mitra.index')
            ->with(
                'success',
                'Data mitra berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI HAPUS
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(
        Mitra $mitra
    ) {

        $this->adminOnly();

        return view(
            'mitra.hapus_data_mitra',
            compact('mitra')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Mitra $mitra
    ) {

        $this->adminOnly();

        $mitra->delete();

        return redirect()
            ->route('mitra.index')
            ->with(
                'success',
                'Data mitra berhasil dihapus.'
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

        $rules = [

            'nama_mitra' => [
                'required',
                'string',
                'max:255',
            ],

            'kategori_mitra' => [
                'required',
                Rule::in(Mitra::KATEGORI_MITRA),
            ],

            'kategori_mitra_lainnya' => [
                'nullable',
                'required_if:kategori_mitra,Lainnya',
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
                'regex:/\A[0-9]{1,13}\z/',
            ],

            'sumber_data' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status_kontak' => [
                'nullable',
                Rule::in([
                    'Belum Diverifikasi',
                    'Kontak Mitra',
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
            | VALIDASI PIC
            |--------------------------------------------------------------------------
            */

            'nama_pic' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'nullable',
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
                'regex:/\A[0-9]{1,13}\z/',
            ],

        ];

        $isUnreachable = $request->input('status_kontak')
            === 'Tidak Dapat Dihubungi';

        $requiresPicDetails = ! $isUnreachable && collect([
            'nama_pic',
            'jabatan',
            'email_pic',
            'no_whatsapp_pic',
        ])->contains(fn (string $field): bool => $request->filled($field));

        if ($requiresPicDetails) {
            $rules['nama_pic'][] = 'required';
            $rules['jabatan'][] = 'required';

            if (
                $request->input('status_kontak') !== 'Terverifikasi PIC'
                || ! $request->filled('no_telepon')
            ) {
                $rules['no_whatsapp_pic'][] = 'required';
            }
        }

        $messages = [
            'email.email' => 'Format email mitra tidak valid.',
            'email.max' => 'Email mitra maksimal 255 karakter.',
            'email_pic.email' => 'Format email PIC tidak valid.',
            'email_pic.max' => 'Email PIC maksimal 255 karakter.',
            'no_telepon.regex' => 'Nomor kontak mitra hanya boleh berisi angka dan maksimal 13 digit.',
            'no_whatsapp_pic.regex' => 'Nomor WhatsApp PIC hanya boleh berisi angka dan maksimal 13 digit.',
        ];

        $data = $request->validate($rules, $messages);

        $data['bidang_usaha'] = $data['kategori_mitra'] === 'Lainnya'
            ? $data['kategori_mitra_lainnya']
            : $data['kategori_mitra'];

        unset(
            $data['kategori_mitra'],
            $data['kategori_mitra_lainnya'],
        );

        return $data;
    }

    /**
     * Save PIC data without replacing the mitra's initially discovered number.
     *
     * @param  array<string, mixed>  $data
     */
    private function syncPic(Mitra $mitra, array $data): void
    {
        $statusKontak = $data['status_kontak'] ?? null;
        if ($statusKontak === 'Tidak Dapat Dihubungi') {
            return;
        }

        $isVerifiedNumber = $statusKontak === 'Terverifikasi PIC'
            && filled($data['no_telepon'] ?? null)
            && isset($data['nama_pic'], $data['jabatan']);
        $isAlternatePicProvided = isset(
            $data['nama_pic'],
            $data['jabatan'],
            $data['no_whatsapp_pic'],
        );

        if (! $isVerifiedNumber && ! $isAlternatePicProvided) {
            if (
                $statusKontak === 'Bukan PIC'
                && filled($data['no_telepon'] ?? null)
            ) {
                $pic = $mitra->pics()
                    ->where('no_whatsapp', $data['no_telepon'])
                    ->first();

                if ($pic) {
                    $pic->delete();
                    $mitra->syncContactStatusFromPics();
                }
            }

            return;
        }

        $pic = $mitra->pics()->first();
        $attributes = [
            'nama_pic' => $data['nama_pic'],
            'jabatan' => $data['jabatan'],
            'email' => $data['email_pic'] ?? null,
            'no_whatsapp' => $isVerifiedNumber
                ? $data['no_telepon']
                : $data['no_whatsapp_pic'],
            'status' => 'Aktif',
        ];

        if ($pic) {
            $pic->update($attributes);

            return;
        }

        $mitra->pics()->create($attributes);
    }
}
