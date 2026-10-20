@extends('layouts.app')

@section('title', 'Hapus Data Mitra')

@section(
    'breadcrumb',
    'Data Mitra / Hapus'
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

                    Hapus Data Mitra?

                </h3>


                <p class="text-muted">

                    Kamu akan menghapus data mitra:

                </p>


                <div
                    class="border rounded p-3 mb-4"
                    style="background:#F8FAFC;"
                >

                    <h5
                        class="fw-bold mb-1"
                        style="color:var(--navy);"
                    >

                        {{ $mitra->nama_mitra }}

                    </h5>

                    <div class="text-muted">

                        {{ $mitra->bidang_usaha }}

                    </div>

                </div>


                <div
                    class="alert alert-danger text-start"
                >

                    <strong>
                        Perhatian:
                    </strong>

                    menghapus mitra juga akan
                    menghapus data PIC yang berkaitan
                    dengan mitra ini.

                </div>


                <div
                    class="d-flex justify-content-center gap-2 mt-4"
                >

                    <a
                        href="{{ route('mitra.index') }}"
                        class="btn btn-back"
                    >

                        Batal

                    </a>


                    <form
                        action="{{ route(
                            'mitra.destroy',
                            $mitra
                        ) }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >

                            <i class="bi bi-trash me-1"></i>

                            Ya, Hapus Data

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection