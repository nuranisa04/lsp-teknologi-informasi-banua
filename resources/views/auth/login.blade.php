<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - LSP P3 Teknologi Informasi Banua</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --navy: #222222;
            --blue: #3b3b3b;
            --yellow: #f4cd00;
            --yellow-hover: #ddb900;
            --background: #f7f5ec;
            --white: #ffffff;
            --text: #282828;
            --muted: #737373;
            --border: #e9e5d8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }

        .login-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .showcase-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;
            text-align: center;
        }

        .showcase-brand-logo {
            width: 180px;
            height: 210px;
            margin-bottom: -24px;
            object-fit: contain;
        }

        .showcase-brand-caption {
            display: block;
            margin-bottom: 4px;
            color: rgba(255, 255, 255, .68);
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .showcase-brand-name {
            display: block;
            color: var(--white);
            font-family: "Arial Narrow", "Roboto Condensed", "Segoe UI", sans-serif;
            font-size: 21px;
            font-stretch: condensed;
            font-weight: 900;
            line-height: 1.2;
            text-transform: uppercase;
            text-align: center;
        }

        .login-main {
            flex: 1;
            display: grid;
            place-items: center;
            padding: 52px 24px;
        }

        .login-card {
            width: min(100%, 1040px);
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(390px, .95fr);
            overflow: hidden;
            border: 1px solid rgba(40, 40, 40, .06);
            border-radius: 22px;
            background: var(--white);
            box-shadow: 0 22px 60px rgba(40, 40, 40, .11);
        }

        .login-showcase {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 56px;
            border-left: 7px solid var(--yellow);
            background:
                radial-gradient(circle at 88% 82%, rgba(244, 205, 0, .11), transparent 26%),
                linear-gradient(145deg, #282828 0%, #202020 58%, #171717 100%);
            color: var(--white);
        }

        .login-showcase::before,
        .login-showcase::after {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
            content: "";
            pointer-events: none;
        }

        .login-showcase::before {
            width: 430px;
            height: 430px;
            right: -190px;
            top: -190px;
        }

        .login-showcase::after {
            width: 300px;
            height: 300px;
            right: -125px;
            top: -125px;
        }

        .showcase-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
            transform: translateY(-28px);
            text-align: center;
        }

        .showcase-title {
            margin: 0 0 16px;
            font-size: clamp(34px, 4vw, 48px);
            font-weight: 800;
            letter-spacing: -.04em;
            line-height: 1.08;
            text-align: center;
        }

        .showcase-description {
            max-width: 390px;
            margin: 0 auto;
            color: rgba(255, 255, 255, .72);
            font-size: 15px;
            line-height: 1.75;
        }

        .login-form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 54px 52px;
        }

        .form-title {
            margin: 0;
            color: var(--navy);
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -.035em;
        }

        .form-description {
            margin: 9px 0 30px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .login-form .form-label {
            margin-bottom: 8px;
            color: #373737;
            font-size: 13px;
            font-weight: 700;
        }

        .login-form .form-control {
            min-height: 52px;
            border-color: #e4e1d8;
            border-radius: 10px;
            color: var(--text);
            font-size: 14px;
        }

        .login-form .form-control::placeholder {
            color: #a0a0a0;
        }

        .login-form .form-control:focus {
            border-color: #d8bb17;
            box-shadow: 0 0 0 .22rem rgba(244, 205, 0, .18);
        }

        .login-form .input-group-text {
            min-width: 48px;
            justify-content: center;
            border-color: #e4e1d8;
            border-radius: 10px 0 0 10px;
            background: #fffdf5;
            color: #77715a;
        }

        .login-form .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .btn-login {
            min-height: 52px;
            border: 1px solid var(--yellow);
            border-radius: 10px;
            background: var(--yellow);
            color: var(--navy);
            font-size: 14px;
            font-weight: 800;
            transition: background-color .18s ease, border-color .18s ease, transform .18s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            border-color: var(--yellow-hover);
            background: var(--yellow-hover);
            color: var(--navy);
        }

        .btn-login:focus-visible {
            outline: 3px solid rgba(244, 205, 0, .42);
            outline-offset: 3px;
        }

        .login-footer {
            padding: 0 24px 22px;
            color: #89877f;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 800px) {
            .login-main {
                padding: 32px 20px;
            }

            .login-card {
                max-width: 560px;
                grid-template-columns: 1fr;
            }

            .login-showcase {
                min-height: auto;
                padding: 36px;
            }

            .showcase-content {
                max-width: 100%;
            }

            .showcase-title {
                max-width: 460px;
                font-size: 36px;
            }

            .showcase-description {
                max-width: 460px;
            }

            .login-form-panel {
                padding: 38px 36px;
            }
        }

        @media (max-width: 480px) {
            .login-main {
                padding: 22px 14px;
            }

            .login-card {
                border-radius: 16px;
            }

            .login-showcase {
                padding: 28px 24px;
            }

            .showcase-title {
                font-size: 31px;
            }

            .showcase-brand {
                gap: 8px;
                margin-bottom: 22px;
            }

            .showcase-brand-logo {
                width: 140px;
                height: 165px;
                margin-bottom: -18px;
            }

            .showcase-brand-name {
                font-size: 18px;
            }

            .showcase-brand-caption {
                font-size: 13px;
            }

            .showcase-description {
                font-size: 14px;
            }

            .login-form-panel {
                padding: 32px 24px;
            }

            .form-title {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>
    <div class="login-shell">
        <main class="login-main">
            <section class="login-card" aria-labelledby="login-title">
                <div class="login-showcase">
                    <div class="showcase-content">
                        <div class="showcase-brand">
                            <img
                                src="{{ asset('images/Logo-LSP-TIB.png') }}"
                                alt="Logo LSP Teknologi Informasi Banua"
                                class="showcase-brand-logo"
                            >
                            <span>
                                <span class="showcase-brand-caption">Lembaga Sertifikasi Profesi</span>
                                <span class="showcase-brand-name">Teknologi Informasi Banua</span>
                            </span>
                        </div>
                        <h1 class="showcase-title">Selamat Datang</h1>
                        <p class="showcase-description">
                            Kelola kerja sama mitra dengan lebih mudah, terstruktur, dan efisien.
                        </p>
                    </div>
                </div>

                <div class="login-form-panel">
                    <h2 class="form-title" id="login-title">Masuk ke akun</h2>
                    <p class="form-description">
                        Gunakan email dan password yang terdaftar untuk melanjutkan.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST" class="login-form">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope" aria-hidden="true"></i>
                                </span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="nama@email.com"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock" aria-hidden="true"></i>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100">
                            <i class="bi bi-box-arrow-in-right me-2" aria-hidden="true"></i>
                            Masuk
                        </button>
                    </form>

                </div>
            </section>
        </main>

    </div>
</body>

</html>
