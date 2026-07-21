<x-app-layout title="Edit Produk" activeNav="transaksi" :backUrl="route('produk.index')">
    <div class="form-section mt-3">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Barang / Produk</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $produk->nama) }}" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-2 form-group">
                <div class="col-6">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required>
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-6">
                    <label class="form-label">Satuan</label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan', $produk->satuan) }}" required>
                    @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Harga Beli (Modal)</label>
                <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}" min="0" required>
                @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Harga Jual</label>
                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" min="0" required>
                @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                <textarea class="form-control" name="keterangan" rows="2">{{ old('keterangan', $produk->keterangan) }}</textarea>
            </div>

            <div class="mt-4 mb-4">
                <button type="submit" class="btn-primary-simbis">
                    <i class="bi bi-save"></i> Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
