<x-app-layout title="Input Modal" activeNav="transaksi" :backUrl="route('transaksi.index')">
    <div class="form-section mt-3">
        @if(session('success'))
            <div class="alert alert-success small p-2 mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('transaksi.modal.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nominal Modal (Rp)</label>
                <input type="number" class="form-control @error('nominal') is-invalid @enderror" name="nominal" value="{{ old('nominal') }}" placeholder="20000000" min="1" required>
                @error('nominal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="2" placeholder="Contoh: Modal awal usaha">{{ old('keterangan') }}</textarea>
            </div>

            <div class="mt-4 mb-4">
                <button type="submit" class="btn-primary-simbis">
                    <i class="bi bi-save"></i> Simpan Modal
                </button>
            </div>
        </form>

        <!-- Riwayat Modal -->
        @if(isset($modals) && $modals->count() > 0)
            <div class="mt-4">
                <h3 class="fs-6 fw-bold text-muted mb-2">Riwayat Modal Terbaru</h3>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($modals as $m)
                        <div class="card-custom p-3 mb-0 d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-bold text-dark">Rp {{ number_format($m->nominal, 0, ',', '.') }}</div>
        <div class="small text-muted">{{ $m->keterangan ?? 'Modal Usaha' }}</div>
    </div>
    <div class="small text-muted">{{ $m->tanggal->format('d M Y') }}</div>
</div>
<form method="POST" action="{{ route('transaksi.modal.destroy', $m->id) }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Hapus modal ini?')"><i class="bi bi-trash"></i></button>
</form>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
