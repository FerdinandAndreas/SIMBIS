<x-app-layout title="Struk Penjualan" activeNav="transaksi" :backUrl="route('transaksi.penjualan')">
    <x-slot:headerAction>
        <div class="header-icon no-print" onclick="window.print()">
            <i class="bi bi-printer fs-5"></i>
        </div>
    </x-slot:headerAction>

    <style>
        .nota-paper {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #0c3378;
        }

        .nota-title {
            color: #0c3378;
            font-weight: 800;
            letter-spacing: 0.5px;
            font-size: 1.85rem;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
        }

        .nota-divider {
            height: 3.5px;
            background-color: #0c3378;
            margin-bottom: 1.25rem;
            border: none;
        }

        .nota-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: #0c3378;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        .meta-row {
            display: flex;
            align-items: center;
        }

        .meta-label {
            width: 140px;
            color: #0c3378;
            font-weight: 600;
        }

        .meta-colon {
            width: 20px;
            color: #0c3378;
            font-weight: 700;
        }

        .meta-value {
            flex-grow: 1;
            color: #1e293b;
            font-weight: 500;
        }

        .nota-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            border: 1px solid #0c3378;
        }

        .nota-table th {
            border: 1px solid #0c3378;
            padding: 0.6rem 0.75rem;
            text-align: left;
            color: #0c3378;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            background-color: #ffffff;
        }

        .nota-table td {
            border: 1px solid #0c3378;
            padding: 0.55rem 0.75rem;
            font-size: 0.9rem;
            color: #1e293b;
            height: 36px;
            vertical-align: middle;
        }

        .nota-total-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 3.5rem;
            margin-top: 1rem;
            padding-right: 0.5rem;
        }

        .nota-total-box {
            display: flex;
            align-items: baseline;
            gap: 1.5rem;
        }

        .total-label {
            font-weight: 800;
            font-size: 1.15rem;
            color: #0c3378;
        }

        .total-value {
            font-weight: 700;
            font-size: 1.15rem;
            color: #0c3378;
            border-bottom: 1.5px solid #0c3378;
            min-width: 150px;
            display: inline-block;
            text-align: right;
            padding-bottom: 2px;
        }

        .nota-signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .sig-box {
            width: 40%;
            text-align: left;
        }

        .sig-title {
            font-weight: 800;
            font-size: 1.05rem;
            color: #0c3378;
            margin-bottom: 4.5rem;
        }

        .sig-line {
            border-bottom: 1.5px solid #0c3378;
            width: 100%;
        }

        /* Print styling */
        @media print {
            .no-print, header, nav, footer, .btn-action-container {
                display: none !important;
            }

            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .nota-paper {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            @page {
                size: auto;
                margin: 10mm;
            }
        }
    </style>

    <div class="px-3 mt-3 mb-4">
        <div class="nota-paper receipt-box">
            <!-- Title -->
            <h1 class="nota-title">NOTA PENJUALAN</h1>
            <div class="nota-divider"></div>

            <!-- Metadata Transaksi -->
            <div class="nota-meta">
                <div class="meta-row">
                    <span class="meta-label">No. Invoice</span>
                    <span class="meta-colon">:</span>
                    <span class="meta-value">{{ $penjualan->no_invoice }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Kepada</span>
                    <span class="meta-colon">:</span>
                    <span class="meta-value">{{ $penjualan->nama_pelanggan ? $penjualan->nama_pelanggan : '' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Tanggal</span>
                    <span class="meta-colon">:</span>
                    <span class="meta-value">{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="nota-divider"></div>

            <!-- Tabel Barang Full Grid Blue -->
            <table class="nota-table">
                <thead>
                    <tr>
                        <th style="width: 18%;">BANYAKNYA</th>
                        <th style="width: 42%;">NAMA BARANG</th>
                        <th style="width: 20%;">HARGA</th>
                        <th style="width: 20%;">JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">{{ $penjualan->jumlah }} {{ $penjualan->satuan ?? 'pcs' }}</td>
                        <td>{{ $penjualan->nama_barang }}</td>
                        <td style="text-align: right;">{{ number_format($penjualan->harga_jual, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    </tr>
                    @for($i = 0; $i < 9; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endfor
                </tbody>
            </table>

            <!-- Total Rp -->
            <div class="nota-total-container">
                <div class="nota-total-box">
                    <span class="total-label">Jumlah Rp.</span>
                    <span class="total-value">{{ number_format($penjualan->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="nota-signatures">
                <div class="sig-box">
                    <div class="sig-title">Yang Menerima</div>
                    <div class="sig-line"></div>
                </div>
                <div class="sig-box">
                    <div class="sig-title">Hormat Kami</div>
                    <div class="sig-line"></div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex gap-2 mt-4 btn-action-container no-print" style="max-width: 680px; margin: 1rem auto 0 auto;">
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


