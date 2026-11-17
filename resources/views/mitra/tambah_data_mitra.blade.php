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

                <div class="col-12" id="jurusan-wrapper" hidden>
                    <label class="form-label fw-semibold">Jurusan / Program Studi</label>
                    <div id="jurusan-rows">
                        @foreach (old('jurusans', [['nama' => '', 'no_telepon' => '']]) as $index => $jurusan)
                            <div class="card border mb-3 jurusan-row p-3" data-jurusan-key="index:{{ $index }}"><div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Nama Jurusan / Program Studi</label><input class="form-control" name="jurusans[{{ $index }}][nama]" value="{{ $jurusan['nama'] ?? '' }}">@error('jurusans.'.$index.'.nama')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                                <div class="col-md-6"><label class="form-label">Nomor Kontak Jurusan / Program Studi</label><input class="form-control" name="jurusans[{{ $index }}][no_telepon]" value="{{ $jurusan['no_telepon'] ?? '' }}" inputmode="numeric" maxlength="13"></div>
                                <div class="col-12 text-end"><button type="button" class="btn btn-back remove-jurusan">Hapus Jurusan</button></div>
                            </div></div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-back" id="add-jurusan">Tambah Jurusan</button>
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
                            aria-expanded="{{ old('nama_pic') || old('jabatan') || old('no_whatsapp_pic') || old('email_pic') || old('pics') ? 'true' : 'false' }}"
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
                        || old('pics')
                        ? ''
                        : 'display:none;'
                    }}"
                >

                    <div class="card border">

                        <div class="card-body">

                            <input type="hidden" name="pics_present" value="1">

                            <div class="row g-3">

                                <div class="col-12" id="pic-jurusan-scope-wrapper" hidden>
                                    <label class="form-label fw-semibold">Jurusan yang ditangani PIC</label>
                                    <div class="pic-jurusan-select border border-warning rounded-3 bg-warning-subtle p-2" id="pic-jurusan-keys" data-input-name="pic_jurusan_keys[]" data-selected-keys="{{ implode(',', old('pic_jurusan_keys', ['__instansi__'])) }}"></div>
                                </div>


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

                            <div id="additional-pics" class="mt-3">
                                @foreach (old('pics', []) as $extraIndex => $extraPic)
                                    <div class="card border mt-3 pic-entry">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12 pic-entry-scope-wrapper" hidden>
                                                    <label class="form-label fw-semibold">Jurusan yang ditangani PIC</label>
                                                    <div class="pic-jurusan-select border border-warning rounded-3 bg-warning-subtle p-2" data-input-name="pics[{{ $extraIndex }}][jurusan_keys][]" data-selected-keys="{{ implode(',', $extraPic['jurusan_keys'] ?? []) }}"></div>
                                                    <div class="form-text">Pilihan menampilkan nama mitra dan jurusan. Centang satu atau beberapa jurusan; beberapa PIC dapat ditambahkan pada jurusan yang sama. Pilih Seluruh Jurusan jika PIC menangani semuanya.</div>
                                                </div>
                                                <div class="col-md-6"><label class="form-label fw-semibold">Nama PIC <span class="text-danger">*</span></label><input class="form-control" name="pics[{{ $extraIndex }}][nama_pic]" value="{{ $extraPic['nama_pic'] ?? '' }}">@error('pics.'.$extraIndex.'.nama_pic')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                                                <div class="col-md-6"><label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label><input class="form-control" name="pics[{{ $extraIndex }}][jabatan]" value="{{ $extraPic['jabatan'] ?? '' }}">@error('pics.'.$extraIndex.'.jabatan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                                                <div class="col-md-6"><label class="form-label fw-semibold">Email PIC</label><input type="email" class="form-control" name="pics[{{ $extraIndex }}][email_pic]" value="{{ $extraPic['email_pic'] ?? '' }}" maxlength="255"></div>
                                                <div class="col-md-6"><label class="form-label fw-semibold">Nomor WhatsApp PIC <span class="text-danger">*</span></label><input class="form-control" name="pics[{{ $extraIndex }}][no_whatsapp]" value="{{ $extraPic['no_whatsapp'] ?? '' }}" inputmode="numeric" maxlength="13" pattern="[0-9]{1,13}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"></div>
                                                <div class="col-12 text-end"><button type="button" class="btn btn-back remove-pic">Hapus PIC</button></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-back mt-3" id="add-pic">Tambah PIC</button>

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

<template id="pic-entry-template">
    <div class="card border mt-3 pic-entry" data-pic-index="__INDEX__">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 pic-entry-scope-wrapper" hidden>
                    <label class="form-label fw-semibold">Jurusan yang ditangani PIC</label>
                    <div class="pic-jurusan-select border border-warning rounded-3 bg-warning-subtle p-2" data-input-name="pics[__INDEX__][jurusan_keys][]"></div>
                    <div class="form-text">Pilihan menampilkan nama mitra dan jurusan. Centang satu atau beberapa jurusan; beberapa PIC dapat ditambahkan pada jurusan yang sama. Pilih Seluruh Jurusan jika PIC menangani semuanya.</div>
                </div>
                <div class="col-md-6"><label class="form-label fw-semibold">Nama PIC <span class="text-danger">*</span></label><input class="form-control" name="pics[__INDEX__][nama_pic]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label><input class="form-control" name="pics[__INDEX__][jabatan]"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Email PIC</label><input type="email" class="form-control" name="pics[__INDEX__][email_pic]" maxlength="255"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Nomor WhatsApp PIC <span class="text-danger">*</span></label><input class="form-control" name="pics[__INDEX__][no_whatsapp]" inputmode="numeric" maxlength="13" pattern="[0-9]{1,13}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"></div>
                <div class="col-12 text-end"><button type="button" class="btn btn-back remove-pic">Hapus PIC</button></div>
            </div>
        </div>
    </div>
</template>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

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

        const jurusanWrapper = document.getElementById('jurusan-wrapper');
        const jurusanRows = document.getElementById('jurusan-rows');
        const picJurusanScopeWrapper = document.getElementById('pic-jurusan-scope-wrapper');
        const additionalPics = document.getElementById('additional-pics');
        const picTemplate = document.getElementById('pic-entry-template');
        let nextPicIndex = 0;
        let nextPicJurusanOptionId = 0;
        let nextJurusanIndex = Array.from(jurusanRows.querySelectorAll('.jurusan-row input[name]'))
            .map(function (input) {
                const match = input.name.match(/jurusans\[(\d+)\]/);
                return match ? Number(match[1]) + 1 : 0;
            })
            .reduce(function (highest, index) { return Math.max(highest, index); }, 0);

        function refreshPicJurusanOptions() {
            const institutionName = document.querySelector('[name="nama_mitra"]').value.trim() || 'Mitra';
            const isEducation = ['Sekolah', 'Perguruan Tinggi'].includes(kategoriMitra.value);
            document.querySelectorAll('.pic-jurusan-select').forEach(function (options) {
                const selectedKeys = Array.from(options.querySelectorAll('input:checked')).map(function (input) { return input.value; });
                if (selectedKeys.length === 0 && options.dataset.selectedKeys) {
                    selectedKeys.push(...options.dataset.selectedKeys.split(','));
                    delete options.dataset.selectedKeys;
                }
                options.innerHTML = '';
                const addOption = function (key, label) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'form-check';
                    const input = document.createElement('input');
                    input.type = 'checkbox';
                    input.className = 'form-check-input';
                    input.id = 'pic-jurusan-option-' + nextPicJurusanOptionId++;
                    input.name = options.dataset.inputName;
                    input.value = key;
                    input.checked = selectedKeys.includes(key);
                    input.disabled = !isEducation;
                    input.style.setProperty('--bs-form-check-checked-bg-color', '#f4ce00');
                    input.style.setProperty('--bs-form-check-checked-border-color', '#f4ce00');
                    const labelElement = document.createElement('label');
                    labelElement.className = 'form-check-label';
                    labelElement.htmlFor = input.id;
                    labelElement.textContent = label;
                    wrapper.append(input, labelElement);
                    options.appendChild(wrapper);
                };

                addOption('__instansi__', institutionName + ' - Seluruh Jurusan');

                jurusanRows.querySelectorAll('.jurusan-row').forEach(function (row) {
                    const name = row.querySelector('[name$="[nama]"]');
                    if (!name || name.value.trim() === '') {
                        return;
                    }
                    addOption(row.dataset.jurusanKey, institutionName + ' - ' + name.value);
                });
            });
            picJurusanScopeWrapper.hidden = !['Sekolah', 'Perguruan Tinggi'].includes(kategoriMitra.value);
            document.querySelectorAll('.pic-entry-scope-wrapper').forEach(function (wrapper) {
                wrapper.hidden = !['Sekolah', 'Perguruan Tinggi'].includes(kategoriMitra.value);
            });
        }

        document.addEventListener('change', function (event) {
            const checkbox = event.target.closest('.pic-jurusan-select input[type="checkbox"]');
            if (!checkbox) {
                return;
            }
            const options = checkbox.closest('.pic-jurusan-select');
            if (checkbox.checked && checkbox.value === '__instansi__') {
                options.querySelectorAll('input[type="checkbox"]').forEach(function (input) {
                    input.checked = input === checkbox;
                });
            } else if (checkbox.checked) {
                const allJurusans = options.querySelector('input[value="__instansi__"]');
                if (allJurusans) {
                    allJurusans.checked = false;
                }
            }
            updatePICForm();
        });

        function updateJurusanForm() {
            const isEducation = ['Sekolah', 'Perguruan Tinggi'].includes(kategoriMitra.value);
            jurusanWrapper.hidden = !isEducation;
            jurusanWrapper.querySelectorAll('input, select').forEach(function (field) {
                field.disabled = !isEducation;
            });
            document.querySelectorAll('.pic-jurusan-select input[type="checkbox"]').forEach(function (input) { input.disabled = !isEducation; });
            picJurusanScopeWrapper.hidden = !isEducation;
            refreshPicJurusanOptions();
        }
        document.getElementById('add-jurusan').addEventListener('click', function () {
            const index = nextJurusanIndex++;
            const template = jurusanRows.querySelector('.jurusan-row').cloneNode(true);
            template.dataset.jurusanKey = 'index:' + index;
            template.querySelectorAll('input, select').forEach(function (field) {
                field.value = '';
                field.name = field.name.replace(/jurusans\[\d+\]/, 'jurusans[' + index + ']');
            });
            jurusanRows.appendChild(template);
            refreshPicJurusanOptions();
        });
        document.getElementById('add-pic').addEventListener('click', function () {
            const index = nextPicIndex++;
            const entry = picTemplate.content.firstElementChild.cloneNode(true);
            entry.innerHTML = entry.innerHTML.replaceAll('__INDEX__', String(index));
            additionalPics.appendChild(entry);
            refreshPicJurusanOptions();
        });
        additionalPics.addEventListener('click', function (event) {
            if (event.target.closest('.remove-pic')) {
                event.target.closest('.pic-entry').remove();
            }
        });
        jurusanRows.addEventListener('click', function (event) {
            if (event.target.closest('.remove-jurusan') && jurusanRows.querySelectorAll('.jurusan-row').length > 1) {
                event.target.closest('.jurusan-row').remove();
                refreshPicJurusanOptions();
            }
        });
        jurusanRows.addEventListener('input', function () {
            refreshPicJurusanOptions();
        });
        jurusanRows.addEventListener('change', refreshPicJurusanOptions);

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

            const hasPicDetails =
                namaPIC.value.trim() !== ''
                || jabatan.value.trim() !== ''
                || noWhatsapp.value.trim() !== ''
                || emailPIC.value.trim() !== '';

            picToggle.hidden = formPIC.style.display !== 'none';

            const requiresPicDetails = hasPicDetails;

            namaPIC.required = requiresPicDetails;
            jabatan.required = requiresPicDetails;
            noWhatsapp.required = requiresPicDetails;

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


        noTelepon.addEventListener(
            'input',
            function () {
                refreshPicJurusanOptions();
                updatePICForm();
            }
        );

        [namaPIC, jabatan, noWhatsapp].forEach(function (field) {
            field.addEventListener('input', updatePICForm);
        });

        kategoriMitra.addEventListener('change', updateKategoriMitra);
        kategoriMitra.addEventListener('change', updateJurusanForm);
        document.querySelector('[name="nama_mitra"]').addEventListener('input', refreshPicJurusanOptions);

        updateKategoriMitra();
        updateJurusanForm();
        updatePICForm();

    }
);

</script>

@endsection
