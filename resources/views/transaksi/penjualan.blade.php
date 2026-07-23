<x-app-layout title="Penjualan" activeNav="transaksi" :backUrl="route('transaksi.index')">
    <div class="form-section mt-3">
        @if(session('success'))
            <div class="alert alert-success small p-2 mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('transaksi.penjualan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nama Pembeli / Pelanggan <span class="text-muted fw-normal">(Opsional)</span></label>
                <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Bpk. Ahmad / Umum">
                @error('nama_pelanggan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Pilih Produk <span class="text-muted fw-normal">(Opsional)</span></label>
                <select class="form-select" id="product_select" name="product_id" onchange="onProductSelect(this)">
                    <option value="">-- Pilih dari Master Produk (Opsional) --</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}" data-nama="{{ $prod->nama }}" data-satuan="{{ $prod->satuan }}" data-hargajual="{{ $prod->harga_jual }}">
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
                <label class="form-label">Harga Jual Satuan (Rp)</label>
                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', 0) }}" min="0" required oninput="calcTotal()">
                @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Uang Bayar (Rp)</label>
                <input type="number" class="form-control @error('bayar') is-invalid @enderror" id="bayar" name="bayar" value="{{ old('bayar', 0) }}" min="0" required oninput="calcTotal()">
                @error('bayar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="summary-card mb-3">
                <div class="summary-row">
                    <span class="summary-label">Total Penjualan</span>
                    <span class="summary-val text-dark fs-6" id="total_val">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Bayar</span>
                    <span class="summary-val text-dark fs-6" id="bayar_val">Rp 0</span>
                </div>
                <div class="summary-row border-0">
                    <span class="summary-label">Kembalian</span>
                    <span class="summary-val text-profit fs-6 fw-bold" id="kembalian_val">Rp 0</span>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 mb-4">
                <button type="submit" class="btn-outline-simbis flex-grow-1">
                    Simpan
                </button>
                <button type="submit" name="cetak" value="1" class="btn-primary-simbis flex-grow-1">
                    Simpan & Cetak Struk
                </button>
            </div>
        </form>

        @if(isset($penjualans) && $penjualans->count() > 0)
            <div class="mt-4">
                <h3 class="fs-6 fw-bold text-muted mb-2">Riwayat Penjualan Terbaru</h3>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($penjualans as $p)
                    <form method="POST" action="{{ route('transaksi.penjualan.destroy', $p->id) }}" class="d-flex align-items-center w-100 mb-2">
                        @csrf
                        @method('DELETE')
                        <input type="checkbox" name="ids[]" value="{{ $p->id }}" class="form-check-input me-2">
                        <a href="{{ route('transaksi.struk', $p->id) }}" class="flex-grow-1 card-custom p-3 mb-0 d-flex justify-content-between align-items-center text-decoration-none">
                            <div>
                                <div class="fw-bold text-dark">{{ $p->nama_barang }} ({{ $p->jumlah }} {{ $p->satuan }})</div>
                                <div class="small text-muted">{{ $p->no_invoice }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary">Rp {{ number_format($p->total, 0, ',', '.') }}</div>
                                <div class="small text-muted">{{ $p->tanggal->format('d M Y') }}</div>
                            </div>
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Hapus transaksi ini?')"><i class="bi bi-trash"></i></button>
                    </form>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Batch Print Form -->
        <form method="POST" action="{{ route('transaksi.struk.batch') }}">
            @csrf
            @foreach($penjualans as $p)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ids[]" value="{{ $p->id }}" id="penjualan{{ $p->id }}">
                    <label class="form-check-label" for="penjualan{{ $p->id }}">
                        {{ $p->nama_barang }} ({{ $p->jumlah }} {{ $p->satuan }}) - Rp {{ number_format($p->total, 0, ',', '.') }}
                    </label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary mt-2">Print Selected</button>
        </form>
    </div>

    @push('scripts')
    <script>
        function onProductSelect(elem) {
            const opt = elem.options[elem.selectedIndex];
            if (opt && opt.value) {
                document.getElementById('nama_barang').value = opt.getAttribute('data-nama') || '';
                document.getElementById('satuan').value = opt.getAttribute('data-satuan') || 'pcs';
                document.getElementById('harga_jual').value = opt.getAttribute('data-hargajual') || 0;
                calcTotal();
            }
        }

        function calcTotal() {
            const qty = parseFloat(document.getElementById('jumlah').value) || 0;
            const price = parseFloat(document.getElementById('harga_jual').value) || 0;
            const bayar = parseFloat(document.getElementById('bayar').value) || 0;

            const total = qty * price;
            const kembalian = Math.max(0, bayar - total);

            document.getElementById('total_val').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('bayar_val').innerText = 'Rp ' + bayar.toLocaleString('id-ID');
            document.getElementById('kembalian_val').innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
        }

        document.addEventListener('DOMContentLoaded', calcTotal);
    </script>
    @endpush
</x-app-layout>
