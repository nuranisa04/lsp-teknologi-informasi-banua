<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MitraController extends Controller
{
    private const STATUS_MITRA = [
        'Calon',
        'Aktif',
        'Tidak Aktif',
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
        $query->with('jurusans:id_jurusan,id_mitra,nama_jurusan');

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
     * @return array{search?: string|null, status?: string|null, bidang_usaha?: string|null}
     */
    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(self::STATUS_MITRA)],
            'bidang_usaha' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * @param  array{search?: string|null, status?: string|null, bidang_usaha?: string|null}  $filters
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

        foreach (['status', 'bidang_usaha'] as $column) {
            if (filled($filters[$column] ?? null)) {
                $query->where($column, $filters[$column]);
            }
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
            'jurusans.pics',
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

            $data['resolved_pic_jurusan_ids'] = $this->syncJurusans($mitra, $data);
            $this->syncPics($mitra, $data);

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

        $mitra->load(['pics.jurusans', 'jurusans.pics']);

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

                'status_kontak' => $data['status_kontak'] ?? $mitra->status_kontak,

                'status' => $data['status'],
            ]);

            $data['resolved_pic_jurusan_ids'] = $this->syncJurusans($mitra, $data);
            $this->syncPics($mitra, $data);

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
            'pic_id' => ['nullable', 'integer'],
            'pic_jurusan_keys' => ['nullable', 'array'],
            'pic_jurusan_keys.*' => ['string', 'max:255'],
            'pics_present' => ['nullable', 'boolean'],
            'pics' => ['nullable', 'array'],
            'pics.*.id' => ['nullable', 'integer'],
            'pics.*.nama_pic' => ['nullable', 'string', 'max:255'],
            'pics.*.jabatan' => ['nullable', 'string', 'max:255'],
            'pics.*.email_pic' => ['nullable', 'email', 'max:255'],
            'pics.*.no_whatsapp' => ['nullable', 'regex:/\A[0-9]{1,13}\z/'],
            'pics.*.jurusan_keys' => ['nullable', 'array'],
            'pics.*.jurusan_keys.*' => ['string', 'max:255'],
            'jurusans' => ['nullable', 'array'],
            'jurusans_present' => ['nullable', 'boolean'],
            'jurusans.*.id' => ['nullable', 'integer'],
            'jurusans.*.nama' => ['nullable', 'string', 'max:255'],
            'jurusans.*.no_telepon' => ['nullable', 'regex:/\A[0-9]{1,13}\z/'],

        ];

        $requiresPicDetails = collect([
            'nama_pic',
            'jabatan',
            'email_pic',
            'no_whatsapp_pic',
        ])->contains(fn (string $field): bool => $request->filled($field));

        if ($requiresPicDetails) {
            $rules['nama_pic'][] = 'required';
            $rules['jabatan'][] = 'required';

            $rules['no_whatsapp_pic'][] = 'required';
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

        $legacyPic = [
            'id' => $data['pic_id'] ?? null,
            'nama_pic' => $data['nama_pic'] ?? null,
            'jabatan' => $data['jabatan'] ?? null,
            'email_pic' => $data['email_pic'] ?? null,
            'no_whatsapp' => $data['no_whatsapp_pic'] ?? null,
            'jurusan_keys' => $data['pic_jurusan_keys'] ?? [],
        ];
        $additionalPicRows = $data['pics'] ?? [];
        $hasLegacyPic = collect($legacyPic)->except('jurusan_keys')->contains(fn ($value): bool => filled($value));

        foreach ($additionalPicRows as $rowIndex => $picRow) {
            if (! is_array($picRow)) {
                continue;
            }

            $hasPicDetails = collect(['nama_pic', 'jabatan', 'email_pic', 'no_whatsapp'])
                ->contains(fn (string $field): bool => filled($picRow[$field] ?? null));
            if (! $hasPicDetails) {
                continue;
            }

            foreach (['nama_pic' => 'Nama PIC', 'jabatan' => 'Jabatan PIC'] as $field => $label) {
                if (! filled($picRow[$field] ?? null)) {
                    throw ValidationException::withMessages([
                        "pics.{$rowIndex}.{$field}" => "{$label} wajib diisi jika data PIC dilengkapi.",
                    ]);
                }
            }

            if (! filled($picRow['no_whatsapp'] ?? null)) {
                throw ValidationException::withMessages([
                    "pics.{$rowIndex}.no_whatsapp" => 'Nomor WhatsApp PIC wajib diisi.',
                ]);
            }
        }

        $data['pic_rows'] = $hasLegacyPic
            ? array_merge([$legacyPic], array_values($additionalPicRows))
            : array_values($additionalPicRows);

        foreach ($request->input('jurusans', []) as $rowIndex => $row) {
            if (! is_array($row)) {
                continue;
            }

            if (filled($row['no_telepon'] ?? null) && ! filled($row['nama'] ?? null)) {
                throw ValidationException::withMessages([
                    "jurusans.{$rowIndex}.nama" => 'Nama jurusan wajib diisi jika nomor kontak jurusan diisi.',
                ]);
            }
        }

        $data['bidang_usaha'] = $data['kategori_mitra'] === 'Lainnya'
            ? $data['kategori_mitra_lainnya']
            : $data['kategori_mitra'];

        unset(
            $data['kategori_mitra'],
            $data['kategori_mitra_lainnya'],
        );

        return $data;
    }

    /** @param array<string, mixed> $data */
    private function syncJurusans(Mitra $mitra, array $data): array
    {
        if (! in_array($data['bidang_usaha'], ['Sekolah', 'Perguruan Tinggi'], true)) {
            return [];
        }

        $submittedJurusanIds = [];
        $resolvedJurusanIds = [];

        foreach ($data['jurusans'] ?? [] as $rowIndex => $row) {
            if (! filled($row['nama'] ?? null)) {
                continue;
            }

            $jurusan = null;
            if (filled($row['id'] ?? null)) {
                $jurusan = $mitra->jurusans()->find($row['id']);
                abort_unless($jurusan, 404);
            }

            $jurusanNumber = $row['no_telepon'] ?? null;

            $attributes = [
                'nama_jurusan' => $row['nama'],
                'no_telepon' => $jurusanNumber,
                'jenis_kontak' => 'Kontak Jurusan',
            ];
            if ($jurusan) {
                $jurusan->update($attributes);
            } else {
                $jurusan = $mitra->jurusans()->create($attributes);
            }

            $submittedJurusanIds[] = $jurusan->id_jurusan;
            $resolvedJurusanIds[filled($row['id'] ?? null) ? 'id:'.$jurusan->id_jurusan : 'index:'.$rowIndex] = $jurusan->id_jurusan;

        }

        if (array_key_exists('jurusans_present', $data)) {
            $mitra->jurusans()
                ->when($submittedJurusanIds !== [], fn ($query) => $query->whereNotIn('id_jurusan', $submittedJurusanIds))
                ->when($submittedJurusanIds === [], fn ($query) => $query)
                ->get()
                ->each(function ($jurusan): void {
                    $jurusan->delete();
                });
        }

        return $resolvedJurusanIds;
    }

    /**
     * Save PIC data without replacing the mitra's initially discovered number.
     *
     * @param  array<string, mixed>  $data
     */
    private function syncPics(Mitra $mitra, array $data): void
    {
        $statusKontak = $data['status_kontak'] ?? null;
        $hasContactStatus = array_key_exists('status_kontak', $data);
        $jurusanStatus = $statusKontak === 'Tidak Dapat Dihubungi'
            ? 'Tidak Dapat Dihubungi'
            : ($statusKontak ?? 'Belum Diverifikasi');
        $resolvedJurusanIds = $data['resolved_pic_jurusan_ids'] ?? [];
        $submittedPicIds = [];
        $picRows = $data['pic_rows'] ?? [];

        foreach ($picRows as $picRow) {
            if (! is_array($picRow)) {
                continue;
            }

            $pic = filled($picRow['id'] ?? null)
                ? $mitra->pics()->find($picRow['id'])
                : null;
            abort_unless(! filled($picRow['id'] ?? null) || $pic, 404);

            $selectedKeys = collect($picRow['jurusan_keys'] ?? [])->unique()->values();
            $selectsAllJurusans = $selectedKeys->contains('__instansi__');
            $selectedDepartmentKeys = $selectedKeys
                ->reject(fn (string $key): bool => $key === '__instansi__')
                ->map(function (string $key) use ($resolvedJurusanIds): int {
                    abort_unless(isset($resolvedJurusanIds[$key]), 422);

                    return (int) $resolvedJurusanIds[$key];
                })
                ->unique()
                ->values();
            abort_unless(! $selectsAllJurusans || $selectedDepartmentKeys->isEmpty(), 422);
            $jurusanIds = $selectsAllJurusans
                ? $mitra->jurusans()->pluck('id_jurusan')->map(fn ($id): int => (int) $id)->values()
                : $selectedDepartmentKeys;
            $jurusans = $mitra->jurusans()->whereIn('id_jurusan', $jurusanIds)->get();
            abort_unless($jurusans->count() === $jurusanIds->count(), 404);

            if ($hasContactStatus) {
                foreach ($jurusans as $jurusan) {
                    $jurusan->update(['status_kontak' => $jurusanStatus]);
                }
            }

            if ($statusKontak === 'Tidak Dapat Dihubungi') {
                if ($pic) {
                    $submittedPicIds[] = $pic->id_pic;
                }

                continue;
            }

            if ($statusKontak === 'Bukan PIC') {
                if ($pic && ($jurusanIds->isNotEmpty() || $selectsAllJurusans)) {
                    $pic->jurusans()->detach($jurusanIds->all());
                    $submittedPicIds[] = $pic->id_pic;
                }

                continue;
            }

            $picNumber = $picRow['no_whatsapp'] ?? null;
            $hasPicDetails = collect(['nama_pic', 'jabatan', 'email_pic', 'no_whatsapp'])
                ->contains(fn (string $field): bool => filled($picRow[$field] ?? null));

            if (! $hasPicDetails) {
                if ($pic) {
                    $submittedPicIds[] = $pic->id_pic;
                }

                continue;
            }

            if (! $picNumber) {
                continue;
            }

            $attributes = [
                'nama_pic' => $picRow['nama_pic'],
                'jabatan' => $picRow['jabatan'],
                'email' => $picRow['email_pic'] ?? null,
                'no_whatsapp' => $picNumber,
                'status' => $pic?->status ?? 'Aktif',
            ];
            if ($pic) {
                $pic->update($attributes);
            } else {
                $pic = $mitra->pics()->create($attributes);
            }
            $submittedPicIds[] = $pic->id_pic;

            if (
                array_key_exists('jurusan_keys', $picRow)
                && in_array($data['bidang_usaha'], ['Sekolah', 'Perguruan Tinggi'], true)
            ) {
                $pic->jurusans()->sync($jurusanIds->mapWithKeys(fn (int $id): array => [
                    $id => $hasContactStatus ? ['status_kontak' => $jurusanStatus] : [],
                ])->all());
            }
        }

        if (array_key_exists('pics_present', $data)) {
            $mitra->pics()
                ->when($submittedPicIds !== [], fn ($query) => $query->whereNotIn('id_pic', $submittedPicIds))
                ->when($submittedPicIds === [], fn ($query) => $query)
                ->get()
                ->each(fn ($pic) => $pic->delete());
        }
    }
}
