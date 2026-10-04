@extends('layouts.app')

@section('title', 'Tambah Perusahaan')

@section(
    'breadcrumb',
    'Data Perusahaan / Tambah'
)


@section('content')

<div class="d-flex justify-content-between mb-4">

    <div>

        <h2 class="page-title">
            Tambah Data Perusahaan
        </h2>

        <p class="text-muted">
            Tambahkan perusahaan sebagai calon mitra.
        </p>

    </div>

    <a
        href="{{ route('perusahaan.index') }}"
        class="btn btn-outline-secondary"
    >

        Kembali

    </a>

</div>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route('perusahaan.store') }}"
            method="POST"
        >

            @csrf

            @include('perusahaan.form')


            <div class="mt-4 text-end">

                <button class="btn btn-lsp">

                    <i class="bi bi-save"></i>

                    Simpan Data

                </button>

            </div>

        </form>

    </div>

</div>

@endsection