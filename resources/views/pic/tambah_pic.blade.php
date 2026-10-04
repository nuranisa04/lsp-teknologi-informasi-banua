@extends('layouts.app')

@section('title', 'Tambah PIC')

@section(
    'breadcrumb',
    'Data PIC / Tambah'
)


@section('content')

<h2 class="page-title mb-4">
    Tambah Data PIC
</h2>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route('pic.store') }}"
            method="POST"
        >

            @csrf

            @include('pic.form')


            <div class="text-end mt-4">

                <button class="btn btn-lsp">

                    Simpan PIC

                </button>

            </div>

        </form>

    </div>

</div>

@endsection