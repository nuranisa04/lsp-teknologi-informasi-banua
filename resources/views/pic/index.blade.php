@extends('layouts.app')

@section('title', 'Data PIC')

@section('breadcrumb', 'Data PIC')


@section('content')

<div class="d-flex justify-content-between mb-4">

    <div>

        <h2 class="page-title">
            Data PIC Perusahaan
        </h2>

        <p class="text-muted">
            Data PIC perusahaan.
        </p>

    </div>


    @if(auth()->user()->isAdmin())

        <a
            href="{{ route('pic.create') }}"
            class="btn btn-lsp"
        >

            + Tambah PIC

        </a>

    @endif

</div>


<div class="card mb-4">

    <div class="card-body">

        <form
            method="GET"
            class="d-flex gap-2"
        >

            <input
                type="text"
                name="search"
                class="form-control"
                value="{{ request('search') }}"
                placeholder="Cari PIC atau perusahaan..."
            >

            <button class="btn btn-lsp">
                Cari
            </button>

        </form>

    </div>

</div>


<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama PIC</th>
                        <th>Perusahaan</th>
                        <th>Jabatan</th>
                        <th>WhatsApp</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse(
                        $pics as $i => $pic
                    )

                        <tr>

                            <td>
                                {{
                                    $pics->firstItem()
                                    + $i
                                }}
                            </td>

                            <td>
                                {{ $pic->nama_pic }}
                            </td>

                            <td>
                                {{
                                    $pic->perusahaan
                                        ->nama_perusahaan
                                }}
                            </td>

                            <td>
                                {{ $pic->jabatan }}
                            </td>

                            <td>
                                {{ $pic->no_whatsapp }}
                            </td>

                            <td>

                                <span class="badge bg-success">

                                    {{ $pic->status }}

                                </span>

                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'pic.show',
                                        $pic
                                    ) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >

                                    Lihat

                                </a>


                                @if(auth()->user()->isAdmin())

                                    <a
                                        href="{{ route(
                                            'pic.edit',
                                            $pic
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning"
                                    >

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route(
                                            'pic.destroy',
                                            $pic
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm(
                                                'Hapus PIC?'
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
                                colspan="7"
                                class="text-center"
                            >

                                Belum ada data PIC.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{ $pics->links() }}

    </div>

</div>

@endsection