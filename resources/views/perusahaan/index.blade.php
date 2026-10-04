@extends('layouts.app')

@section('title', 'Data Perusahaan')

@section('breadcrumb', 'Data Perusahaan')


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Data Perusahaan
        </h2>

        <p class="text-muted">
            Data perusahaan calon mitra LSP.
        </p>

    </div>


    @if(auth()->user()->isAdmin())

        <a
            href="{{ route('perusahaan.create') }}"
            class="btn btn-lsp"
        >

            <i class="bi bi-plus-lg"></i>

            Tambah Perusahaan

        </a>

    @endif

</div>


<div class="card mb-4">

    <div class="card-body">

        <form
            method="GET"
            class="row g-2"
        >

            <div class="col-md-6">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Cari perusahaan..."
                >

            </div>


            <div class="col-md-3">

                <select
                    name="status"
                    class="form-select"
                >

                    <option value="">
                        Semua Status
                    </option>

                    @foreach([
                        'Calon',
                        'Aktif',
                        'Tidak Aktif'
                    ] as $item)

                        <option
                            value="{{ $item }}"
                            @selected(
                                request('status')
                                === $item
                            )
                        >

                            {{ $item }}

                        </option>

                    @endforeach

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

                    @foreach([
                        'Belum Diverifikasi',
                        'Terverifikasi PIC',
                        'Bukan PIC',
                        'Tidak Dapat Dihubungi'
                    ] as $item)

                        <option
                            value="{{ $item }}"
                            @selected(
                                request('status_kontak')
                                === $item
                            )
                        >

                            {{ $item }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-1">

                <button class="btn btn-lsp w-100">

                    <i class="bi bi-search"></i>

                </button>

            </div>

        </form>

    </div>

</div>


<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Perusahaan</th>

                        <th>Bidang Usaha</th>

                        <th>Nomor Kontak</th>

                        <th>Status Kontak</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse(
                        $perusahaan as $i => $item
                    )

                        <tr>

                            <td>
                                {{
                                    $perusahaan->firstItem()
                                    + $i
                                }}
                            </td>

                            <td>

                                <strong>
                                    {{ $item->nama_perusahaan }}
                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{
                                        $item->email
                                        ?: '-'
                                    }}

                                </small>

                            </td>

                            <td>
                                {{ $item->bidang_usaha }}
                            </td>

                            <td>
                                {{
                                    $item->no_telepon
                                    ?: '-'
                                }}
                            </td>

                            <td>

                                <span class="badge bg-warning text-dark">

                                    {{ $item->status_kontak }}

                                </span>

                            </td>

                            <td>

                                <span
                                    class="badge
                                    {{
                                        $item->status === 'Aktif'
                                            ? 'bg-success'
                                            : (
                                                $item->status === 'Calon'
                                                    ? 'bg-warning text-dark'
                                                    : 'bg-secondary'
                                            )
                                    }}"
                                >

                                    {{ $item->status }}

                                </span>

                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'perusahaan.show',
                                        $item
                                    ) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >

                                    <i class="bi bi-eye"></i>

                                </a>


                                @if(auth()->user()->isAdmin())

                                    <a
                                        href="{{ route(
                                            'perusahaan.edit',
                                            $item
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <form
                                        action="{{ route(
                                            'perusahaan.destroy',
                                            $item
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm(
                                                'Hapus data ini?'
                                            )"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                Belum ada data perusahaan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{ $perusahaan->links() }}

    </div>

</div>

@endsection