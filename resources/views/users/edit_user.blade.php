@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section(
    'breadcrumb',
    'Pengguna / Edit'
)


@section('content')

<h2 class="page-title mb-4">
    Edit Pengguna
</h2>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route(
                'users.update',
                $user
            ) }}"
            method="POST"
        >

            @csrf

            @method('PUT')

            @include('users.form')


            <div class="text-end mt-4">

                <button class="btn btn-lsp">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection