@extends('layouts.app')

@section('title', 'Tambah Data Mitra')

@section(
    'breadcrumb',
    'Data Mitra / Tambah'
)


@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title">
            Tambah Data Mitra
        </h2>

    </div>


    <a
        href="{{ route('mitra.index') }}"
        class="btn btn-back"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>



<div class="card">

    <div class="card-body p-4">


        <form
            action="{{ route('mitra.store') }}"
            method="POST"
        >

            @csrf


            <div class="row g-3">


                {{-- NAMA MITRA --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Nama Mitra

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <input
                        type="text"
                        name="nama_mitra"
                        class="form-control"
                        value="{{ old('nama_mitra') }}"
                        required
                    >

                </div>


                {{-- KATEGORI MITRA --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Kategori Mitra

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <select
                        name="kategori_mitra"
                        id="kategori_mitra"
                        class="form-select"
                        required
                    >
                        <option
                            value=""
                            disabled
                            @selected(old('kategori_mitra', '') === '')
                        >Pilih kategori...</option>

                        @foreach (\App\Models\Mitra::KATEGORI_MITRA as $kategori)
                            <option
                                value="{{ $kategori }}"
                                @selected(old('kategori_mitra') === $kategori)
                            >{{ $kategori }}</option>
                        @endforeach
                    </select>

                    @error('kategori_mitra')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    <div
                        class="mt-3"
                        id="kategori-mitra-lainnya-wrapper"
                        @if (old('kategori_mitra') !== 'Lainnya') hidden @endif
                    >
                        <label
                            for="kategori_mitra_lainnya"
                            class="form-label fw-semibold"
                        >
                            Sebutkan Kategori Mitra
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="kategori_mitra_lainnya"
                            id="kategori_mitra_lainnya"
                            class="form-control"
                            placeholder="Masukkan kategori mitra..."
                            value="{{ old('kategori_mitra_lainnya') }}"
                            @required(old('kategori_mitra') === 'Lainnya')
                        >

                        @error('kategori_mitra_lainnya')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>


                {{-- ALAMAT --}}

                <div class="col-12">

                    <label class="form-label fw-semibold">

                        Alamat

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <textarea
                        name="alamat"
                        class="form-control"
                        rows="3"
                        required
                    >{{ old('alamat') }}</textarea>

                </div>


                {{-- WEBSITE --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Website
                    </label>

                    <input
                        type="url"
                        name="website"
                        class="form-control"
                        placeholder="https://contoh.com"
                        value="{{ old('website') }}"
                    >

                </div>


                {{-- EMAIL --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Email Mitra
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


                {{-- NOMOR KONTAK MITRA --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Nomor Kontak Mitra
                    </label>

                    <input
                        type="text"
                        name="no_telepon"
                        id="no_telepon"
                        class="form-control"
                        value="{{ old('no_telepon') }}"
                        inputmode="numeric"
                        maxlength="13"
                        pattern="[0-9]{1,13}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                    >

                    <div class="form-text">
                        Nomor yang pertama kali diperoleh dan belum tentu merupakan nomor PIC.
                    </div>

                    @error('no_telepon')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                {{-- SUMBER DATA --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Sumber Data
                    </label>

                    <input
                        type="text"
                        name="sumber_data"
                        class="form-control"
                        placeholder="Website, Google, Instagram, dll."
                        value="{{ old('sumber_data') }}"
                    >

                </div>


                {{-- STATUS KONTAK --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Status Kontak

                    </label>

                    <select
                        name="status_kontak"
                        id="status_kontak"
                        class="form-select"
                    >

                        <option value="" hidden>
                        </option>

                        <option value="Belum Diverifikasi">
                            Belum Diverifikasi
                        </option>

                        <option value="Kontak Mitra">
                            Kontak Mitra
                        </option>

                        <option value="Terverifikasi PIC">
                            Terverifikasi PIC
                        </option>

                        <option value="Bukan PIC">
                            Bukan PIC
                        </option>

                        <option value="Tidak Dapat Dihubungi">
                            Tidak Dapat Dihubungi
                        </option>

                    </select>

                </div>


                {{-- STATUS MITRA --}}

                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Status Mitra

                        <span class="text-danger">
                            *
                        </span>

                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option value="Calon">
                            Calon
                        </option>

                        <option value="Aktif">
                            Aktif
                        </option>

                        <option value="Tidak Aktif">
                            Tidak Aktif
                        </option>

                    </select>

                </div>


                {{-- TOGGLE DATA PIC --}}

                <div
                    class="col-12"
                    id="pic-toggle-wrapper"
                >

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 rounded-3 border bg-light p-3">
                        <div class="d-flex align-items-center gap-3">
                            <span
                                class="d-flex align-items-center justify-content-center rounded-3"
                                style="width: 42px; height: 42px; flex: 0 0 42px; background: #fff4bf; color: #6c5a00;"
                                aria-hidden="true"
                            >
                                <i class="bi bi-person-lines-fill fs-5"></i>
                            </span>
                            <div>
                                <strong class="d-block">Data PIC Mitra</strong>
                                <span class="small text-muted">Tambahkan jika informasi PIC sudah tersedia.</span>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="btn btn-lsp btn-sm d-inline-flex align-items-center gap-2"
                            id="pic-toggle"
                            aria-expanded="{{ old('nama_pic') || old('jabatan') || old('no_whatsapp_pic') || old('email_pic') ? 'true' : 'false' }}"
                            aria-controls="form-data-pic"
                        >
                            <i class="bi bi-plus-lg" aria-hidden="true"></i>
                            Tambah data PIC
                        </button>
                    </div>

                </div>


                {{-- DATA PIC --}}

                <div
                    class="col-12"
                    id="form-data-pic"
                    style="{{
                        old('nama_pic')
                        || old('jabatan')
                        || old('no_whatsapp_pic')
                        || old('email_pic')
                        ? ''
                        : 'display:none;'
                    }}"
                >

                    <div class="card border">

                        <div class="card-body">

                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        Nama PIC
                                        <span class="text-danger pic-required">
                                            *
                                        </span>

                                    </label>

                                    <input
                                        type="text"
                                        name="nama_pic"
                                        id="nama_pic"
                                        class="form-control"
                                        value="{{ old('nama_pic') }}"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        Jabatan
                                        <span class="text-danger pic-required">
                                            *
                                        </span>

                                    </label>

                                    <input
                                        type="text"
                                        name="jabatan"
                                        id="jabatan"
                                        class="form-control"
                                        value="{{ old('jabatan') }}"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Email PIC
                                    </label>

                                    <input
                                        type="email"
                                        name="email_pic"
                                        class="form-control"
                                        value="{{ old('email_pic') }}"
                                        maxlength="255"
                                    >

                                    @error('email_pic')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        Nomor WhatsApp PIC
                                        <span class="text-danger pic-required">
                                            *
                                        </span>

                                    </label>

                                    <input
                                        type="text"
                                        name="no_whatsapp_pic"
                                        id="no_whatsapp_pic"
                                        class="form-control"
                                        value="{{ old('no_whatsapp_pic') }}"
                                        inputmode="numeric"
                                        maxlength="13"
                                        pattern="[0-9]{1,13}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                                    >

                                    

                                    @error('no_whatsapp_pic')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>


            <div
                class="d-flex justify-content-end gap-2 mt-4"
            >

                <a
                    href="{{ route('mitra.index') }}"
                    class="btn btn-back"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-lsp btn-save"
                >

                    <i class="bi bi-check2-circle" aria-hidden="true"></i>

                    Simpan Data Mitra

                </button>

            </div>


        </form>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const statusKontak =
            document.getElementById(
                'status_kontak'
            );

        const formPIC =
            document.getElementById(
                'form-data-pic'
            );

        const picToggle =
            document.getElementById(
                'pic-toggle'
            );

        const namaPIC =
            document.getElementById(
                'nama_pic'
            );

        const jabatan =
            document.getElementById(
                'jabatan'
            );

        const noWhatsapp =
            document.getElementById(
                'no_whatsapp_pic'
            );

        const emailPIC =
            document.querySelector(
                '[name="email_pic"]'
            );

        const noTelepon =
            document.getElementById(
                'no_telepon'
            );

        const kategoriMitra =
            document.getElementById(
                'kategori_mitra'
            );

        const kategoriMitraLainnyaWrapper =
            document.getElementById(
                'kategori-mitra-lainnya-wrapper'
            );

        const kategoriMitraLainnya =
            document.getElementById(
                'kategori_mitra_lainnya'
            );

        const requiredMarkers =
            document.querySelectorAll(
                '.pic-required'
            );

        function updateKategoriMitra() {
            const isLainnya = kategoriMitra.value === 'Lainnya';

            kategoriMitraLainnyaWrapper.hidden = !isLainnya;
            kategoriMitraLainnya.required = isLainnya;

            if (!isLainnya) {
                kategoriMitraLainnya.value = '';
            }
        }


        function updatePICForm() {

            const isVerified =
                statusKontak.value === 'Terverifikasi PIC';

            const hasPicDetails =
                namaPIC.value.trim() !== ''
                || jabatan.value.trim() !== ''
                || noWhatsapp.value.trim() !== ''
                || emailPIC.value.trim() !== '';

            const hasMitraNumber =
                noTelepon.value.trim() !== '';

            const isUnreachable =
                statusKontak.value === 'Tidak Dapat Dihubungi';

            if (isUnreachable) {
                formPIC.style.display = 'none';
                picToggle.hidden = true;
                picToggle.setAttribute('aria-expanded', 'false');
            } else {
                picToggle.hidden = formPIC.style.display !== 'none';
            }

            const isPicFormVisible =
                formPIC.style.display !== 'none';
            const requiresPicDetails =
                !isUnreachable && hasPicDetails;

            noWhatsapp.readOnly =
                isVerified && hasMitraNumber && isPicFormVisible;

            if (isVerified && hasMitraNumber && isPicFormVisible) {
                noWhatsapp.value = noTelepon.value;
            } else if (
                isVerified
                && !isPicFormVisible
                && noWhatsapp.value === noTelepon.value
            ) {
                noWhatsapp.value = '';
            }

            namaPIC.required = requiresPicDetails;
            jabatan.required = requiresPicDetails;
            noWhatsapp.required =
                requiresPicDetails && (!isVerified || !hasMitraNumber);

            requiredMarkers.forEach(function (marker) {
                marker.style.display =
                    requiresPicDetails ? 'inline' : 'none';
            });

        }


        picToggle.addEventListener(
            'click',
            function () {
                formPIC.style.display = 'block';
                picToggle.setAttribute('aria-expanded', 'true');

                updatePICForm();
            }
        );


        statusKontak.addEventListener(
            'change',
            function () {
                if (statusKontak.value === 'Tidak Dapat Dihubungi') {
                    namaPIC.value = '';
                    jabatan.value = '';
                    emailPIC.value = '';
                    noWhatsapp.value = '';
                }

                if (
                    statusKontak.value !== 'Terverifikasi PIC'
                    && noTelepon.value.trim() !== ''
                    && noWhatsapp.value === noTelepon.value
                ) {
                    namaPIC.value = '';
                    jabatan.value = '';
                    emailPIC.value = '';
                    noWhatsapp.value = '';
                }

                updatePICForm();
            }
        );

        noTelepon.addEventListener(
            'input',
            function () {
                if (
                    statusKontak.value === 'Terverifikasi PIC'
                    && formPIC.style.display !== 'none'
                ) {
                    noWhatsapp.value = noTelepon.value;
                }

                updatePICForm();
            }
        );

        [namaPIC, jabatan, noWhatsapp].forEach(function (field) {
            field.addEventListener('input', updatePICForm);
        });

        kategoriMitra.addEventListener('change', updateKategoriMitra);

        updateKategoriMitra();
        updatePICForm();

    }
);

</script>

@endsection