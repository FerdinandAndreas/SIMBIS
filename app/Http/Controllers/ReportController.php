<?php

namespace App\Http\Controllers;

use App\Models\Modal;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Prive;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $period = $request->get('period', 'bulanan');
        $bulan  = (int) $request->get('bulan', Carbon::now()->month);
        $tahun  = (int) $request->get('tahun', Carbon::now()->year);

        // Ringkasan bulan ini
        $totalModal = Modal::where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('nominal');
        $totalPembelian = Pembelian::where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('total');
        $totalPenjualan = Penjualan::where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('total');
        $totalPrive = Prive::where('user_id', $userId)
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('nominal');
        $labaBersih = $totalPenjualan - $totalPembelian - $totalPrive;

        $summary = compact('totalModal', 'totalPembelian', 'totalPenjualan', 'totalPrive', 'labaBersih');

        // Data chart: Laba bersih per minggu dalam bulan ini
        $chartLabels = [];
        $chartData   = [];

        for ($week = 1; $week <= 4; $week++) {
            $startDay = ($week - 1) * 7 + 1;
            $endDay   = $week * 7;
            $daysInMonth = Carbon::create($tahun, $bulan)->daysInMonth;
            $start    = Carbon::create($tahun, $bulan, min($startDay, $daysInMonth))->startOfDay();
            $end      = Carbon::create($tahun, $bulan, min($endDay, $daysInMonth))->endOfDay();

            $penjW = Penjualan::where('user_id', $userId)->whereBetween('tanggal', [$start, $end])->sum('total');
            $beliW = Pembelian::where('user_id', $userId)->whereBetween('tanggal', [$start, $end])->sum('total');
            $priveW = Prive::where('user_id', $userId)->whereBetween('tanggal', [$start, $end])->sum('nominal');

            $chartLabels[] = $start->format('d M');
            $chartData[]   = round(($penjW - $beliW - $priveW) / 1000000, 2);
        }

        $chartData = compact('chartLabels', 'chartData');

        $namaBulan = Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        return view('laporan.index', compact('summary', 'chartData', 'period', 'bulan', 'tahun', 'namaBulan'));
    }

    public function exportPdf(Request $request)
    {
        $userId = Auth::id();
        $user   = Auth::user();
        $bulan  = (int) $request->get('bulan', Carbon::now()->month);
        $tahun  = (int) $request->get('tahun', Carbon::now()->year);

        $modals     = Modal::where('user_id', $userId)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $pembelians = Pembelian::where('user_id', $userId)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $penjualans = Penjualan::where('user_id', $userId)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $prives     = Prive::where('user_id', $userId)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

        $totalModal     = $modals->sum('nominal');
        $totalPembelian = $pembelians->sum('total');
        $totalPenjualan = $penjualans->sum('total');
        $totalPrive     = $prives->sum('nominal');
        $labaBersih     = $totalPenjualan - $totalPembelian - $totalPrive;

        $namaBulan = Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        $pdf = Pdf::loadView('laporan.pdf', compact('user', 'namaBulan', 'totalModal', 'totalPembelian', 'totalPenjualan', 'totalPrive', 'labaBersih', 'penjualans', 'pembelians', 'prives', 'modals'));

        return $pdf->download('Laporan_Keuangan_' . Str_slug($namaBulan) . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $userId = Auth::id();
        $user   = Auth::user();
        $bulan  = (int) $request->get('bulan', Carbon::now()->month);
        $tahun  = (int) $request->get('tahun', Carbon::now()->year);
        $namaBulan = Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        $penjualans = Penjualan::where('user_id', $userId)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $pembelians = Pembelian::where('user_id', $userId)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();

        $csvFileName = 'Laporan_Keuangan_' . Str_slug($namaBulan) . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($user, $namaBulan, $penjualans, $pembelians) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, ['LAPORAN KEUANGAN SIMBIS']);
            fputcsv($file, ['Toko', $user->nama_toko]);
            fputcsv($file, ['Pemilik', $user->name]);
            fputcsv($file, ['Periode', $namaBulan]);
            fputcsv($file, []);

            fputcsv($file, ['PENJUALAN']);
            fputcsv($file, ['No Invoice', 'Tanggal', 'Barang', 'Jumlah', 'Satuan', 'Harga Jual', 'Total']);
            foreach ($penjualans as $p) {
                fputcsv($file, [$p->no_invoice, $p->tanggal->format('d/m/Y'), $p->nama_barang, $p->jumlah, $p->satuan, $p->harga_jual, $p->total]);
            }

            fputcsv($file, []);
            fputcsv($file, ['PEMBELIAN']);
            fputcsv($file, ['Tanggal', 'Barang', 'Supplier', 'Jumlah', 'Satuan', 'Harga Beli', 'Total']);
            foreach ($pembelians as $b) {
                fputcsv($file, [$b->tanggal->format('d/m/Y'), $b->nama_barang, $b->supplier ?? '-', $b->jumlah, $b->satuan, $b->harga_beli, $b->total]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
