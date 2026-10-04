@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section(
    'breadcrumb',
    'Pengguna / Tambah'
)


@section('content')

<h2 class="page-title mb-4">
    Tambah Pengguna
</h2>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route('users.store') }}"
            method="POST"
        >

            @csrf

            @include('users.form')


            <div class="text-end mt-4">

                <button class="btn btn-lsp">

                    Simpan Pengguna

                </button>

            </div>

        </form>

    </div>

</div>

@endsection