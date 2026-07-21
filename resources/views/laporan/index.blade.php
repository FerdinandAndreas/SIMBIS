<x-app-layout title="Laporan" activeNav="laporan">
    <div class="px-4 mt-2">
        <!-- Toggle Period -->
        <div class="d-flex justify-content-center bg-white p-1 rounded-pill border mb-3">
            <a href="{{ route('laporan.index', ['period' => 'mingguan', 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm rounded-pill px-4 py-1 {{ $period === 'mingguan' ? 'btn-primary fw-bold' : 'text-muted' }}" style="{{ $period === 'mingguan' ? 'background-color: var(--simbis-primary);' : '' }}">Mingguan</a>
            <a href="{{ route('laporan.index', ['period' => 'bulanan', 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm rounded-pill px-4 py-1 {{ $period === 'bulanan' ? 'btn-primary fw-bold' : 'text-muted' }}" style="{{ $period === 'bulanan' ? 'background-color: var(--simbis-primary);' : '' }}">Bulanan</a>
        </div>

        <!-- Month Navigation -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            @php
                $prevBulan = $bulan == 1 ? 12 : $bulan - 1;
                $prevTahun = $bulan == 1 ? $tahun - 1 : $tahun;
                $nextBulan = $bulan == 12 ? 1 : $bulan + 1;
                $nextTahun = $bulan == 12 ? $tahun + 1 : $tahun;
            @endphp
            <a href="{{ route('laporan.index', ['period' => $period, 'bulan' => $prevBulan, 'tahun' => $prevTahun]) }}" class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-chevron-left"></i></a>
            <span class="fw-bold text-dark fs-6">{{ $namaBulan ?? 'Juli 2026' }}</span>
            <a href="{{ route('laporan.index', ['period' => $period, 'bulan' => $nextBulan, 'tahun' => $nextTahun]) }}" class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-chevron-right"></i></a>
        </div>

        <!-- Financial Breakdown -->
        <div class="summary-card mb-4">
            <div class="summary-row">
                <span class="summary-label">Total Modal</span>
                <span class="summary-val text-blue">Rp {{ number_format($summary['totalModal'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Pembelian</span>
                <span class="summary-val text-profit">Rp {{ number_format($summary['totalPembelian'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Penjualan</span>
                <span class="summary-val text-warning text-dark">Rp {{ number_format($summary['totalPenjualan'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Prive</span>
                <span class="summary-val text-loss">Rp {{ number_format($summary['totalPrive'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-row pt-3 mt-1 border-top border-2">
                <span class="fw-bold text-dark">Laba Bersih</span>
                <span class="fw-bold text-profit fs-6">Rp {{ number_format($summary['labaBersih'], 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="card-custom mb-4">
            <h3 class="fs-6 fw-bold text-dark mb-3">Grafik Ringkasan (Juta Rp)</h3>
            <div style="height: 180px; position: relative;">
                <canvas id="laporanChart"></canvas>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="row g-2 mb-4">
            <div class="col-6">
                <a href="{{ route('laporan.pdf') }}" class="btn btn-danger w-100 py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('laporan.excel') }}" class="btn btn-success w-100 py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('laporanChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['chartLabels']) !!},
                    datasets: [{
                        label: 'Laba (Juta Rp)',
                        data: {!! json_encode($chartData['chartData']) !!},
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 5,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(value) { return value + ' jt'; },
                                font: { size: 10 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
