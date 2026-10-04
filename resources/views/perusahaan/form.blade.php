@php
    $statusKontak = old(
        'status_kontak',
        $perusahaan->status_kontak ?? 'Belum Diverifikasi'
    );

    $statusPerusahaan = old(
        'status',
        $perusahaan->status ?? 'Calon'
    );

    $picData = $perusahaan->pics->first();
@endphp

<div class="row g-3">

    {{-- NAMA PERUSAHAAN --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Nama Perusahaan <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="nama_perusahaan"
            class="form-control"
            value="{{ old(
                'nama_perusahaan',
                $perusahaan->nama_perusahaan ?? ''
            ) }}"
            required
        >
    </div>


    {{-- BIDANG USAHA --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Bidang Usaha <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="bidang_usaha"
            class="form-control"
            value="{{ old(
                'bidang_usaha',
                $perusahaan->bidang_usaha ?? ''
            ) }}"
            required
        >
    </div>


    {{-- ALAMAT --}}
    <div class="col-12">
        <label class="form-label fw-semibold">
            Alamat <span class="text-danger">*</span>
        </label>

        <textarea
            name="alamat"
            class="form-control"
            rows="3"
            required
        >{{ old(
            'alamat',
            $perusahaan->alamat ?? ''
        ) }}</textarea>
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
            value="{{ old(
                'website',
                $perusahaan->website ?? ''
            ) }}"
        >
    </div>


    {{-- EMAIL PERUSAHAAN --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Email Perusahaan
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old(
                'email',
                $perusahaan->email ?? ''
            ) }}"
        >
    </div>


    {{-- NOMOR KONTAK --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Nomor Kontak
        </label>

        <input
            type="text"
            name="no_telepon"
            class="form-control"
            placeholder="Nomor yang diperoleh"
            value="{{ old(
                'no_telepon',
                $perusahaan->no_telepon ?? ''
            ) }}"
        >

        <div class="form-text">
            Nomor dapat berupa nomor perusahaan atau nomor kontak
            yang belum diketahui apakah merupakan PIC.
        </div>
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
            value="{{ old(
                'sumber_data',
                $perusahaan->sumber_data ?? ''
            ) }}"
        >
    </div>


    {{-- STATUS KONTAK --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Status Kontak <span class="text-danger">*</span>
        </label>

        <select
            name="status_kontak"
            id="status_kontak"
            class="form-select"
            required
        >

            <option
                value="Belum Diverifikasi"
                @selected(
                    $statusKontak === 'Belum Diverifikasi'
                )
            >
                Belum Diverifikasi
            </option>

            <option
                value="Terverifikasi PIC"
                @selected(
                    $statusKontak === 'Terverifikasi PIC'
                )
            >
                Terverifikasi PIC
            </option>

            <option
                value="Bukan PIC"
                @selected(
                    $statusKontak === 'Bukan PIC'
                )
            >
                Bukan PIC
            </option>

            <option
                value="Tidak Dapat Dihubungi"
                @selected(
                    $statusKontak === 'Tidak Dapat Dihubungi'
                )
            >
                Tidak Dapat Dihubungi
            </option>

        </select>

        <div class="form-text">
            Pilih Terverifikasi PIC apabila kontak sudah dipastikan
            merupakan PIC perusahaan.
        </div>
    </div>


    {{-- STATUS PERUSAHAAN --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Status Perusahaan <span class="text-danger">*</span>
        </label>

        <select
            name="status"
            class="form-select"
            required
        >

            <option
                value="Calon"
                @selected($statusPerusahaan === 'Calon')
            >
                Calon
            </option>

            <option
                value="Aktif"
                @selected($statusPerusahaan === 'Aktif')
            >
                Aktif
            </option>

            <option
                value="Tidak Aktif"
                @selected($statusPerusahaan === 'Tidak Aktif')
            >
                Tidak Aktif
            </option>

        </select>
    </div>


    {{-- FORM PIC --}}
    <div
        class="col-12"
        id="form-data-pic"
        style="{{ $statusKontak === 'Terverifikasi PIC' ? '' : 'display: none;' }}"
    >

        <div class="card border mt-2">

            <div class="card-header bg-white py-3">

                <h5
                    class="mb-0 fw-bold"
                    style="color:#123B5D;"
                >
                    Data PIC Perusahaan
                </h5>

                <small class="text-muted">
                    Data ini akan otomatis disimpan ke tabel PIC
                    ketika status kontak terverifikasi sebagai PIC.
                </small>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    {{-- NAMA PIC --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nama PIC <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_pic"
                            id="nama_pic"
                            class="form-control"
                            value="{{ old(
                                'nama_pic',
                                $picData->nama_pic ?? ''
                            ) }}"
                        >

                    </div>


                    {{-- JABATAN --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Jabatan <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="jabatan"
                            id="jabatan"
                            class="form-control"
                            value="{{ old(
                                'jabatan',
                                $picData->jabatan ?? ''
                            ) }}"
                        >

                    </div>


                    {{-- EMAIL PIC --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Email PIC
                        </label>

                        <input
                            type="email"
                            name="email_pic"
                            class="form-control"
                            value="{{ old(
                                'email_pic',
                                $picData->email ?? ''
                            ) }}"
                        >

                    </div>


                    {{-- WHATSAPP PIC --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nomor WhatsApp PIC
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="no_whatsapp_pic"
                            id="no_whatsapp_pic"
                            class="form-control"
                            value="{{ old(
                                'no_whatsapp_pic',
                                $picData->no_whatsapp ?? ''
                            ) }}"
                        >

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const statusKontak =
        document.getElementById('status_kontak');

    const formPic =
        document.getElementById('form-data-pic');

    const namaPic =
        document.getElementById('nama_pic');

    const jabatan =
        document.getElementById('jabatan');

    const nomorWhatsappPic =
        document.getElementById('no_whatsapp_pic');


    function updateFormPIC() {

        if (
            statusKontak.value ===
            'Terverifikasi PIC'
        ) {

            formPic.style.display = 'block';

            namaPic.required = true;

            jabatan.required = true;

            nomorWhatsappPic.required = true;

        } else {

            formPic.style.display = 'none';

            namaPic.required = false;

            jabatan.required = false;

            nomorWhatsappPic.required = false;

        }

    }


    statusKontak.addEventListener(
        'change',
        updateFormPIC
    );


    updateFormPIC();

});
</script>