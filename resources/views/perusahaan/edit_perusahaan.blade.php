@extends('layouts.app')

@section('title', 'Edit Perusahaan')

@section(
    'breadcrumb',
    'Data Perusahaan / Edit'
)


@section('content')

<h2 class="page-title mb-4">
    Edit Data Perusahaan
</h2>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route(
                'perusahaan.update',
                $perusahaan
            ) }}"
            method="POST"
        >

            @csrf

            @method('PUT')

            @include('perusahaan.form')


            <div class="mt-4 text-end">

                <button class="btn btn-lsp">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection