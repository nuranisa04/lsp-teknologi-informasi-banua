@extends('layouts.app')

@section('title', 'Detail PIC')

@section(
    'breadcrumb',
    'Data PIC / Detail'
)


@section('content')

<div class="card">

    <div class="card-body p-4">

        <h2
            class="page-title mb-4"
        >

            {{ $pic->nama_pic }}

        </h2>


        <dl class="row">

            <dt class="col-md-3">
                Nama PIC
            </dt>

            <dd class="col-md-9">
                {{ $pic->nama_pic }}
            </dd>


            <dt class="col-md-3">
                Perusahaan
            </dt>

            <dd class="col-md-9">

                {{
                    $pic->perusahaan
                        ->nama_perusahaan
                }}

            </dd>


            <dt class="col-md-3">
                Jabatan
            </dt>

            <dd class="col-md-9">
                {{ $pic->jabatan }}
            </dd>


            <dt class="col-md-3">
                Email
            </dt>

            <dd class="col-md-9">
                {{
                    $pic->email
                    ?: '-'
                }}
            </dd>


            <dt class="col-md-3">
                WhatsApp
            </dt>

            <dd class="col-md-9">
                {{ $pic->no_whatsapp }}
            </dd>


            <dt class="col-md-3">
                Status
            </dt>

            <dd class="col-md-9">

                <span class="badge bg-success">

                    {{ $pic->status }}

                </span>

            </dd>

        </dl>


        <a
            href="{{ route('pic.index') }}"
            class="btn btn-secondary"
        >

            Kembali

        </a>


        @if(auth()->user()->isAdmin())

            <a
                href="{{ route(
                    'pic.edit',
                    $pic
                ) }}"
                class="btn btn-lsp"
            >

                Edit

            </a>

        @endif

    </div>

</div>

@endsection