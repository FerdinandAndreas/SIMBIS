<x-app-layout title="Struk Penjualan" activeNav="transaksi" :backUrl="route('transaksi.penjualan')">
    <x-slot:headerAction>
        <div class="header-icon no-print" onclick="window.print()">
            <i class="bi bi-printer fs-5"></i>
        </div>
    </x-slot:headerAction>

    <style>
        /* Modern Nota Style */
        .nota-container {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        .nota-header-title {
            color: #1e3a8a;
            font-weight: 800;
            letter-spacing: 0.5px;
            font-size: 1.6rem;
            margin-bottom: 0.25rem;
        }

        .nota-subline {
            height: 3px;
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 2px;
            margin: 0.5rem 0 1.25rem 0;
        }

        .nota-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem 1.5rem;
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .nota-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .nota-table th {
            background-color: #f1f5f9;
            color: #1e3a8a;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 0.75rem;
            border: 1px solid #cbd5e1;
        }

        .nota-table td {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .nota-summary-box {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-bottom: 1.5rem;
        }

        .nota-summary-table {
            width: 300px;
            font-size: 0.875rem;
        }

        .nota-summary-table td {
            padding: 0.35rem 0;
        }

        .nota-status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 50px;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nota-signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1rem;
            font-size: 0.875rem;
        }

        .signature-col {
            text-align: center;
            width: 40%;
        }

        .signature-space {
            height: 60px;
        }

        .nota-footer-thankyou {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px dashed #cbd5e1;
            color: #64748b;
        }

        /* Thermal Printer Optimization */
        @media print {
            .no-print, header, nav, footer, .btn-action-container {
                display: none !important;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .nota-container {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                color: #000000 !important;
            }

            .nota-header-title {
                color: #000000 !important;
            }

            .nota-subline {
                background: #000000 !important;
            }

            .nota-meta-grid {
                background-color: transparent !important;
                border: 1px solid #000000 !important;
            }

            .nota-table th, .nota-table td {
                border: 1px solid #000000 !important;
                color: #000000 !important;
            }

            .nota-table th {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .nota-status-badge {
                border: 1px solid #000000 !important;
                color: #000000 !important;
                background: transparent !important;
            }

            .nota-footer-thankyou {
                border-top: 1px dashed #000000 !important;
                color: #000000 !important;
            }

            @page {
                size: auto;
                margin: 5mm;
            }
        }
    </style>

    <div class="px-3 mt-3 mb-4">
        <div class="nota-container receipt-box">
            <!-- Header Nota -->
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="nota-header-title">NOTA PENJUALAN</h1>
                    <div class="small text-muted">Kasir / Toko: <strong>{{ $penjualan->user->name }}</strong></div>
                </div>
                <div class="text-end">
                    <span class="nota-status-badge">
                        <i class="bi bi-check-circle-fill me-1"></i> LUNAS
                    </span>
                </div>
            </div>

            <div class="nota-subline"></div>

            <!-- Metadata Transaksi (No. Invoice, Tanggal, Kepada) -->
            <div class="nota-meta-grid">
                <div>
                    <span class="text-muted d-block small">No. Invoice</span>
                    <strong class="font-monospace text-dark fs-6">{{ $penjualan->no_invoice }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block small">Tanggal & Waktu</span>
                    <strong>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }} {{ $penjualan->created_at ? $penjualan->created_at->format('H:i') : '' }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block small">Kepada (Pelanggan)</span>
                    <strong>{{ $penjualan->nama_pelanggan ? $penjualan->nama_pelanggan : 'Umum' }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block small">Kasir Penanggung Jawab</span>
                    <strong>{{ $penjualan->user->name }}</strong>
                </div>
            </div>

            <!-- Tabel Barang (UX/UI Optimized) -->
            <table class="nota-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15%;">BANYAKNYA</th>
                        <th class="text-start" style="width: 45%;">NAMA BARANG</th>
                        <th class="text-end" style="width: 20%;">HARGA</th>
                        <th class="text-end" style="width: 20%;">JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center fw-semibold">{{ $penjualan->jumlah }} {{ $penjualan->satuan ?? 'pcs' }}</td>
                        <td class="text-start fw-semibold text-dark">
                            {{ $penjualan->nama_barang }}
                            @if($penjualan->keterangan)
                                <div class="small text-muted font-italic">{{ $penjualan->keterangan }}</div>
                            @endif
                        </td>
                        <td class="text-end">Rp {{ number_format($penjualan->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold text-dark">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Detail Transaksi & Pembayaran (Tanpa Diskon) -->
            <div class="nota-summary-box">
                <table class="nota-summary-table">
                    <tr class="border-top border-bottom">
                        <td class="fw-bold fs-6 text-dark py-2">Jumlah Total</td>
                        <td class="text-end fw-bold fs-6 text-primary py-2">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted pt-2">Bayar (Tunai)</td>
                        <td class="text-end pt-2">Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-success pb-2">Kembalian</td>
                        <td class="text-end fw-semibold text-success pb-2">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Tanda Tangan (Yang Menerima & Hormat Kami) -->
            <div class="nota-signatures">
                <div class="signature-col">
                    <div>Yang Menerima</div>
                    <div class="signature-space"></div>
                    <div class="fw-semibold text-dark">( {{ $penjualan->nama_pelanggan ? $penjualan->nama_pelanggan : '________________' }} )</div>
                </div>
                <div class="signature-col">
                    <div>Hormat Kami</div>
                    <div class="signature-space"></div>
                    <div class="fw-semibold text-dark">( {{ $penjualan->user->name }} )</div>
                </div>
            </div>

            <!-- Ucapan Terima Kasih Footer -->
            <div class="nota-footer-thankyou">
                <p class="fw-bold mb-1 text-dark">~ Terima Kasih Atas Kunjungan Anda ~</p>
                <div class="small">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</div>
            </div>
        </div>

        <!-- Tombol Aksi (Disembunyikan saat diprint) -->
        <div class="d-flex gap-2 mt-4 max-w-680 mx-auto btn-action-container no-print" style="max-width: 680px;">
            <button class="btn-outline-simbis flex-grow-1" id="exportBtn">
                <i class="bi bi-download"></i> Unduh PNG
            </button>
            <button class="btn-primary-simbis flex-grow-1" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak Struk / Nota
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('exportBtn').addEventListener('click', function () {
            html2canvas(document.querySelector('.receipt-box'), {
                scale: 2,
                useCORS: true
            }).then(function (canvas) {
                const link = document.createElement('a');
                link.download = 'Nota_' + '{{ $penjualan->no_invoice }}'.replaceAll('/', '_') + '.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        });
    </script>
</x-app-layout>

