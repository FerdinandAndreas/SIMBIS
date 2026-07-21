<x-app-layout title="Akun & Pengaturan" activeNav="akun">
    <div class="px-4 mt-3 mb-4">
        @if(session('success'))
            <div class="alert alert-success small p-2 mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small p-2 mb-3">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Store Profile Card -->
        <div class="card-custom mb-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="menu-icon-badge mb-0" style="background-color: var(--badge-blue-bg); color: var(--badge-blue-color); width: 48px; height: 48px;">
                    <i class="bi bi-shop fs-4"></i>
                </div>
                <div>
                    <h2 class="fs-6 fw-bold text-dark mb-0">{{ Auth::user()->nama_toko }}</h2>
                    <span class="text-muted small">Pemilik: {{ Auth::user()->name }}</span>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <form action="{{ route('akun.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label class="form-label small">Nama Pemilik</label>
                    <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label small">Nama Toko / Usaha</label>
                    <input type="text" name="nama_toko" class="form-control form-control-sm" value="{{ old('nama_toko', Auth::user()->nama_toko) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label small">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100 fw-bold">
                    <i class="bi bi-save"></i> Simpan Profil Toko
                </button>
            </form>
        </div>

        <!-- Account Options -->
        <div class="card-custom p-0 overflow-hidden mb-4">
            <a href="{{ route('produk.index') }}" class="d-flex align-items-center justify-content-between p-3 text-decoration-none border-bottom text-dark">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-box-seam fs-5 text-secondary"></i>
                    <span class="fw-semibold">Master Data Produk</span>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </a>

            <!-- Change Password Modal Trigger -->
            <button class="w-100 text-start bg-white d-flex align-items-center justify-content-between p-3 border-0 border-bottom text-dark" data-bs-toggle="collapse" data-bs-target="#collapsePassword">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-lock fs-5 text-secondary"></i>
                    <span class="fw-semibold">Ganti Password</span>
                </div>
                <i class="bi bi-chevron-down text-muted"></i>
            </button>

            <div class="collapse p-3 bg-light border-bottom" id="collapsePassword">
                <form action="{{ route('akun.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label class="form-label small">Password Lama</label>
                        <input type="password" name="password_lama" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label small">Password Baru</label>
                        <input type="password" name="password" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label small">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-3 w-100 fw-bold">
                        Ubah Password
                    </button>
                </form>
            </div>

            <!-- Logout Button Form -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-100 text-start bg-white d-flex align-items-center justify-content-between p-3 border-0 text-danger fw-bold">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                        <span>Logout</span>
                    </div>
                    <i class="bi bi-chevron-right text-danger"></i>
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
