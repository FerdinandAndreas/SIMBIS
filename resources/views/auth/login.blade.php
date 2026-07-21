<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMBIS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/simbis.css') }}">
</head>
<body>
    <div class="app-container justify-content-center p-4" style="padding-bottom: 20px !important;">
        <div class="text-center mb-4">
            <div class="d-inline-flex p-3 rounded-4 mb-3" style="background: var(--simbis-primary-gradient); color: #fff;">
                <i class="bi bi-shop fs-1"></i>
            </div>
            <h1 class="fs-4 fw-extrabold text-dark mb-1">SIMBIS</h1>
            <p class="text-muted small mb-0">Sistem Informasi Manajemen Bisnis</p>
        </div>

        <div class="card-custom p-4">
            <h2 class="fs-5 fw-bold text-dark mb-3">Masuk ke Akun</h2>

            @if(session('status'))
                <div class="alert alert-success small mb-3">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="position-relative">
                        <input type="email" name="email" class="form-control" value="{{ old('email', 'septiandevabaskara@gmail.com') }}" required autofocus placeholder="nama@email.com">
                        <i class="bi bi-envelope position-absolute end-0 top-50 translate-middle-y me-3 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        <i class="bi bi-lock position-absolute end-0 top-50 translate-middle-y me-3 text-muted"></i>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember_me">
                        <label class="form-check-label small text-muted" for="remember_me">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none fw-semibold">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary-simbis mb-3">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
        </div>

        <div class="text-center mt-3">
            <span class="text-muted small">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="small fw-bold text-primary text-decoration-none ms-1">Daftar sekarang</a>
        </div>
    </div>
</body>
</html>
