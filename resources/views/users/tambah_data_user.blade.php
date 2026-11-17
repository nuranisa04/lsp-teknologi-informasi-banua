@extends('layouts.app')

@section('title', 'Tambah Data Pengguna')

@section(
    'breadcrumb',
    'Pengguna / Tambah'
)


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Tambah Data Pengguna
        </h2>

    </div>


    <a
        href="{{ route('users.index') }}"
        class="btn btn-back"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>



<div class="card">

    <div class="card-body p-4">


        <form
            action="{{ route('users.store') }}"
            method="POST"
        >

            @csrf


            <div class="row g-3">


                {{-- NAMA --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Nama

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        required
                    >

                </div>


                {{-- EMAIL --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Email

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                    >

                </div>


                {{-- ROLE --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Role

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <select
                        name="id_role"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Role --
                        </option>


                        @foreach($roles as $role)

                            <option
                                value="{{ $role->id_role }}"
                                @selected(
                                    old('id_role')
                                    == $role->id_role
                                )
                            >

                                {{ $role->nama_role }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- WHATSAPP --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Nomor WhatsApp

                    </label>

                    <input
                        type="text"
                        name="no_whatsapp"
                        class="form-control"
                        value="{{ old('no_whatsapp') }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="30"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    >

                </div>


                {{-- PASSWORD --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Password

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        required
                    >

                </div>


                {{-- STATUS --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Status

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option
                            value="aktif"
                            @selected(
                                old(
                                    'status',
                                    'aktif'
                                ) === 'aktif'
                            )
                        >
                            Aktif
                        </option>

                        <option
                            value="tidak aktif"
                            @selected(
                                old('status')
                                === 'tidak aktif'
                            )
                        >
                            Tidak Aktif
                        </option>

                    </select>

                </div>


            </div>


            <div
                class="d-flex justify-content-end gap-2 mt-4"
            >

                <a
                    href="{{ route('users.index') }}"
                    class="btn btn-back"
                >

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-lsp btn-save"
                >

                    <i class="bi bi-check2-circle" aria-hidden="true"></i>

                    Simpan Data Pengguna

                </button>

            </div>


        </form>

    </div>

</div>

@endsection