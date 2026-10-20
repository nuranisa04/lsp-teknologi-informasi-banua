@extends('layouts.app')

@section('title', 'Data Mitra')

@section('breadcrumb', 'Data Mitra')


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">

    <div>

        <h2 class="page-title">
            Data Mitra
        </h2>

    </div>


    <div class="d-flex align-items-center gap-2 flex-wrap">

        <button
            type="button"
            class="btn btn-lsp"
            data-bs-toggle="modal"
            data-bs-target="#exportMitraModal"
        >
            <i class="bi bi-file-earmark-spreadsheet me-1"></i>
            Ekspor Data Mitra
        </button>

        @if(auth()->user()->isAdmin())

            <a
                href="{{ route('mitra.create') }}"
                class="btn btn-lsp"
            >

                <i class="bi bi-plus-lg me-1"></i>

                Tambah Data Mitra

            </a>

        @endif

    </div>

</div>

<div
    class="modal fade"
    id="exportMitraModal"
    tabindex="-1"
    aria-labelledby="exportMitraModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('mitra.export') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportMitraModalLabel">
                        Filter Data Mitra untuk Diunduh
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small">
                        Filter bisa digabungkan. Kosongkan semua filter untuk mengunduh seluruh data mitra.
                        File CSV UTF-8 ini dapat dibuka di Excel.
                    </p>

                    <div class="mb-3">
                        <label for="export-mitra-status" class="form-label">
                            Status Mitra
                        </label>
                        <select
                            name="status"
                            id="export-mitra-status"
                            class="form-select"
                        >
                            <option value="">Semua Status Mitra</option>
                            @foreach (['Calon', 'Aktif', 'Tidak Aktif'] as $status)
                                <option
                                    value="{{ $status }}"
                                    @selected(request('status') === $status)
                                >{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="export-mitra-status-kontak" class="form-label">
                            Status Kontak
                        </label>
                        <select
                            name="status_kontak"
                            id="export-mitra-status-kontak"
                            class="form-select"
                        >
                            <option value="">Semua Status Kontak</option>
                            @foreach ([
                                'Belum Diverifikasi',
                                'Kontak Mitra',
                                'Terverifikasi PIC',
                                'Bukan PIC',
                                'Tidak Dapat Dihubungi',
                            ] as $statusKontak)
                                <option
                                    value="{{ $statusKontak }}"
                                    @selected(request('status_kontak') === $statusKontak)
                                >{{ $statusKontak }}</option>
                            @endforeach
                            <option
                                value="__kosong__"
                                @selected(request('status_kontak') === '__kosong__')
                            >Belum Diisi</option>
                        </select>
                    </div>

                    <div>
                        <label for="export-mitra-kategori" class="form-label">
                            Kategori Mitra
                        </label>
                        <select
                            name="bidang_usaha"
                            id="export-mitra-kategori"
                            class="form-select"
                        >
                            <option value="">Semua Kategori Mitra</option>
                            @foreach ($kategoriMitra as $kategori)
                                <option
                                    value="{{ $kategori }}"
                                    @selected(request('bidang_usaha') === $kategori)
                                >{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn btn-lsp">
                        <i class="bi bi-download me-1"></i>
                        Unduh Data Mitra
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- FILTER --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('mitra.index') }}"
            method="GET"
            id="filter-mitra-form"
            class="row g-2"
        >

            <div class="col-md-6">

                <input
                    type="text"
                    name="search"
                    id="mitra-search"
                    class="form-control"
                    placeholder="Cari nama mitra, kategori mitra, nomor kontak..."
                    value="{{ request('search') }}"
                >

            </div>


            <div class="col-md-3">

                <select
                    name="status"
                    class="form-select"
                >

                    <option value="">
                        Semua Status Mitra
                    </option>

                    <option
                        value="Calon"
                        @selected(
                            request('status') === 'Calon'
                        )
                    >
                        Calon
                    </option>

                    <option
                        value="Aktif"
                        @selected(
                            request('status') === 'Aktif'
                        )
                    >
                        Aktif
                    </option>

                    <option
                        value="Tidak Aktif"
                        @selected(
                            request('status') === 'Tidak Aktif'
                        )
                    >
                        Tidak Aktif
                    </option>

                </select>

            </div>


            <div class="col-md-2">

                <select
                    name="status_kontak"
                    class="form-select"
                >

                    <option value="">
                        Semua Kontak
                    </option>

                    <option
                        value="Belum Diverifikasi"
                        @selected(
                            request('status_kontak')
                            === 'Belum Diverifikasi'
                        )
                    >
                        Belum Diverifikasi
                    </option>

                    <option
                        value="Kontak Mitra"
                        @selected(
                            request('status_kontak')
                            === 'Kontak Mitra'
                        )
                    >
                        Kontak Mitra
                    </option>

                    <option
                        value="Terverifikasi PIC"
                        @selected(
                            request('status_kontak')
                            === 'Terverifikasi PIC'
                        )
                    >
                        Terverifikasi PIC
                    </option>

                    <option
                        value="Bukan PIC"
                        @selected(
                            request('status_kontak')
                            === 'Bukan PIC'
                        )
                    >
                        Bukan PIC
                    </option>

                    <option
                        value="Tidak Dapat Dihubungi"
                        @selected(
                            request('status_kontak')
                            === 'Tidak Dapat Dihubungi'
                        )
                    >
                        Tidak Dapat Dihubungi
                    </option>

                </select>

            </div>


            <div class="col-md-1">

                <button
                    type="submit"
                    class="btn btn-lsp w-100"
                >

                    <i class="bi bi-search"></i>

                </button>

            </div>

        </form>

    </div>

</div>



{{-- TABEL DATA --}}

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th class="text-center">
                            Mitra
                        </th>

                        <th class="text-center">
                            Email
                        </th>

                        <th class="text-center">
                            Nomor Kontak
                        </th>

                        <th class="text-center">
                            Status Kontak
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        @if(auth()->user()->isPimpinan())
                            <th class="text-center">
                                Diinput Oleh
                            </th>
                        @endif

                        <th
                            width="{{ auth()->user()->isAdmin() ? 190 : 80 }}"
                            class="text-center"
                        >
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody id="mitra-table-body">

                    @forelse($mitra as $item)

                        <tr data-mitra-row>

                            <td class="text-center">

                                <div class="fw-semibold">

                                    {{ $item->nama_mitra }}

                                </div>

                            </td>


                            <td class="text-center">

                                {{ $item->email ?: '-' }}

                            </td>


                            <td class="text-center">

                                {{
                                    $item->no_telepon
                                    ?: '-'
                                }}

                            </td>


                            {{-- STATUS KONTAK --}}

                            <td class="text-center">

                                @if(
                                    $item->status_kontak
                                    === 'Terverifikasi PIC'
                                )

                                    <span
                                        class="badge bg-success"
                                    >
                                        Terverifikasi PIC
                                    </span>

                                @elseif(
                                    $item->status_kontak
                                    === 'Kontak Mitra'
                                )

                                    <span class="badge bg-info text-dark">
                                        Kontak Mitra
                                    </span>

                                @elseif(
                                    $item->status_kontak
                                    === 'Bukan PIC'
                                )

                                    <span
                                        class="badge bg-danger"
                                    >
                                        Bukan PIC
                                    </span>

                                @elseif(
                                    $item->status_kontak
                                    === 'Tidak Dapat Dihubungi'
                                )

                                    <span
                                        class="badge bg-secondary"
                                    >
                                        Tidak Dapat Dihubungi
                                    </span>

                                @else

                                    <span
                                        class="badge bg-warning text-dark"
                                    >
                                        Belum Diverifikasi
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS MITRA --}}

                            <td class="text-center">

                                @if(
                                    $item->status === 'Aktif'
                                )

                                    <span
                                        class="badge bg-success"
                                    >
                                        Aktif
                                    </span>

                                @elseif(
                                    $item->status === 'Tidak Aktif'
                                )

                                    <span
                                        class="badge bg-secondary"
                                    >
                                        Tidak Aktif
                                    </span>

                                @else

                                    <span
                                        class="badge bg-warning text-dark"
                                    >
                                        Calon
                                    </span>

                                @endif

                            </td>


                            @if(auth()->user()->isPimpinan())
                                <td class="text-center">
                                    {{ $item->user?->nama ?? 'Tidak tercatat' }}
                                </td>
                            @endif


                            <td class="text-center">

                                <a
                                    href="{{ route(
                                        'mitra.show',
                                        $item
                                    ) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Lihat detail"
                                    aria-label="Lihat detail {{ $item->nama_mitra }}"
                                >

                                    <i class="bi bi-eye"></i>

                                </a>

                                @if(auth()->user()->isAdmin())
                                    <a
                                        href="{{ route(
                                            'mitra.edit',
                                            $item
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <a
                                        href="{{ route(
                                            'mitra.delete.confirm',
                                            $item
                                        ) }}"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Hapus"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </a>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->isAdmin() ? 6 : 7 }}"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-building fs-1 text-muted"
                                ></i>

                                <div class="mt-2">
                                    Belum ada data mitra.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="mt-3" id="mitra-pagination">

            {{ $mitra->links() }}

        </div>

    </div>

</div>

<div
    id="mitra-search-error"
    class="alert alert-danger mt-3"
    role="alert"
    hidden
></div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filter-mitra-form');
            const searchInput = document.getElementById('mitra-search');
            const tableBody = document.getElementById('mitra-table-body');
            const pagination = document.getElementById('mitra-pagination');
            const errorMessage = document.getElementById('mitra-search-error');
            let debounceTimer;
            let activeRequest;

            function filterVisibleRows() {
                const searchTerm = searchInput.value.trim().toLocaleLowerCase();
                const rows = tableBody.querySelectorAll('[data-mitra-row]');
                let visibleRows = 0;

                tableBody.querySelector('[data-mitra-live-empty]')?.remove();

                rows.forEach(function (row) {
                    const matches = row.textContent
                        .toLocaleLowerCase()
                        .includes(searchTerm);

                    row.hidden = !matches;

                    if (matches) {
                        visibleRows += 1;
                    }
                });

                if (rows.length > 0 && visibleRows === 0) {
                    const emptyRow = document.createElement('tr');
                    const emptyCell = document.createElement('td');

                    emptyRow.dataset.mitraLiveEmpty = '';
                    emptyCell.colSpan = 6;
                    emptyCell.className = 'text-center py-5';
                    emptyCell.textContent = 'Tidak ada data mitra yang cocok.';
                    emptyRow.append(emptyCell);
                    tableBody.append(emptyRow);
                }
            }

            async function updateMitraResults() {
                activeRequest?.abort();
                activeRequest = new AbortController();

                const query = new URLSearchParams(new FormData(form));
                const url = new URL(form.action, window.location.origin);
                url.search = query.toString();

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        signal: activeRequest.signal,
                    });

                    if (!response.ok) {
                        throw new Error('Pencarian data mitra gagal. Silakan coba lagi.');
                    }

                    const html = await response.text();
                    const documentResult = new DOMParser().parseFromString(html, 'text/html');
                    const newTableBody = documentResult.getElementById('mitra-table-body');
                    const newPagination = documentResult.getElementById('mitra-pagination');

                    if (!newTableBody || !newPagination) {
                        throw new Error('Hasil pencarian data mitra tidak dapat ditampilkan.');
                    }

                    tableBody.replaceChildren(...newTableBody.childNodes);
                    pagination.replaceChildren(...newPagination.childNodes);
                    filterVisibleRows();
                    window.history.replaceState({}, '', url);
                    errorMessage.hidden = true;
                    errorMessage.textContent = '';
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    errorMessage.textContent = error.message;
                    errorMessage.hidden = false;
                }
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                updateMitraResults();
            });

            searchInput.addEventListener('input', function () {
                window.clearTimeout(debounceTimer);
                filterVisibleRows();
                debounceTimer = window.setTimeout(updateMitraResults, 150);
            });
        });
    </script>
@endpush