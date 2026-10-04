@extends('layouts.app')

@section('title', 'Detail Perusahaan')

@section(
    'breadcrumb',
    'Data Perusahaan / Detail'
)


@section('content')

<div class="d-flex justify-content-between mb-4">

    <h2 class="page-title">

        {{ $perusahaan->nama_perusahaan }}

    </h2>


    <div>

        <a
            href="{{ route('perusahaan.index') }}"
            class="btn btn-outline-secondary"
        >

            Kembali

        </a>


        @if(auth()->user()->isAdmin())

            <a
                href="{{ route(
                    'perusahaan.edit',
                    $perusahaan
                ) }}"
                class="btn btn-lsp"
            >

                Edit

            </a>

        @endif

    </div>

</div>


<div class="row g-4">


    <div class="col-lg-7">

        <div class="card">

            <div class="card-body p-4">

                <h5
                    class="fw-bold mb-4"
                    style="color:#123B5D;"
                >

                    Informasi Perusahaan

                </h5>


                <dl class="row">

                    <dt class="col-sm-4">
                        Nama
                    </dt>

                    <dd class="col-sm-8">
                        {{ $perusahaan->nama_perusahaan }}
                    </dd>


                    <dt class="col-sm-4">
                        Bidang Usaha
                    </dt>

                    <dd class="col-sm-8">
                        {{ $perusahaan->bidang_usaha }}
                    </dd>


                    <dt class="col-sm-4">
                        Alamat
                    </dt>

                    <dd class="col-sm-8">
                        {{ $perusahaan->alamat }}
                    </dd>


                    <dt class="col-sm-4">
                        Website
                    </dt>

                    <dd class="col-sm-8">

                        @if($perusahaan->website)

                            <a
                                href="{{ $perusahaan->website }}"
                                target="_blank"
                            >

                                {{ $perusahaan->website }}

                            </a>

                        @else

                            -

                        @endif

                    </dd>


                    <dt class="col-sm-4">
                        Email
                    </dt>

                    <dd class="col-sm-8">
                        {{
                            $perusahaan->email
                            ?: '-'
                        }}
                    </dd>


                    <dt class="col-sm-4">
                        Nomor Kontak
                    </dt>

                    <dd class="col-sm-8">
                        {{
                            $perusahaan->no_telepon
                            ?: '-'
                        }}
                    </dd>


                    <dt class="col-sm-4">
                        Sumber Data
                    </dt>

                    <dd class="col-sm-8">
                        {{
                            $perusahaan->sumber_data
                            ?: '-'
                        }}
                    </dd>


                    <dt class="col-sm-4">
                        Status Kontak
                    </dt>

                    <dd class="col-sm-8">

                        <span class="badge bg-warning text-dark">

                            {{ $perusahaan->status_kontak }}

                        </span>

                    </dd>


                    <dt class="col-sm-4">
                        Status Perusahaan
                    </dt>

                    <dd class="col-sm-8">

                        <span class="badge bg-secondary">

                            {{ $perusahaan->status }}

                        </span>

                    </dd>

                </dl>

            </div>

        </div>

    </div>


    <div class="col-lg-5">

        <div class="card">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between mb-3">

                    <h5
                        class="fw-bold"
                        style="color:#123B5D;"
                    >

                        PIC Perusahaan

                    </h5>


                    @if(auth()->user()->isAdmin())

                        <a
                            href="{{ route(
                                'pic.create',
                                [
                                    'id_perusahaan'
                                    =>
                                    $perusahaan
                                        ->id_perusahaan
                                ]
                            ) }}"
                            class="btn btn-sm btn-lsp"
                        >

                            +

                        </a>

                    @endif

                </div>


                @forelse(
                    $perusahaan->pics as $pic
                )

                    <div class="border rounded p-3 mb-3">

                        <strong>
                            {{ $pic->nama_pic }}
                        </strong>

                        <br>

                        <span class="text-muted">
                            {{ $pic->jabatan }}
                        </span>

                        <hr>

                        <div>
                            WhatsApp:
                            {{ $pic->no_whatsapp }}
                        </div>

                        <div>
                            Email:
                            {{
                                $pic->email
                                ?: '-'
                            }}
                        </div>


                        <a
                            href="{{ route(
                                'pic.show',
                                $pic
                            ) }}"
                            class="btn btn-sm btn-link px-0"
                        >

                            Detail PIC

                        </a>

                    </div>

                @empty

                    <p class="text-muted">
                        Belum ada PIC.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection