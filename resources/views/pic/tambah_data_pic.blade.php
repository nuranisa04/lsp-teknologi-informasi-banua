@extends('layouts.app')

@section('title', 'Tambah Data PIC')

@section(
    'breadcrumb',
    'Data PIC / Tambah'
)


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Tambah Data PIC
        </h2>

    </div>


    <a
        href="{{ route('pic.index') }}"
        class="btn btn-back"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


<div class="card">

    <div class="card-body p-4">

        <form
            action="{{ route('pic.store') }}"
            method="POST"
        >

            @csrf


            <div class="row g-3">


                {{-- MITRA --}}

                <div class="col-12">

                    <label class="form-label fw-semibold">

                        Mitra

                        <span class="text-danger">
                            *
                        </span>

                    </label>


                    <select
                        name="id_mitra"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Mitra --
                        </option>


                        @foreach(
                            $mitra as $item
                        )

                            <option
                                value="{{ $item->id_mitra }}"
                                @selected(
                                    old(
                                        'id_mitra',
                                        request(
                                            'id_mitra'
                                        )
                                    )
                                    == $item->id_mitra
                                )
                            >

                                {{
                                    $item->nama_mitra
                                }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- NAMA PIC --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Nama PIC

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="text"
                        name="nama_pic"
                        class="form-control"
                        value="{{ old('nama_pic') }}"
                        required
                    >

                </div>


                {{-- JABATAN --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Jabatan

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="text"
                        name="jabatan"
                        class="form-control"
                        value="{{ old('jabatan') }}"
                        required
                    >

                </div>


                {{-- EMAIL --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        maxlength="255"
                    >

                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                {{-- NOMOR WHATSAPP --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Nomor WhatsApp

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="text"
                        name="no_whatsapp"
                        class="form-control"
                        value="{{ old('no_whatsapp') }}"
                        required
                        inputmode="numeric"
                        maxlength="13"
                        pattern="[0-9]{1,13}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                    >

                    @error('no_whatsapp')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

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
                            value="Aktif"
                            @selected(
                                old('status', 'Aktif')
                                === 'Aktif'
                            )
                        >
                            Aktif
                        </option>

                        <option
                            value="Tidak Aktif"
                            @selected(
                                old('status')
                                === 'Tidak Aktif'
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
                    href="{{ route('pic.index') }}"
                    class="btn btn-back"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="btn btn-lsp btn-save"
                >

                    <i class="bi bi-check2-circle" aria-hidden="true"></i>

                    Simpan Data PIC

                </button>

            </div>


        </form>

    </div>

</div>

@endsection