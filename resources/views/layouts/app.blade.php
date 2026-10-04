<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield(
            'title',
            'LSP P3 Teknologi Informasi Banua'
        )
    </title>


    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <style>

        :root {

            --navy: #123B5D;

            --blue: #0F6B8A;

            --yellow: #F4B942;

            --yellow-hover: #E4A72F;

            --background: #F5F7FA;

            --white: #FFFFFF;

            --text: #1F2937;

            --border: #E5E7EB;

        }


        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            background:
                var(--background);

            color:
                var(--text);

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        .sidebar {

            width: 260px;

            min-height: 100vh;

            position: fixed;

            top: 0;

            left: 0;

            bottom: 0;

            background:
                var(--navy);

            z-index: 1000;

            overflow-y: auto;

        }


        /*
        |--------------------------------------------------------------------------
        | BRAND
        |--------------------------------------------------------------------------
        */

        .brand {

            padding: 18px 20px;

            color:
                var(--white);

            border-bottom:
                1px solid
                rgba(255,255,255,.15);

        }


        .brand-wrapper {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .brand-logo {

            width: 68px;

            height: 68px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                transparent;

            border-radius: 0;

            padding: 0;

            overflow: hidden;

        }


        .brand-logo img {

            width: 100%;

            height: 100%;

            object-fit: contain;

            display: block;

            /*
             * JANGAN gunakan mix-blend-mode: screen.
             * Warna hitam pada logo harus tetap terlihat.
             */

        }


        /*
        |--------------------------------------------------------------------------
        | BRAND TEXT
        |--------------------------------------------------------------------------
        */

        .brand-text {

            line-height: 1.25;

            min-width: 0;

        }


        .brand-title {

            font-size: 17px;

            font-weight: 700;

            margin: 0;

            color:
                var(--white);

        }


        .brand-subtitle {

            font-size: 11px;

            color:
                rgba(255,255,255,.78);

            margin:
                3px 0 0 0;

        }


        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */

        .sidebar-menu {

            padding:
                14px 0;

            padding-bottom:
                180px;

        }


        .sidebar-menu-title {

            padding:
                8px 20px;

            font-size:
                11px;

            color:
                rgba(255,255,255,.55);

            text-transform:
                uppercase;

            letter-spacing:
                .8px;

            font-weight:
                700;

        }


        .sidebar .nav-link {

            display: flex;

            align-items: center;

            color:
                rgba(255,255,255,.88);

            margin:
                4px 12px;

            padding:
                11px 14px;

            border-radius:
                9px;

            text-decoration:
                none;

            transition:
                all .2s ease;

        }


        .sidebar .nav-link i {

            width:
                22px;

            font-size:
                17px;

        }


        .sidebar .nav-link:hover {

            background:
                rgba(244,185,66,.18);

            color:
                var(--white);

        }


        .sidebar .nav-link.active {

            background:
                var(--yellow);

            color:
                var(--navy);

            font-weight:
                700;

        }


        .sidebar .nav-link.active i {

            color:
                var(--navy);

        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR USER
        |--------------------------------------------------------------------------
        */

        .sidebar-user {

            position:
                absolute;

            bottom:
                0;

            left:
                0;

            width:
                100%;

            padding:
                14px 16px;

            background:
                rgba(0,0,0,.10);

            border-top:
                1px solid
                rgba(255,255,255,.12);

        }


        .sidebar-user-icon {

            width:
                38px;

            height:
                38px;

            flex-shrink:
                0;

            border-radius:
                50%;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                rgba(255,255,255,.12);

            color:
                var(--white);

        }


        .sidebar-user-name {

            color:
                var(--white);

            font-size:
                14px;

            font-weight:
                600;

        }


        .sidebar-user-role {

            color:
                rgba(255,255,255,.65);

            font-size:
                12px;

            margin-top:
                2px;

        }


        .logout-button {

            margin-top:
                10px;

        }


        /*
        |--------------------------------------------------------------------------
        | MAIN
        |--------------------------------------------------------------------------
        */

        .main {

            margin-left:
                260px;

            min-height:
                100vh;

        }


        /*
        |--------------------------------------------------------------------------
        | TOPBAR
        |--------------------------------------------------------------------------
        */

        .topbar {

            height:
                70px;

            background:
                var(--white);

            padding:
                0 26px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            border-bottom:
                1px solid
                var(--border);

            position:
                sticky;

            top:
                0;

            z-index:
                900;

        }


        .topbar-title {

            color:
                var(--navy);

            font-size:
                18px;

            font-weight:
                700;

        }


        .topbar-user {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

        }


        .topbar-user-icon {

            width:
                38px;

            height:
                38px;

            border-radius:
                50%;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                #EEF3F7;

            color:
                var(--navy);

        }


        .topbar-user-info {

            line-height:
                1.2;

        }


        .topbar-user-name {

            color:
                var(--navy);

            font-size:
                13px;

            font-weight:
                700;

        }


        .topbar-user-role {

            color:
                #6B7280;

            font-size:
                11px;

        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .content {

            padding:
                26px;

        }


        /*
        |--------------------------------------------------------------------------
        | PAGE TITLE
        |--------------------------------------------------------------------------
        */

        .page-title {

            margin:
                0;

            color:
                var(--navy);

            font-weight:
                800;

        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        .card {

            border:
                none;

            border-radius:
                14px;

            box-shadow:
                0 5px 18px
                rgba(18,59,93,.07);

        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        .btn-lsp {

            background:
                var(--yellow);

            border-color:
                var(--yellow);

            color:
                var(--navy);

            font-weight:
                700;

        }


        .btn-lsp:hover {

            background:
                var(--yellow-hover);

            border-color:
                var(--yellow-hover);

            color:
                var(--navy);

        }


        .btn-outline-primary,
        .btn-warning {

            background:
                var(--yellow);

            border-color:
                var(--yellow);

            color:
                var(--navy);

            font-weight:
                700;

        }


        .btn-outline-primary:hover,
        .btn-outline-primary:active,
        .btn-warning:hover,
        .btn-warning:active {

            background:
                var(--yellow-hover);

            border-color:
                var(--yellow-hover);

            color:
                var(--navy);

        }


        .btn-outline-warning {

            border-color:
                var(--yellow);

            color:
                var(--navy);

            font-weight:
                700;

        }


        .btn-outline-warning:hover,
        .btn-outline-warning:active {

            background:
                var(--yellow);

            border-color:
                var(--yellow);

            color:
                var(--navy);

        }


        .btn-outline-primary:focus,
        .btn-warning:focus,
        .btn-outline-warning:focus {

            box-shadow:
                0 0 0 .25rem
                rgba(244,185,66,.35);

        }


        .bg-warning {

            background-color:
                var(--yellow) !important;

        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .table {

            margin-bottom:
                0;

        }


        .table thead th {

            background:
                #EEF3F7;

            color:
                var(--navy);

            white-space:
                nowrap;

            font-size:
                13px;

        }


        .table tbody td {

            vertical-align:
                middle;

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        .status-warning {

            background:
                #FFF4D6;

            color:
                #7A5A00;

        }


        /*
        |--------------------------------------------------------------------------
        | ALERT
        |--------------------------------------------------------------------------
        */

        .alert {

            border:
                none;

            border-radius:
                10px;

        }


        /*
        |--------------------------------------------------------------------------
        | SCROLLBAR
        |--------------------------------------------------------------------------
        */

        .sidebar::-webkit-scrollbar {

            width:
                5px;

        }


        .sidebar::-webkit-scrollbar-thumb {

            background:
                rgba(255,255,255,.2);

            border-radius:
                10px;

        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991px) {

            .sidebar {

                position:
                    static;

                width:
                    100%;

                min-height:
                    auto;

            }


            .sidebar-user {

                position:
                    static;

            }


            .main {

                margin-left:
                    0;

            }


            .topbar {

                position:
                    static;

            }


            .content {

                padding:
                    18px;

            }

        }


        @media (max-width: 576px) {

            .topbar {

                padding:
                    0 15px;

            }


            .topbar-user-info {

                display:
                    none;

            }


            .content {

                padding:
                    15px;

            }


            .brand-logo {

                width:
                    60px;

                height:
                    60px;

            }

        }

    </style>

    @stack('styles')

</head>


<body>


    {{-- =========================================================
    SIDEBAR
    ========================================================== --}}

    <aside class="sidebar">


        {{-- BRAND --}}
        <div class="brand">

            <div class="brand-wrapper">


                {{-- LOGO LSP --}}
                <div class="brand-logo">

                    <img
                        src="{{ asset('images/Logo-LSP-TIB.png') }}"
                        alt="Logo LSP P3 Teknologi Informasi Banua"
                    >

                </div>


                {{-- NAMA LSP --}}
                <div class="brand-text">

                    <p class="brand-title">
                        LSP P3
                    </p>

                    <p class="brand-subtitle">
                        Teknologi Informasi Banua
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
        MENU
        ====================================================== --}}

        <div class="sidebar-menu">


            <div class="sidebar-menu-title">
                Menu Utama
            </div>


            {{-- DASHBOARD --}}
            <a
                href="{{ route('dashboard') }}"
                class="nav-link
                    {{ request()->routeIs('dashboard')
                        ? 'active'
                        : '' }}"
            >

                <i class="bi bi-grid-1x2-fill me-2"></i>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- DATA PERUSAHAAN --}}
            <a
                href="{{ route('perusahaan.index') }}"
                class="nav-link
                    {{ request()->routeIs('perusahaan.*')
                        ? 'active'
                        : '' }}"
            >

                <i class="bi bi-building me-2"></i>

                <span>
                    Data Perusahaan
                </span>

            </a>


            {{-- DATA PIC --}}
            <a
                href="{{ route('pic.index') }}"
                class="nav-link
                    {{ request()->routeIs('pic.*')
                        ? 'active'
                        : '' }}"
            >

                <i class="bi bi-person-badge me-2"></i>

                <span>
                    Data PIC
                </span>

            </a>


            {{-- PENGGUNA --}}
            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('users.index') }}"
                    class="nav-link
                        {{ request()->routeIs('users.*')
                            ? 'active'
                            : '' }}"
                >

                    <i class="bi bi-people me-2"></i>

                    <span>
                        Pengguna
                    </span>

                </a>

            @endif

        </div>


        {{-- =====================================================
        USER SIDEBAR
        ====================================================== --}}

        <div class="sidebar-user">


            <div class="d-flex align-items-center gap-2">


                <div class="sidebar-user-icon">

                    <i class="bi bi-person-fill"></i>

                </div>


                <div>

                    <div class="sidebar-user-name">

                        {{ auth()->user()->nama }}

                    </div>

                    <div class="sidebar-user-role">

                        {{ auth()->user()->role?->nama_role }}

                    </div>

                </div>

            </div>


            {{-- LOGOUT --}}
            <form
                action="{{ route('logout') }}"
                method="POST"
                class="logout-button"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-light btn-sm w-100"
                >

                    <i
                        class="bi bi-box-arrow-right me-1"
                    ></i>

                    Keluar

                </button>

            </form>

        </div>

    </aside>


    {{-- =========================================================
    MAIN CONTENT
    ========================================================== --}}

    <main class="main">


        {{-- TOPBAR --}}
        <header class="topbar">


            {{-- JUDUL HALAMAN --}}
            <div>

                <div class="topbar-title">

                    @yield(
                        'breadcrumb',
                        'Sistem Pengelolaan Kerja Sama Mitra'
                    )

                </div>

            </div>


            {{-- USER TOPBAR --}}
            <div class="topbar-user">


                <div class="topbar-user-icon">

                    <i class="bi bi-person-fill"></i>

                </div>


                <div class="topbar-user-info">

                    <div class="topbar-user-name">

                        {{ auth()->user()->nama }}

                    </div>

                    <div class="topbar-user-role">

                        {{ auth()->user()->role?->nama_role }}

                    </div>

                </div>

            </div>

        </header>


        {{-- =====================================================
        PAGE CONTENT
        ====================================================== --}}

        <section class="content">


            {{-- SUCCESS --}}
            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    <i
                        class="bi bi-check-circle me-2"
                    ></i>

                    {{ session('success') }}


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            {{-- ERROR --}}
            @if(session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >

                    <i
                        class="bi bi-exclamation-circle me-2"
                    ></i>

                    {{ session('error') }}


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            {{-- VALIDATION ERROR --}}
            @if($errors->any())

                <div
                    class="alert alert-danger"
                    role="alert"
                >

                    <div class="fw-bold mb-2">

                        Data belum dapat disimpan.

                    </div>


                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- PAGE CONTENT --}}
            @yield('content')


        </section>

    </main>


    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    @stack('scripts')

</body>

</html>