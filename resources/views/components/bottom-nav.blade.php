@props(['active' => 'beranda'])

<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ $active === 'beranda' ? 'active' : '' }}">
        <i class="bi {{ $active === 'beranda' ? 'bi-house-door-fill' : 'bi-house-door' }}"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('transaksi.index') }}" class="bottom-nav-item {{ $active === 'transaksi' ? 'active' : '' }}">
        <i class="bi {{ $active === 'transaksi' ? 'bi-receipt-cutoff' : 'bi-receipt' }}"></i>
        <span>Transaksi</span>
    </a>
    <a href="{{ route('laporan.index') }}" class="bottom-nav-item {{ $active === 'laporan' ? 'active' : '' }}">
        <i class="bi {{ $active === 'laporan' ? 'bi-bar-chart-line-fill' : 'bi-bar-chart-line' }}"></i>
        <span>Laporan</span>
    </a>
    <a href="{{ route('akun.index') }}" class="bottom-nav-item {{ $active === 'akun' ? 'active' : '' }}">
        <i class="bi {{ $active === 'akun' ? 'bi-person-fill' : 'bi-person' }}"></i>
        <span>Akun</span>
    </a>
</nav>
