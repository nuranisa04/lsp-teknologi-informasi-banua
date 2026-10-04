@extends('layouts.app')

@section('title', 'Pengguna')

@section('breadcrumb', 'Pengguna')


@section('content')

<div class="d-flex justify-content-between mb-4">

    <div>

        <h2 class="page-title">
            Data Pengguna
        </h2>

        <p class="text-muted">
            Kelola akun Admin LSP dan Pimpinan.
        </p>

    </div>


    <a
        href="{{ route('users.create') }}"
        class="btn btn-lsp"
    >

        + Tambah Pengguna

    </a>

</div>


<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse(
                        $users as $i => $user
                    )

                        <tr>

                            <td>
                                {{
                                    $users->firstItem()
                                    + $i
                                }}
                            </td>

                            <td>
                                {{ $user->nama }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ $user->role->nama_role }}
                            </td>

                            <td>
                                {{ $user->status }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'users.edit',
                                        $user
                                    ) }}"
                                    class="btn btn-sm btn-warning"
                                >

                                    Edit

                                </a>


                                @if(
                                    $user->id_user
                                    !== auth()->id()
                                )

                                    <form
                                        action="{{ route(
                                            'users.destroy',
                                            $user
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm(
                                                'Hapus pengguna?'
                                            )"
                                        >

                                            Hapus

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center"
                            >

                                Belum ada pengguna.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{ $users->links() }}

    </div>

</div>

@endsection