<x-app-layout title="Prive (Pengeluaran)" activeNav="transaksi" :backUrl="route('transaksi.index')">
    <div class="form-section mt-3">
        @if(session('success'))
            <div class="alert alert-success small p-2 mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('transaksi.prive.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" required>
                    <option value="Makan" {{ old('kategori') == 'Makan' ? 'selected' : '' }}>Makan</option>
                    <option value="Transportasi" {{ old('kategori') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                    <option value="Listrik & Air" {{ old('kategori') == 'Listrik & Air' ? 'selected' : '' }}>Listrik & Air</option>
                    <option value="Sewa Tempat" {{ old('kategori') == 'Sewa Tempat' ? 'selected' : '' }}>Sewa Tempat</option>
                    <option value="Lain-lain" {{ old('kategori') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                </select>
                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nominal (Rp)</label>
                <input type="number" class="form-control @error('nominal') is-invalid @enderror" name="nominal" value="{{ old('nominal') }}" placeholder="150000" min="1" required>
                @error('nominal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="2" placeholder="Contoh: Makan siang operasional toko">{{ old('keterangan') }}</textarea>
            </div>

            <div class="mt-4 mb-4">
                <button type="submit" class="btn-primary-simbis">
                    <i class="bi bi-save"></i> Simpan Prive
                </button>
            </div>
        </form>

        @if(isset($prives) && $prives->count() > 0)
            <div class="mt-4">
                <h3 class="fs-6 fw-bold text-muted mb-2">Riwayat Prive Terbaru</h3>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($prives as $pr)
                        <div class="card-custom p-3 mb-0 d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-bold text-danger">Rp {{ number_format($pr->nominal, 0, ',', '.') }}</div>
        <div class="small text-muted">{{ $pr->kategori }} - {{ $pr->keterangan ?? '-' }}</div>
    </div>
    <div class="small text-muted">{{ $pr->tanggal->format('d M Y') }}</div>
</div>
<form method="POST" action="{{ route('transaksi.prive.destroy', $pr->id) }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Hapus transaksi ini?')"><i class="bi bi-trash"></i></button>
</form>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
