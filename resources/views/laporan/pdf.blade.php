<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - {{ $namaBulan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #2563eb; }
        .header p { margin: 2px 0; font-size: 11px; color: #666; }
        .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; margin-bottom: 20px; }
        .summary-row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px dashed #cbd5e1; }
        .summary-row:last-child { border-bottom: none; font-weight: bold; font-size: 13px; color: #16a34a; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #e2e8f0; padding: 6px 8px; text-align: left; font-size: 11px; }
        th { background: #f1f5f9; color: #334155; }
        .text-right { text-align: right; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 8px; color: #0f172a; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $user->nama_toko }}</h1>
        <p>Laporan Keuangan Usaha - {{ $namaBulan }}</p>
        <p>Pemilik: {{ $user->name }} | Email: {{ $user->email }}</p>
    </div>

    <div class="summary-box">
        <div class="section-title">Ringkasan Keuangan</div>
        <table style="border: none; margin-bottom: 0;">
            <tr>
                <td style="border:none;">Total Modal: <strong>Rp {{ number_format($totalModal, 0, ',', '.') }}</strong></td>
                <td style="border:none;">Total Pembelian: <strong>Rp {{ number_format($totalPembelian, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="border:none;">Total Penjualan: <strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
                <td style="border:none;">Total Prive: <strong>Rp {{ number_format($totalPrive, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="border:none;" colspan="2"><br><strong>Laba Bersih: <span style="color:#16a34a;">Rp {{ number_format($labaBersih, 0, ',', '.') }}</span></strong></td>
            </tr>
        </table>
    </div>

    <div class="section-title">Detail Penjualan</div>
    <table>
        <thead>
            <tr>
                <th>No Invoice</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualans as $p)
                <tr>
                    <td>{{ $p->no_invoice }}</td>
                    <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $p->nama_barang }}</td>
                    <td class="text-right">{{ $p->jumlah }} {{ $p->satuan }}</td>
                    <td class="text-right">{{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($p->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Tidak ada transaksi penjualan</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Detail Pembelian</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Supplier</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelians as $b)
                <tr>
                    <td>{{ $b->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->supplier ?? '-' }}</td>
                    <td class="text-right">{{ $b->jumlah }} {{ $b->satuan }}</td>
                    <td class="text-right">{{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($b->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Tidak ada transaksi pembelian</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
