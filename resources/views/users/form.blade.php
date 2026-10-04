<div class="row g-3">


    <div class="col-md-6">

        <label class="form-label">
            Nama *
        </label>

        <input
            type="text"
            name="nama"
            class="form-control"
            value="{{ old(
                'nama',
                $user->nama ?? ''
            ) }}"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Email *
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old(
                'email',
                $user->email ?? ''
            ) }}"
            required
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Role *
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
                        old(
                            'id_role',
                            $user->id_role ?? ''
                        )
                        == $role->id_role
                    )
                >

                    {{ $role->nama_role }}

                </option>

            @endforeach

        </select>

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Nomor WhatsApp
        </label>

        <input
            type="text"
            name="no_whatsapp"
            class="form-control"
            value="{{ old(
                'no_whatsapp',
                $user->no_whatsapp ?? ''
            ) }}"
        >

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Password
        </label>

        <input
            type="password"
            name="password"
            class="form-control"
            @if(!isset($user))
                required
            @endif
        >

        @if(isset($user))

            <small class="text-muted">

                Kosongkan jika tidak mengganti password.

            </small>

        @endif

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select"
        >

            <option value="aktif">
                Aktif
            </option>

            <option value="tidak aktif">
                Tidak Aktif
            </option>

        </select>

    </div>

</div>