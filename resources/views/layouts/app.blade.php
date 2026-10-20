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

            --navy: #222222;

            --blue: #3B3B3B;

            --yellow: #F4CD00;

            --yellow-hover: #DDB900;

            --background: #F7F5EC;

            --white: #FFFFFF;

            --text: #282828;

            --border: #E9E5D8;

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
                Inter,
                "Segoe UI",
                Arial,
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
                linear-gradient(
                    180deg,
                    #243449 0%,
                    var(--navy) 42%,
                    #1B2635 100%
                );

            box-shadow:
                8px 0 28px
                rgba(32,43,60,.12);

            z-index: 1000;

            overflow-y: auto;

        }


        /*
        |--------------------------------------------------------------------------
        | BRAND
        |--------------------------------------------------------------------------
        */

        .brand {

            padding: 20px 14px;

            color:
                var(--white);

            border-bottom:
                1px solid
                rgba(255,255,255,.12);

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.045),
                    transparent 72%
                );

        }


        .brand-wrapper {

            display: flex;

            align-items: center;

            gap: 4px;

        }


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .brand-logo {

            width: 66px;

            height: 66px;

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

            font-size: 12px;

            color:
                rgba(255,255,255,.76);

            margin:
                3px 0 0 0;

            white-space:
                nowrap;

        }


        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */

        .sidebar-menu {

            padding:
                20px 0;

            padding-bottom:
                180px;

        }


        .sidebar-menu-title {

            padding:
                8px 22px;

            font-size:
                11px;

            color:
                rgba(255,255,255,.52);

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
                rgba(255,255,255,.84);

            margin:
                5px 12px;

            padding:
                12px 14px;

            border-radius:
                10px;

            text-decoration:
                none;

            transition:
                background-color .2s ease,
                color .2s ease,
                transform .2s ease;

        }


        .sidebar .nav-link i {

            width:
                24px;

            font-size:
                18px;

            opacity:
                .88;

        }


        .sidebar .nav-link:hover {

            background:
                rgba(255,255,255,.09);

            color:
                var(--white);

            transform:
                translateX(2px);

        }


        .sidebar .nav-link.active {

            background:
                linear-gradient(
                    110deg,
                    var(--yellow),
                    #F7D94C
                );

            color:
                var(--navy);

            font-weight:
                700;

            box-shadow:
                0 7px 18px
                rgba(242,200,17,.2),
                inset 3px 0 0
                rgba(255,255,255,.6);

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
                rgba(18,27,40,.72);

            backdrop-filter:
                blur(12px);

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

            min-height:
                78px;

            background:
                var(--white);

            padding:
                0 32px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            border-bottom:
                1px solid
                var(--border);

            box-shadow:
                0 4px 16px
                rgba(32,43,60,.045);

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

            letter-spacing:
                -.2px;

        }


        .topbar-heading {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

        }


        .topbar-page-icon {

            width:
                40px;

            height:
                40px;

            display:
                grid;

            place-items:
                center;

            color:
                var(--navy);

            background:
                #FFF5D0;

            border-radius:
                13px;

            font-size:
                17px;

        }

        .topbar-user {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

            padding:
                8px 14px 8px 9px;

            background:
                #F8FAFC;

            border:
                1px solid
                #E9EDF2;

            border-radius:
                14px;

        }


        .topbar-user-icon {

            width:
                42px;

            height:
                42px;

            border-radius:
                50%;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                linear-gradient(145deg, #315A7D, #202B3C);

            color:
                #FFFFFF;

            font-size:
                16px;

            position:
                relative;

        }

        .topbar-user-photo {

            width:
                42px;

            height:
                42px;

            border-radius:
                50%;

            object-fit:
                cover;

        }


        .topbar-user-info {

            line-height:
                1.2;

            display:
                flex;

            flex-direction:
                column;

            gap:
                4px;

        }


        .topbar-user-name {

            color:
                var(--navy);

            font-size:
                12px;

            font-weight:
                700;

            max-width:
                190px;

            overflow:
                hidden;

            text-overflow:
                ellipsis;

            white-space:
                nowrap;

        }


        .topbar-user-role {

            color:
                #6B7280;

            font-size:
                11px;

            letter-spacing:
                .15px;

        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .content {

            padding:
                32px;

        }


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        .dashboard-hero {

            position:
                relative;

            min-height:
                174px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                24px;

            padding:
                28px 32px;

            margin-bottom:
                24px;

            overflow:
                hidden;

            color:
                var(--navy);

            background:
                #FFFFFF;

            border:
                1px solid
                #E7E9EC;

            border-left:
                5px solid
                var(--yellow);

            border-radius:
                8px 18px 18px 8px;

            box-shadow:
                0 8px 24px
                rgba(32,43,60,.055);

        }


        .dashboard-hero-content {

            position:
                relative;

            z-index:
                1;

        }


        .dashboard-hero-eyebrow {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            margin-bottom:
                10px;

            color:
                #9A7600;

            font-size:
                11px;

            font-weight:
                700;

            letter-spacing:
                .12em;

            text-transform:
                uppercase;

        }


        .dashboard-hero-eyebrow i {

            font-size:
                13px;

        }


        .dashboard-hero-title {

            margin:
                0;

            color:
                var(--navy);

            font-size:
                clamp(24px, 3vw, 32px);

            font-weight:
                750;

            letter-spacing:
                -.035em;

        }


        .dashboard-hero-description {

            max-width:
                560px;

            margin:
                8px 0 0;

            color:
                #697586;

            font-size:
                14px;

            line-height:
                1.6;

        }


        .dashboard-hero-art {

            position:
                relative;

            z-index:
                1;

            width:
                112px;

            height:
                112px;

            flex:
                0 0 112px;

            display:
                grid;

            place-items:
                center;

            color:
                #FFE783;

            background:
                linear-gradient(145deg, #243449, #315A7D);

            border:
                1px solid
                rgba(49,90,125,.16);

            border-radius:
                30px;

            box-shadow:
                0 12px 24px
                rgba(32,43,60,.16);

        }


        .dashboard-hero-art i {

            font-size:
                48px;

        }


        .dashboard-section-heading {

            color:
                var(--navy);

            font-size:
                17px;

            font-weight:
                700;

            letter-spacing:
                -.015em;

        }


        .dashboard-stat-card {

            position:
                relative;

            overflow:
                hidden;

            min-height:
                126px;

            border:
                1px solid
                rgba(228,232,238,.9);

            transition:
                transform .2s ease,
                box-shadow .2s ease;

        }


        .dashboard-stat-card::before {

            position:
                absolute;

            top:
                0;

            right:
                0;

            left:
                0;

            height:
                3px;

            content:
                "";

            background:
                var(--stat-accent, var(--blue));

        }


        .dashboard-stat-card:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 12px 24px
                rgba(32,43,60,.09);

        }


        .dashboard-stat-card .card-body {

            padding:
                1.15rem 1.2rem;

        }


        .dashboard-stat-label {

            color:
                #657184;

            font-size:
                13px;

            font-weight:
                500;

        }


        .dashboard-stat-value {

            margin:
                8px 0 0;

            color:
                var(--navy);

            font-size:
                30px;

            font-weight:
                750;

            line-height:
                1;

            letter-spacing:
                -.04em;

        }


        .dashboard-stat-icon {

            width:
                46px;

            height:
                46px;

            display:
                grid;

            place-items:
                center;

            color:
                var(--stat-accent, var(--blue));

            background:
                var(--stat-surface, #EEF3F7);

            border:
                1px solid
                var(--stat-border, #E5ECF2);

            border-radius:
                14px;

        }


        .dashboard-stat-icon i {

            font-size:
                20px;

        }


        .dashboard-stat-mitras {

            --stat-accent: #315A7D;
            --stat-surface: #EEF3F7;
            --stat-border: #E1EAF1;

        }


        .dashboard-stat-prospects {

            --stat-accent: #A97900;
            --stat-surface: #FFF7DD;
            --stat-border: #F5EAC4;

        }


        .dashboard-stat-verified {

            --stat-accent: #21845A;
            --stat-surface: #EAF7F0;
            --stat-border: #D8EEE2;

        }


        .dashboard-stat-pics {

            --stat-accent: #6557A5;
            --stat-surface: #F1EFFA;
            --stat-border: #E5E1F3;

        }


        .dashboard-table-card {

            border:
                1px solid
                rgba(228,232,238,.9);

        }


        .dashboard-table-card .card-body {

            padding:
                1.4rem;

        }


        .dashboard-table-heading {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

        }


        .dashboard-table-heading-icon {

            width:
                42px;

            height:
                42px;

            flex:
                0 0 42px;

            display:
                grid;

            place-items:
                center;

            color:
                #315A7D;

            background:
                #EEF3F7;

            border-radius:
                13px;

        }


        .dashboard-table-heading-icon i {

            font-size:
                18px;

        }


        .dashboard-table-card .table thead th {

            padding:
                12px 14px;

            color:
                #657184;

            background:
                #F7F9FB;

            border-top:
                1px solid
                var(--border);

            border-bottom:
                1px solid
                var(--border);

            font-size:
                11px;

            font-weight:
                700;

            letter-spacing:
                .055em;

            text-transform:
                uppercase;

        }


        .dashboard-table-card .table tbody td {

            padding:
                15px 14px;

            color:
                #3F4B5B;

            border-color:
                #EDF0F3;

            font-size:
                13px;

        }


        .dashboard-mitra-mark {

            width:
                38px;

            height:
                38px;

            flex:
                0 0 38px;

            display:
                grid;

            place-items:
                center;

            color:
                #315A7D;

            background:
                #EEF3F7;

            border-radius:
                11px;

        }


        .dashboard-mitra-mark i {

            font-size:
                16px;

        }


        .dashboard-mitra-name {

            color:
                var(--navy);

            font-size:
                13px;

            font-weight:
                650;

        }


        .dashboard-table-card .badge {

            padding:
                .45em .75em;

            border-radius:
                999px;

            font-size:
                11px;

            font-weight:
                600;

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

            font-size:
                30px;

            font-weight:
                750;

            letter-spacing:
                -.035em;

        }


        .page-title + .text-muted {

            margin:
                5px 0 0;

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
                rgba(32,43,60,.06);

        }


        .card-body {

            padding:
                1.25rem;

        }


        .card h2.fw-bold {

            margin:
                6px 0 0;

            color:
                var(--navy);

            font-size:
                1.75rem;

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


        .btn-lsp.btn-save {

            display: inline-flex;

            min-height: 44px;

            align-items: center;

            justify-content: center;

            gap: 9px;

            padding: 9px 18px;

            border-radius: 11px;

            box-shadow:
                0 4px 10px rgba(204, 170, 0, .18);

            transition:
                background-color .18s ease,
                box-shadow .18s ease,
                transform .18s ease;

        }


        .btn-lsp.btn-save:hover {

            transform: translateY(-1px);

            box-shadow:
                0 7px 15px rgba(120, 99, 0, .2);

        }


        .btn-lsp.btn-save:active {

            transform: translateY(0);

            box-shadow:
                0 2px 5px rgba(120, 99, 0, .16);

        }


        .btn-lsp.btn-save:focus-visible {

            outline: 3px solid rgba(244, 205, 0, .38);

            outline-offset: 2px;

        }


        .btn-lsp.btn-save > .bi-check2-circle {

            display: inline-grid;

            width: 25px;

            height: 25px;

            flex: 0 0 25px;

            place-items: center;

            border-radius: 8px;

            background: rgba(34, 34, 34, .09);

            font-size: 15px;

        }


        .btn-back {

            display: inline-flex;

            min-height: 42px;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 9px 16px;

            border: 1px solid #e8dda9;

            border-radius: 12px;

            background:
                linear-gradient(135deg, #fffdf5, #fff9df);

            box-shadow:
                0 2px 7px rgba(80, 67, 20, .07);

            color: #625414;

            font-weight: 600;

            text-decoration: none;

            white-space: nowrap;

            transition:
                background-color .18s ease,
                border-color .18s ease,
                box-shadow .18s ease,
                color .18s ease,
                transform .18s ease;

        }


        .btn-back:hover {

            transform: translateY(-1px);

            border-color: #d8c24e;

            background:
                linear-gradient(135deg, #fff9df, #fff1ad);

            box-shadow:
                0 5px 12px rgba(80, 67, 20, .12);

            color: #443907;

        }


        .btn-back:active {

            transform: translateY(0);

            background: #f9e89b;

        }


        .btn-back:focus-visible {

            outline: 3px solid rgba(244, 205, 0, .35);

            outline-offset: 2px;

        }


        .btn-back .bi-arrow-left {

            transition: transform .18s ease;

        }


        .btn-back:hover .bi-arrow-left {

            transform: translateX(-2px);

        }


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


        .btn-warning:hover,
        .btn-warning:active {

            background:
                var(--yellow-hover);

            border-color:
                var(--yellow-hover);

            color:
                var(--navy);

        }


        .btn-outline-primary {

            color:
                var(--navy);

            border-color:
                #CBD3DE;

            background:
                var(--white);

            font-weight:
                600;

        }


        .btn-outline-primary:hover,
        .btn-outline-primary:active {

            color:
                var(--white);

            border-color:
                var(--navy);

            background:
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
                rgba(242,200,17,.3);

        }


        .bg-warning {

            background-color:
                var(--yellow) !important;

        }


        .badge.bg-warning {

            color:
                #665200 !important;

            background-color:
                #FFF2B8 !important;

            font-weight:
                600;

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
                #F6F8FA;

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
                #FFF8CC;

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
                rgba(255,255,255,.22);

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


            .sidebar-menu {

                display:
                    flex;

                flex-wrap:
                    wrap;

                align-items:
                    center;

                gap:
                    2px 4px;

                padding:
                    14px 8px;

            }


            .sidebar-menu-title {

                width:
                    100%;

            }


            .sidebar .nav-link {

                flex:
                    1 1 190px;

                max-width:
                    260px;

            }


            .sidebar-user {

                position:
                    static;

                display:
                    flex;

                align-items:
                    center;

                justify-content:
                    space-between;

                gap:
                    16px;

            }


            .logout-button {

                width:
                    180px;

                flex:
                    0 0 180px;

                margin-top:
                    0;

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
                    24px;

            }

        }


        @media (max-width: 576px) {

            .topbar {

                padding:
                    0 16px;

            }

            .topbar-title {

                font-size:
                    15px;

            }

            .topbar-page-icon {

                width:
                    36px;

                height:
                    36px;

                border-radius:
                    11px;

            }

            .topbar-user {

                padding:
                    6px;

                border-radius:
                    12px;

            }

            .topbar-user-icon {

                width:
                    38px;

                height:
                    38px;

            }

            .topbar-user-photo {

                width:
                    38px;

                height:
                    38px;

            }


            .topbar-user-info {

                display:
                    none;

            }


            .content {

                padding:
                    16px;

            }


            .brand-logo {

                width:
                    56px;

                height:
                    56px;

            }


            .dashboard-hero {

                min-height:
                    156px;

                padding:
                    22px;

                border-radius:
                    8px 15px 15px 8px;

            }


            .dashboard-hero-description {

                max-width:
                    290px;

                font-size:
                    13px;

            }


            .dashboard-hero-art {

                width:
                    64px;

                height:
                    64px;

                flex-basis:
                    64px;

                border-radius:
                    19px;

            }


            .dashboard-hero-art i {

                font-size:
                    30px;

            }


            .dashboard-table-card .card-body {

                padding:
                    1rem;

            }


            .dashboard-table-card .card-body > .d-flex {

                align-items:
                    flex-start !important;

                flex-wrap:
                    wrap;

            }


            .dashboard-table-card .card-body > .d-flex > .btn {

                margin-left:
                    54px;

            }


            .dashboard-table-card .table {

                min-width:
                    660px;

            }

        }


        @media (max-width: 420px) {

            .sidebar-user {

                align-items:
                    stretch;

                flex-direction:
                    column;

            }


            .logout-button {

                width:
                    100%;

                flex:
                    0 0 auto;

            }


            .dashboard-hero {

                padding:
                    20px 18px;

            }


            .dashboard-hero-art {

                width:
                    50px;

                height:
                    50px;

                flex-basis:
                    50px;

                border-radius:
                    15px;

            }


            .dashboard-hero-art i {

                font-size:
                    24px;

            }

        }

    </style>

    <style>
        body {
            background: var(--background);
            color: var(--text);
        }

        body::before {
            position: fixed;
            z-index: 1100;
            top: 0;
            right: 0;
            left: 0;
            height: 6px;
            background: var(--yellow);
            content: "";
            pointer-events: none;
        }

        .sidebar {
            top: 102px;
            min-height: calc(100vh - 102px);
            background: linear-gradient(180deg, #282828 0%, #202020 58%, #171717 100%);
            box-shadow: none;
        }

        .brand {
            position: fixed;
            top: 6px;
            right: 0;
            left: 0;
            z-index: 950;
            height: 96px;
            min-height: 96px;
            display: flex;
            align-items: center;
            padding: 10px 10px;
            border-bottom: 0;
            background: #fff;
            overflow: visible;
        }

        .brand::before {
            content: none;
        }

        .sidebar-menu {
            padding-top: 22px;
        }

        .sidebar-menu-title {
            color: rgba(255, 255, 255, .52);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .84);
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .09);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: var(--yellow);
            color: #202020;
        }

        .brand-wrapper {
            width: max-content;
            min-width: 0;
            flex: 0 0 auto;
            gap: 6px;
        }

        .brand-logo {
            width: 56px;
            height: 64px;
            flex: 0 0 56px;
        }

        .brand-text {
            display: flex;
            min-width: max-content;
            flex: 0 0 auto;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
            line-height: 1;
            overflow: visible;
        }

        .brand-kicker {
            margin: 0;
            color: #252525;
            font-family: "Arial Narrow", Arial, sans-serif;
            font-size: 12px;
            font-stretch: condensed;
            font-weight: 700;
            letter-spacing: -.02em;
            line-height: 1;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .brand-title {
            margin: 0;
            color: #111;
            font-family: Impact, "Arial Narrow", Arial, sans-serif;
            font-size: 19px;
            font-stretch: condensed;
            font-weight: 400;
            letter-spacing: 0;
            line-height: 1;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .brand-title::before {
            display: block;
            margin: 3px 0 3px;
            border-top: 3px solid #111;
            border-radius: 3px;
            content: "";
        }

        @media (max-width: 991px) {
            .sidebar {
                position: relative;
                top: auto;
                width: 100%;
                min-height: auto;
                margin-top: 102px;
            }

            .main {
                margin-left: 0;
                padding-top: 0;
            }

            .topbar {
                position: static;
                z-index: auto;
                background: #fff;
            }
        }

        .topbar {
            justify-content: flex-end;
        }

        .sidebar .nav-link.active i {
            color: #202020;
        }

        .sidebar-user {
            display: block;
            background: rgba(12, 12, 12, .72);
            border-top-color: rgba(255, 255, 255, .1);
        }

        .sidebar-user .logout-button {
            margin-top: 0;
        }

        .sidebar-user-icon {
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }

        .sidebar-user-name {
            color: #fff;
        }

        .sidebar-user-role {
            color: rgba(255, 255, 255, .65);
        }

        .logout-button .btn-outline-light {
            border-color: rgba(255, 255, 255, .36);
            border-radius: 8px;
            color: #fff;
        }

        .logout-button .btn-outline-light:hover {
            border-color: var(--yellow);
            background: var(--yellow);
            color: #202020;
        }

        .main {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            padding-top: 102px;
        }

        .topbar {
            height: 96px;
            min-height: 96px;
            flex: 0 0 96px;
            position: fixed;
            top: 6px;
            right: 0;
            left: 260px;
            z-index: 960;
            padding: 0 34px;
            border-top: 0;
            background: transparent;
            box-shadow: none;
        }

        .topbar-heading {
            gap: 15px;
        }

        .topbar-title {
            display: flex;
            flex-direction: column;
            gap: 3px;
            color: #242424;
            font-size: 18px;
            font-weight: 750;
            line-height: 1.2;
        }

        .topbar-kicker {
            color: #9a7c00;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .15em;
            line-height: 1;
            text-transform: uppercase;
        }

        .topbar-page-icon {
            width: 46px;
            height: 46px;
            border: 1px solid #efda68;
            background: linear-gradient(145deg, #ffdf36, var(--yellow));
            color: #202020;
            border-radius: 14px;
            box-shadow: 0 5px 12px rgba(204, 170, 0, .16);
        }

        .topbar-user {
            border-color: #eee8d5;
            background: #fffdf5;
            border-radius: 11px;
        }

        .topbar-user-link {
            color: inherit;
            text-decoration: none;
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .topbar-user-link:hover {
            color: inherit;
            border-color: #e3c400;
            box-shadow: 0 5px 14px rgba(24, 24, 24, .08);
            transform: translateY(-1px);
        }

        .topbar-user-link:focus-visible {
            outline: 3px solid rgba(244, 205, 0, .55);
            outline-offset: 3px;
        }

        .content {
            width: 100%;
            flex: 1;
            padding: 32px;
        }

        .dashboard-hero {
            min-height: 228px;
            padding: 38px 42px;
            border: 0;
            border-left: 7px solid var(--yellow);
            border-radius: 4px 18px 18px 4px;
            background:
                radial-gradient(ellipse at 82% 20%, rgba(255, 255, 255, .08), transparent 32%),
                linear-gradient(115deg, #202020 0%, #292929 68%, #33312a 100%);
            box-shadow: 0 14px 34px rgba(24, 24, 24, .14);
            color: #fff;
        }

        .dashboard-hero-eyebrow {
            color: var(--yellow);
            letter-spacing: .14em;
        }

        .dashboard-hero-title {
            color: #fff;
            font-size: clamp(28px, 3.3vw, 40px);
            letter-spacing: -.04em;
        }

        .dashboard-hero-description {
            color: rgba(255, 255, 255, .76);
            font-size: 15px;
        }

        .dashboard-hero-art {
            width: 128px;
            height: 128px;
            flex-basis: 128px;
            border: 1px solid rgba(244, 205, 0, .55);
            border-radius: 50%;
            background: var(--yellow);
            box-shadow: 0 0 0 12px rgba(244, 205, 0, .09);
            color: #202020;
        }

        .dashboard-hero-art i {
            font-size: 54px;
        }

        .dashboard-stat-card,
        .dashboard-table-card,
        .card {
            border: 1px solid #ece8dc;
            border-radius: 13px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(38, 34, 20, .045);
        }

        .dashboard-stat-card::before {
            height: 4px;
            background: var(--yellow);
        }

        .dashboard-stat-value,
        .dashboard-section-heading,
        .dashboard-mitra-name,
        .page-title {
            color: #222;
        }

        .dashboard-stat-mitras,
        .dashboard-stat-prospects,
        .dashboard-stat-verified,
        .dashboard-stat-pics {
            --stat-accent: #292929;
            --stat-surface: #fff8d9;
            --stat-border: #f1e4a8;
        }

        .dashboard-stat-icon,
        .dashboard-table-heading-icon,
        .dashboard-mitra-mark {
            border-radius: 11px;
        }

        .dashboard-table-heading-icon,
        .dashboard-mitra-mark {
            background: #fff7d4;
            color: #302900;
        }

        .dashboard-table-card .table thead th,
        .table thead th {
            background: #fff9df;
            color: #5f5112;
        }

        .dashboard-table-card .table tbody tr:hover,
        .table-hover tbody tr:hover {
            --bs-table-accent-bg: #fffdf5;
        }

        .page-title {
            font-size: clamp(25px, 2.5vw, 32px);
        }

        .btn-lsp,
        .btn-warning {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(204, 170, 0, .12);
        }

        .btn-outline-primary {
            border-radius: 8px;
        }

        .form-control,
        .form-select {
            min-height: 42px;
            border-color: #dedbd1;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #d5b700;
            box-shadow: 0 0 0 .2rem rgba(244, 205, 0, .2);
        }

        @media (max-width: 991px) {
            .sidebar {
                box-shadow: 0 6px 22px rgba(25, 25, 25, .1);
            }

            .sidebar-menu {
                min-height: auto;
            }

            .main {
                min-height: auto;
                padding-top: 0;
            }

            .topbar {
                position: relative;
                top: auto;
                right: auto;
                left: auto;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding-right: 16px;
                padding-left: 16px;
            }

            .topbar-title {
                font-size: 14px;
            }

            .topbar-kicker {
                font-size: 8px;
                letter-spacing: .11em;
            }

            .content {
                padding: 18px 16px;
            }

            .dashboard-hero {
                min-height: 190px;
                padding: 26px 22px;
                border-radius: 4px 14px 14px 4px;
            }

            .dashboard-hero-art {
                width: 68px;
                height: 68px;
                flex-basis: 68px;
                box-shadow: 0 0 0 7px rgba(244, 205, 0, .09);
            }

            .dashboard-hero-art i {
                font-size: 30px;
            }

        }
    </style>

    @stack('styles')

</head>


<body>


    {{-- BRAND HEADER --}}
    <div class="brand">

        <div class="brand-wrapper">

            <div class="brand-logo">
                <img
                    src="{{ asset('images/Logo-LSP-TIB.png') }}"
                    alt="Logo LSP P3 Teknologi Informasi Banua"
                >
            </div>

            <div class="brand-text">
                <p class="brand-kicker">Lembaga Sertifikasi Profesi</p>
                <p class="brand-title">
                    Teknologi Informasi Banua
                </p>
            </div>

        </div>

    </div>


    {{-- =========================================================
    SIDEBAR
    ========================================================== --}}

    <aside class="sidebar">


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


            {{-- DATA MITRA --}}
            <a
                href="{{ route('mitra.index') }}"
                class="nav-link
                    {{ request()->routeIs('mitra.*')
                        ? 'active'
                        : '' }}"
            >

                <i class="bi bi-building me-2"></i>

                <span>
                    Data Mitra
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

            @php
                $topbarUser = auth()->user();
                $topbarDisplayName = filled($topbarUser->nama)
                    ? $topbarUser->nama
                    : ($topbarUser->isAdmin()
                        ? 'Admin'
                        : ($topbarUser->isPimpinan()
                            ? 'Pimpinan'
                            : ($topbarUser->role?->nama_role ?? 'Pengguna')));
            @endphp

            {{-- USER TOPBAR --}}
            <a
                href="{{ route('profile.show') }}"
                class="topbar-user topbar-user-link"
                aria-label="Buka profil {{ $topbarDisplayName }}"
            >


                <div class="topbar-user-icon">
                    <img
                        id="topbarProfilePhoto"
                        src="{{ auth()->user()->foto_profile ? asset('storage/' . auth()->user()->foto_profile) : '' }}"
                        alt=""
                        class="topbar-user-photo"
                        @if (!auth()->user()->foto_profile) hidden @endif
                    >
                    <i
                        id="topbarProfileFallback"
                        class="bi bi-person-fill"
                        @if (auth()->user()->foto_profile) hidden @endif
                    ></i>

                </div>


                <div class="topbar-user-info">

                    <div class="topbar-user-name">

                        {{ $topbarDisplayName }}

                    </div>

                    @if(filled($topbarUser->nama) && $topbarUser->role?->nama_role !== $topbarUser->nama)
                        <div class="topbar-user-role">
                            {{ $topbarUser->role?->nama_role }}
                        </div>
                    @endif

                </div>

            </a>

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