@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb', 'Dashboard')


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Dashboard
        </h2>

        <p class="text-muted">
            Sistem Informasi Pengelolaan Kerja Sama Mitra
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


<div class="row g-3 mb-4">


    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <div class="text-muted">
                    Total Perusahaan
                </div>

                <h2 class="fw-bold">
                    {{ $totalPerusahaan }}
                </h2>

            </div>

        </div>

    </div>


    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <div class="text-muted">
                    Calon Mitra
                </div>

                <h2 class="fw-bold">
                    {{ $totalCalon }}
                </h2>

            </div>

        </div>

    </div>


    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <div class="text-muted">
                    Kontak Terverifikasi
                </div>

                <h2 class="fw-bold">
                    {{ $totalTerverifikasi }}
                </h2>

            </div>

        </div>

    </div>


    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <div class="text-muted">
                    Total PIC
                </div>

                <h2 class="fw-bold">
                    {{ $totalPic }}
                </h2>

            </div>

        </div>

    </div>

</div>


<div class="card">

    <div class="card-body">

        <h5
            class="fw-bold mb-4"
            style="color:#123B5D;"
        >
            Data Perusahaan Terbaru
        </h5>


        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>
                            Perusahaan
                        </th>

                        <th>
                            Bidang Usaha
                        </th>

                        <th>
                            Nomor Kontak
                        </th>

                        <th>
                            Status Kontak
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse(
                        $perusahaanTerbaru
                        as $item
                    )

                        <tr>

                            <td>
                                {{ $item->nama_perusahaan }}
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

                                <a
                                    href="{{ route(
                                        'perusahaan.show',
                                        $item
                                    ) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted"
                            >

                                Belum ada data.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection