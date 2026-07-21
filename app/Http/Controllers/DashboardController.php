<?php

namespace App\Http\Controllers;

use App\Models\Modal;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Prive;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $filter = $request->get('filter', 'bulan_ini');

        $applyFilter = function ($query) use ($filter) {
            return match ($filter) {
                'hari_ini'   => $query->whereDate('tanggal', Carbon::today()),
                'minggu_ini' => $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
                'bulan_ini'  => $query->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year),
                'tahun_ini'  => $query->whereYear('tanggal', Carbon::now()->year),
                'semua'      => $query,
                default      => $query->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year),
            };
        };

        $totalModal     = $applyFilter(Modal::where('user_id', $userId))->sum('nominal');
        $totalPembelian = $applyFilter(Pembelian::where('user_id', $userId))->sum('total');
        $totalPenjualan = $applyFilter(Penjualan::where('user_id', $userId))->sum('total');
        $totalPrive     = $applyFilter(Prive::where('user_id', $userId))->sum('nominal');

        $labaBersih  = $totalPenjualan - $totalPembelian - $totalPrive;

        $allModal     = Modal::where('user_id', $userId)->sum('nominal');
        $allPembelian = Pembelian::where('user_id', $userId)->sum('total');
        $allPenjualan = Penjualan::where('user_id', $userId)->sum('total');
        $allPrive     = Prive::where('user_id', $userId)->sum('nominal');
        $allLaba      = $allPenjualan - $allPembelian - $allPrive;
        $saldoUsaha   = $allModal + $allLaba;

        $labaBulanIni = Penjualan::where('user_id', $userId)->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->sum('total')
                      - Pembelian::where('user_id', $userId)->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->sum('total')
                      - Prive::where('user_id', $userId)->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->sum('nominal');

        $summary = [
            'saldo_usaha'     => $saldoUsaha,
            'laba_bulan_ini'  => $labaBulanIni,
            'total_modal'     => $totalModal,
            'total_pembelian' => $totalPembelian,
            'total_penjualan' => $totalPenjualan,
            'total_prive'     => $totalPrive,
            'laba_bersih'     => $labaBersih,
        ];

        return view('dashboard', compact('summary', 'filter'));
    }
}

