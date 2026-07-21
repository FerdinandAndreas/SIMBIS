<x-app-layout title="Struk Penjualan" activeNav="transaksi" :backUrl="route('transaksi.penjualan')">
    <x-slot:headerAction>
        <div class="header-icon" onclick="window.print()">
            <i class="bi bi-printer fs-5"></i>
        </div>
    </x-slot:headerAction>

    <div class="px-4 mt-3 mb-4">
        <div class="receipt-box">
            <div class="text-center mb-3">
                <div class="d-inline-flex p-3 rounded-circle mb-2" style="background-color: var(--badge-blue-bg); color: var(--badge-blue-color);">
                    <i class="bi bi-shop fs-3"></i>
                </div>
                <h2 class="fs-5 fw-bold text-dark mb-1">Transaksi Penjualan</h2>
                <div class="text-muted small">Pemilik: {{ $penjualan->user->name }}</div>

            </div>

            <div class="receipt-divider"></div>

            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>{{ $penjualan->no_invoice }}</span>
                <span>{{ $penjualan->tanggal->format('d M Y H:i') }}</span>
            </div>
            <div class="small text-muted mb-3">
                Kasir: <strong>{{ $penjualan->user->name }}</strong>
            </div>

            <table class="table table-borderless table-sm small mb-3">
                <thead>
                    <tr class="border-bottom text-muted">
                        <th>Barang</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">{{ $penjualan->nama_barang }}</td>
                        <td class="text-center">{{ $penjualan->jumlah }}</td>
                        <td class="text-end">{{ number_format($penjualan->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-end fw-semibold">{{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="receipt-divider"></div>

            <div class="d-flex justify-content-between fw-bold text-dark mb-1">
                <span>Total</span>
                <span class="fs-6">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>Bayar (Tunai)</span>
                <span>Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between small text-profit fw-bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
            </div>

            <div class="receipt-divider"></div>

            <div class="text-center text-muted small mt-3">
                Terima kasih<br>atas kunjungan Anda
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
                <button class="btn-outline-simbis flex-grow-1" id="exportBtn">
                    <i class="bi bi-download"></i> Unduh PNG
                </button>
            <button class="btn-primary-simbis flex-grow-1" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak Struk
            </button>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('exportBtn').addEventListener('click', function () {
  html2canvas(document.querySelector('.receipt-box')).then(function (canvas) {
    const link = document.createElement('a');
    link.download = 'struk_' + '{{ $penjualan->no_invoice }}' + '.png';
    link.href = canvas.toDataURL();
    link.click();
  });
});
</script>
</x-app-layout>
