@extends('layouts.app')

@section('title', 'Edit PIC')

@section(
    'breadcrumb',
    'Data PIC / Edit'
)


@section('content')

<h2 class="page-title mb-4">
    Edit Data PIC
</h2>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route(
                'pic.update',
                $pic
            ) }}"
            method="POST"
        >

            @csrf

            @method('PUT')

            @include('pic.form')


            <div class="text-end mt-4">

                <button class="btn btn-lsp">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection