@extends('layouts.app')

@section('title', 'Hapus Data PIC')

@section(
    'breadcrumb',
    'Data PIC / Hapus'
)


@section('content')

<div class="row justify-content-center">

    <div class="col-lg-7">

        <div class="card">

            <div class="card-body p-4 p-md-5 text-center">


                <div
                    class="mx-auto mb-4 d-flex align-items-center justify-content-center"
                    style="
                        width:70px;
                        height:70px;
                        border-radius:50%;
                        background:#FDECEC;
                        color:#DC3545;
                        font-size:30px;
                    "
                >

                    <i class="bi bi-trash"></i>

                </div>


                <h3
                    class="fw-bold"
                    style="color:var(--navy);"
                >

                    Hapus Data PIC?

                </h3>


                <p class="text-muted">

                    Kamu akan menghapus data PIC berikut:

                </p>


                <div
                    class="border rounded p-3 mb-4"
                    style="background:#F8FAFC;"
                >

                    <h5
                        class="fw-bold mb-1"
                        style="color:var(--navy);"
                    >

                        {{ $pic->nama_pic }}

                    </h5>


                    <div class="text-muted">

                        {{ $pic->jabatan }}

                    </div>


                    <div class="mt-2">

                        Mitra:

                        {{
                            $pic->mitra
                                ->nama_mitra
                        }}

                    </div>


                    <div class="mt-1">

                        WhatsApp:

                        {{ $pic->no_whatsapp }}

                    </div>

                </div>


                <div
                    class="alert alert-warning text-start"
                >

                    <strong>
                        Perhatian:
                    </strong>

                    @if($statusKontakAfterDeletion === 'Bukan PIC')
                        status nomor kontak mitra sudah ditetapkan sebagai
                        <strong>Bukan PIC</strong> dan tidak akan berubah.
                    @elseif($statusKontakAfterDeletion === 'Terverifikasi PIC')
                        masih ada PIC lain yang terdaftar. Status kontak mitra
                        akan tetap <strong>Terverifikasi PIC</strong>.
                    @else
                        tidak ada PIC lain yang tersisa. Status kontak mitra
                        akan menjadi <strong>Belum Diverifikasi</strong>.
                    @endif

                </div>


                <div
                    class="d-flex justify-content-center gap-2 mt-4"
                >

                    <a
                        href="{{ route('pic.index') }}"
                        class="btn btn-back"
                    >

                        Batal

                    </a>


                    <form
                        action="{{ route(
                            'pic.destroy',
                            $pic
                        ) }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')


                        <button
                            type="submit"
                            class="btn btn-danger"
                        >

                            <i
                                class="bi bi-trash me-1"
                            ></i>

                            Ya, Hapus Data

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection