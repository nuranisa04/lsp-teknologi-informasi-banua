@extends('layouts.app')

@section('title', 'Data PIC')

@section('breadcrumb', 'Data PIC')


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Data PIC Mitra
        </h2>

    </div>


    @if(auth()->user()->isAdmin())

        <a
            href="{{ route('pic.create') }}"
            class="btn btn-lsp"
        >

            <i class="bi bi-plus-lg me-1"></i>

            Tambah Data PIC

        </a>

    @endif

</div>


{{-- PENCARIAN --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('pic.index') }}"
            method="GET"
            class="row g-2"
        >

            <div class="col-md-10">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Cari nama PIC, mitra, jabatan, atau nomor WhatsApp..."
                >

            </div>


            <div class="col-md-2">

                <button
                    type="submit"
                    class="btn btn-lsp w-100"
                >

                    <i class="bi bi-search me-1"></i>

                    Cari

                </button>

            </div>

        </form>

    </div>

</div>


{{-- TABEL DATA PIC --}}

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle text-center">

                <thead>

                    <tr>

                        <th>
                            Nama PIC
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Mitra
                        </th>

                        <th>
                            Jabatan
                        </th>

                        <th>
                            WhatsApp
                        </th>

                        <th>
                            Status
                        </th>

                        @if(auth()->user()->isAdmin())
                            <th width="180">
                                Aksi
                            </th>
                        @endif

                    </tr>

                </thead>


                <tbody>

                    @forelse($pics as $pic)

                        <tr>

                            <td>

                                <div class="fw-semibold">

                                    {{ $pic->nama_pic }}

                                </div>

                            </td>

                            <td>
                                {{ $pic->email ?: '-' }}
                            </td>

                            <td>

                                {{
                                    $pic->mitra
                                        ->nama_mitra
                                }}

                            </td>

                            <td>

                                {{ $pic->jabatan }}

                            </td>

                            <td>
                                {{ $pic->no_whatsapp ?: '-' }}
                            </td>


                            <td>

                                @if(
                                    $pic->status === 'Aktif'
                                )

                                    <span
                                        class="badge bg-success"
                                    >
                                        Aktif
                                    </span>

                                @else

                                    <span
                                        class="badge bg-secondary"
                                    >
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            @if(auth()->user()->isAdmin())
                                <td>
                                    <a
                                        href="{{ route(
                                            'pic.edit',
                                            $pic
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit PIC"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <a
                                        href="{{ route(
                                            'pic.delete.confirm',
                                            $pic
                                        ) }}"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Hapus PIC"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </a>
                                </td>
                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-person-badge fs-1 text-muted"
                                ></i>

                                <div class="mt-2">

                                    Belum ada data PIC.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="mt-3">

            {{ $pics->links() }}

        </div>

    </div>

</div>

@endsection