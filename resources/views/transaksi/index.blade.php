<x-app-layout title="Transaksi" activeNav="transaksi">
    <div class="action-list mt-3">
        <!-- Master Produk Card -->
        <a href="{{ route('produk.index') }}" class="action-item" style="border-left: 4px solid var(--simbis-primary);">
            <div class="action-item-left">
                <div class="menu-icon-badge mb-0" style="background-color: var(--badge-blue-bg); color: var(--badge-blue-color);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="action-item-title">Master Data Produk</div>
                    <div class="action-item-desc">Kelola barang, stok, & harga jual/beli</div>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted fs-5"></i>
        </a>

        <!-- Input Modal Card -->
        <a href="{{ route('transaksi.modal') }}" class="action-item">
            <div class="action-item-left">
                <div class="menu-icon-badge mb-0" style="background-color: var(--badge-purple-bg); color: var(--badge-purple-color);">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <div class="action-item-title">Input Modal</div>
                    <div class="action-item-desc">Catat penambahan modal usaha</div>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted fs-5"></i>
        </a>

        <!-- Pembelian Card -->
        <a href="{{ route('transaksi.pembelian') }}" class="action-item">
            <div class="action-item-left">
                <div class="menu-icon-badge mb-0" style="background-color: var(--badge-emerald-bg); color: var(--badge-emerald-color);">
                    <i class="bi bi-cart-plus"></i>
                </div>
                <div>
                    <div class="action-item-title">Pembelian</div>
                    <div class="action-item-desc">Catat pembelian barang & tambah stok</div>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted fs-5"></i>
        </a>

        <!-- Penjualan Card -->
        <a href="{{ route('transaksi.penjualan') }}" class="action-item">
            <div class="action-item-left">
                <div class="menu-icon-badge mb-0" style="background-color: var(--badge-amber-bg); color: var(--badge-amber-color);">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div>
                    <div class="action-item-title">Penjualan</div>
                    <div class="action-item-desc">Catat hasil penjualan & cetak struk</div>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted fs-5"></i>
        </a>

        <!-- Prive Card -->
        <a href="{{ route('transaksi.prive') }}" class="action-item">
            <div class="action-item-left">
                <div class="menu-icon-badge mb-0" style="background-color: var(--badge-pink-bg); color: var(--badge-pink-color);">
                    <i class="bi bi-wallet-fill"></i>
                </div>
                <div>
                    <div class="action-item-title">Prive (Pengeluaran)</div>
                    <div class="action-item-desc">Catat pengeluaran diluar bisnis</div>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted fs-5"></i>
        </a>
    </div>
</x-app-layout>
