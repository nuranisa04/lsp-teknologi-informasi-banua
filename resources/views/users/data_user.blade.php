@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('breadcrumb', 'Pengguna')


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Data Pengguna
        </h2>


    </div>


    @if(auth()->user()->isAdmin())

        <a
            href="{{ route('users.create') }}"
            class="btn btn-lsp"
        >

            <i class="bi bi-plus-lg me-1"></i>

            Tambah Data Pengguna

        </a>

    @endif

</div>


<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle text-center">

                <thead>

                    <tr>

                        <th>
                            Nama
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            WhatsApp
                        </th>

                        <th>
                            Status
                        </th>

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td>

                                <div class="fw-semibold">
                                    {{ $user->nama }}
                                </div>

                            </td>


                            <td>

                                {{ $user->email }}

                            </td>


                            <td>

                                <span
                                    class="badge"
                                    style="
                                        background:#EEF3F7;
                                        color:var(--navy);
                                    "
                                >

                                    {{
                                        $user->role?->nama_role
                                        ?? '-'
                                    }}

                                </span>

                            </td>


                            <td>

                                {{
                                    $user->no_whatsapp
                                    ?: '-'
                                }}

                            </td>


                            <td>

                                @if(
                                    $user->status === 'aktif'
                                )

                                    <span
                                        class="badge bg-success"
                                    >
                                        Aktif
                                    </span>

                                @else

                                    <span
                                        class="badge bg-secondary"
                                    >
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if(auth()->user()->isAdmin())

                                    <a
                                        href="{{ route(
                                            'users.edit',
                                            $user
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit Pengguna"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    @if(
                                        $user->id_user
                                        !== auth()->id()
                                    )

                                        <a
                                            href="{{ route(
                                                'users.delete.confirm',
                                                $user
                                            ) }}"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Hapus Pengguna"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </a>

                                    @endif

                                @else

                                    <span class="text-muted">
                                        Hanya dapat melihat
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-people fs-1 text-muted"
                                ></i>

                                <div class="mt-2">
                                    Belum ada pengguna.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="mt-3">

            {{ $users->links() }}

        </div>

    </div>

</div>

@endsection