<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIMBIS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/simbis.css') }}">
</head>
<body>
    <div class="app-container justify-content-center p-4" style="padding-bottom: 20px !important;">
        <div class="text-center mb-3">
            <div class="d-inline-flex p-3 rounded-4 mb-2" style="background: var(--simbis-primary-gradient); color: #fff;">
                <i class="bi bi-shop fs-2"></i>
            </div>
            <h1 class="fs-4 fw-extrabold text-dark mb-1">SIMBIS</h1>
            <p class="text-muted small mb-0">Buat Akun Bisnis Baru</p>
        </div>

        <div class="card-custom p-4">
            @if($errors->any())
                <div class="alert alert-danger small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Pemilik</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Contoh: Septian Deva">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Toko / Usaha</label>
                    <input type="text" name="nama_toko" class="form-control" value="{{ old('nama_toko') }}" required placeholder="Contoh: UD PADI SAMUDRA">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                </div>

                <button type="submit" class="btn-primary-simbis mt-3 mb-2">
                    <i class="bi bi-person-plus"></i> Daftar Akun
                </button>
            </form>
        </div>

        <div class="text-center mt-3">
            <span class="text-muted small">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="small fw-bold text-primary text-decoration-none ms-1">Masuk</a>
        </div>
    </div>
</body>
</html>
