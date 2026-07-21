<x-app-layout title="Master Produk" activeNav="transaksi" :backUrl="route('transaksi.index')">
    <div class="px-4 mt-3 mb-4">
        @if(session('success'))
            <div class="alert alert-success small p-2 mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fs-6 fw-bold text-dark mb-0">Daftar Barang / Produk</h2>
            <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm rounded-3 px-3 fw-bold">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
        </div>

        @if($products->isEmpty())
            <div class="text-center p-4 bg-white rounded-4 border">
                <i class="bi bi-box-seam text-muted fs-1 mb-2 d-block"></i>
                <p class="text-muted small mb-0">Belum ada produk. Tambahkan produk baru untuk memudahkan transaksi.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach($products as $p)
                    <div class="card-custom p-3 mb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark mb-1">{{ $p->nama }}</div>
                            <div class="small text-muted">
                                Stok: <strong class="{{ $p->stok > 5 ? 'text-success' : 'text-danger' }}">{{ $p->stok }} {{ $p->satuan }}</strong>
                            </div>
                            <div class="small text-muted">
                                Beli: <strong>Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</strong> | Jual: <strong class="text-primary">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-light btn-sm text-primary border">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $p->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm text-danger border">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
