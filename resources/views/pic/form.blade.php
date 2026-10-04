<div class="row g-3">


    <div class="col-12">

        <label class="form-label">
            Perusahaan *
        </label>

        <select
            name="id_perusahaan"
            class="form-select"
            required
        >

            <option value="">
                -- Pilih Perusahaan --
            </option>


            @foreach($perusahaan as $item)

                <option
                    value="{{ $item->id_perusahaan }}"
                    @selected(
                        old(
                            'id_perusahaan',
                            $pic->id_perusahaan
                                ?? request('id_perusahaan')
                        )
                        == $item->id_perusahaan
                    )
                >

                    {{ $item->nama_perusahaan }}

                </option>

            @endforeach

        </select>

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Nama PIC *
        </label>

        <input
            type="text"
            name="nama_pic"
            class="form-control"
            value="{{ old(
                'nama_pic',
                $pic->nama_pic ?? ''
            ) }}"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Jabatan *
        </label>

        <input
            type="text"
            name="jabatan"
            class="form-control"
            value="{{ old(
                'jabatan',
                $pic->jabatan ?? ''
            ) }}"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Email
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old(
                'email',
                $pic->email ?? ''
            ) }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Nomor WhatsApp *
        </label>

        <input
            type="text"
            name="no_whatsapp"
            class="form-control"
            value="{{ old(
                'no_whatsapp',
                $pic->no_whatsapp ?? ''
            ) }}"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select"
        >

            <option value="Aktif">
                Aktif
            </option>

            <option value="Tidak Aktif">
                Tidak Aktif
            </option>

        </select>

    </div>

</div>