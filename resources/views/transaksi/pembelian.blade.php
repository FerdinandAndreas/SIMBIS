<x-app-layout title="Pembelian" activeNav="transaksi" :backUrl="route('transaksi.index')">
    <div class="form-section mt-3">
        @if(session('success'))
            <div class="alert alert-success small p-2 mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('transaksi.pembelian.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Pilih Produk <span class="text-muted fw-normal">(Opsional)</span></label>
                <select class="form-select" id="product_select" name="product_id" onchange="onProductSelect(this)">
                    <option value="">-- Pilih dari Master Produk (Opsional) --</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}" data-nama="{{ $prod->nama }}" data-satuan="{{ $prod->satuan }}" data-hargabeli="{{ $prod->harga_beli }}">
                            {{ $prod->nama }} (Stok: {{ $prod->stok }} {{ $prod->satuan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required placeholder="Contoh: Beras Premium 25kg">
                @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Supplier <span class="text-muted fw-normal">(Opsional)</span></label>
                <input type="text" class="form-control" name="supplier" value="{{ old('supplier') }}" placeholder="Nama Supplier / Toko Grosir">
            </div>

            <div class="row g-2 form-group">
                <div class="col-6">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required oninput="calcTotal()">
                    @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-6">
                    <label class="form-label">Satuan</label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', 'pcs') }}" required>
                    @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Harga Beli Satuan (Rp)</label>
                <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', 0) }}" min="0" required oninput="calcTotal()">
                @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group p-3 rounded-3" style="background-color: var(--badge-emerald-bg);">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="color: var(--badge-emerald-color);">Total Pembelian</span>
                    <span class="fs-5 fw-bold" style="color: var(--badge-emerald-color);" id="total_display">Rp 0</span>
                </div>
            </div>

            <div class="mt-4 mb-4">
                <button type="submit" class="btn-primary-simbis">
                    <i class="bi bi-save"></i> Simpan Pembelian
                </button>
            </div>
        </form>

        @if(isset($pembelians) && $pembelians->count() > 0)
            <div class="mt-4">
                <h3 class="fs-6 fw-bold text-muted mb-2">Riwayat Pembelian Terbaru</h3>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($pembelians as $p)
                        <div class="card-custom p-3 mb-0 d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-bold text-dark">{{ $p->nama_barang }} ({{ $p->jumlah }} {{ $p->satuan }})</div>
        <div class="small text-muted">Supplier: {{ $p->supplier ?? '-' }}</div>
    </div>
    <div class="text-end">
        <div class="fw-bold text-emerald text-success">Rp {{ number_format($p->total, 0, ',', '.') }}</div>
        <div class="small text-muted">{{ $p->tanggal->format('d M Y') }}</div>
    </div>
</div>
<form method="POST" action="{{ route('transaksi.pembelian.destroy', $p->id) }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Hapus transaksi ini?')"><i class="bi bi-trash"></i></button>
</form>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function onProductSelect(elem) {
            const opt = elem.options[elem.selectedIndex];
            if (opt && opt.value) {
                document.getElementById('nama_barang').value = opt.getAttribute('data-nama') || '';
                document.getElementById('satuan').value = opt.getAttribute('data-satuan') || 'pcs';
                document.getElementById('harga_beli').value = opt.getAttribute('data-hargabeli') || 0;
                calcTotal();
            }
        }

        function calcTotal() {
            const qty = parseFloat(document.getElementById('jumlah').value) || 0;
            const price = parseFloat(document.getElementById('harga_beli').value) || 0;
            const total = qty * price;
            document.getElementById('total_display').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.addEventListener('DOMContentLoaded', calcTotal);
    </script>
    @endpush
</x-app-layout>
