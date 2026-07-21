<x-app-layout title="Beranda" activeNav="beranda">
    @php
        $summary = $summary ?? [
            'saldo_usaha' => 0,
            'laba_bulan_ini' => 0,
            'total_modal' => 0,
            'total_pembelian' => 0,
            'total_penjualan' => 0,
            'total_prive' => 0,
            'laba_bersih' => 0,
        ];
    @endphp

    <!-- Saldo Usaha Hero Card -->
    <div class="card-hero">
        <div class="label">
            <span>Saldo Usaha</span>
            <i class="bi bi-eye-slash cursor-pointer"></i>
        </div>
        <div class="balance">Rp {{ number_format($summary['saldo_usaha'], 0, ',', '.') }}</div>
        <div class="sub-badge">
            <span>Laba Bulan Ini</span>
            <strong>Rp {{ number_format($summary['laba_bulan_ini'], 0, ',', '.') }}</strong>
        </div>
    </div>

    <!-- Section Title: Menu Transaksi -->
    <div class="px-4 mb-2">
        <h2 class="fs-6 fw-bold text-secondary mb-0">Menu Transaksi</h2>
    </div>

    <!-- Menu Transaksi 2x2 Grid -->
    <div class="menu-grid">
        <a href="{{ route('transaksi.modal') }}" class="menu-card">
            <div class="menu-icon-badge" style="background-color: var(--badge-purple-bg); color: var(--badge-purple-color);">
                <i class="bi bi-wallet2"></i>
            </div>
            <span class="menu-title">Modal</span>
        </a>

        <a href="{{ route('transaksi.pembelian') }}" class="menu-card">
            <div class="menu-icon-badge" style="background-color: var(--badge-emerald-bg); color: var(--badge-emerald-color);">
                <i class="bi bi-cart-plus"></i>
            </div>
            <span class="menu-title">Pembelian</span>
        </a>

        <a href="{{ route('transaksi.penjualan') }}" class="menu-card">
            <div class="menu-icon-badge" style="background-color: var(--badge-amber-bg); color: var(--badge-amber-color);">
                <i class="bi bi-bag-check"></i>
            </div>
            <span class="menu-title">Penjualan</span>
        </a>

        <a href="{{ route('transaksi.prive') }}" class="menu-card">
            <div class="menu-icon-badge" style="background-color: var(--badge-pink-bg); color: var(--badge-pink-color);">
                <i class="bi bi-wallet-fill"></i>
            </div>
            <span class="menu-title">Prive</span>
        </a>
    </div>

    <!-- Financial Summary Section -->
    <div class="px-4 mb-2 d-flex justify-content-between align-items-center">
        <h2 class="fs-6 fw-bold text-secondary mb-0">Ringkasan</h2>
        <select class="form-select form-select-sm w-auto border bg-light text-dark shadow-none fw-medium py-1 px-2 rounded-3" style="font-size: 0.8rem;" onchange="window.location.href=this.value;">
            <option value="{{ route('dashboard', ['filter' => 'hari_ini']) }}" {{ ($filter ?? 'bulan_ini') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
            <option value="{{ route('dashboard', ['filter' => 'minggu_ini']) }}" {{ ($filter ?? 'bulan_ini') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="{{ route('dashboard', ['filter' => 'bulan_ini']) }}" {{ ($filter ?? 'bulan_ini') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="{{ route('dashboard', ['filter' => 'tahun_ini']) }}" {{ ($filter ?? 'bulan_ini') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
            <option value="{{ route('dashboard', ['filter' => 'semua']) }}" {{ ($filter ?? 'bulan_ini') == 'semua' ? 'selected' : '' }}>Semua</option>
        </select>
    </div>

    <div class="summary-list mb-4">
        <div class="summary-card">
            <div class="summary-row">
                <span class="summary-label">Total Modal</span>
                <span class="summary-val text-blue">Rp {{ number_format($summary['total_modal'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Pembelian</span>
                <span class="summary-val text-profit">Rp {{ number_format($summary['total_pembelian'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Penjualan</span>
                <span class="summary-val text-warning text-dark">Rp {{ number_format($summary['total_penjualan'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Prive</span>
                <span class="summary-val text-loss">Rp {{ number_format($summary['total_prive'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row pt-3 mt-1 border-top border-2">
                <span class="fw-bold text-dark">Laba Bersih</span>
                <span class="fw-bold text-profit fs-6">Rp {{ number_format($summary['laba_bersih'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
