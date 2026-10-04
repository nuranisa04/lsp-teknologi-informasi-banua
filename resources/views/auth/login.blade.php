<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login - LSP P3 Teknologi Informasi Banua
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
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

        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            color: var(--text);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: var(--background);
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 14px;
            background: var(--white);
        }

        .btn-login {
            background: var(--yellow);
            border-color: var(--yellow);
            color: var(--navy);
            font-weight: bold;
        }

        .btn-login:hover {
            background: var(--yellow-hover);
            border-color: var(--yellow-hover);
            color: var(--navy);
        }

        .logo-container {
            width: 125px;
            height: 125px;
            margin: 0 auto;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

    </style>

</head>


<body>

<div class="login-page">

    <div class="card shadow-lg login-card">

        <div class="card-body p-4 p-md-5">

            <div class="logo-container mb-4">
    <img
        src="{{ asset('images/Logo-LSP-TIB.png') }}"
        alt="Logo LSP P3 Teknologi Informasi Banua"
        class="logo-image"
    >
</div>


            <div class="text-center mb-4">

                <h4
                    class="fw-bold"
                    style="color: var(--navy);"
                >
                    LSP P3 Teknologi Informasi Banua
                </h4>

                <p class="text-muted">
                    Sistem Informasi Pengelolaan Kerja Sama Mitra
                </p>

            </div>


            @if($errors->any())

                <div class="alert alert-danger">

                    {{ $errors->first() }}

                </div>

            @endif


            <form
                action="{{ route('login.process') }}"
                method="POST"
            >

                @csrf

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        placeholder="Masukkan email"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-lg"
                        placeholder="Masukkan password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-login btn-lg w-100"
                >

                    Masuk

                </button>

            </form>


            <div class="text-center mt-4">

                <small class="text-muted">
                    PKL - Pengelolaan Data Calon Mitra
                </small>

            </div>

        </div>

    </div>

</div>

</body>

</html>