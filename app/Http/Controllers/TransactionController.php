<?php

namespace App\Http\Controllers;

use App\Models\Modal;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Prive;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    // ─── Index (Daftar Menu) ────────────────────────────────────────────────
    public function index()
    {
        return view('transaksi.index');
    }

    // ─── MODAL ──────────────────────────────────────────────────────────────
    public function modal()
    {
        $modals = Modal::where('user_id', Auth::id())
            ->orderByDesc('tanggal')->limit(10)->get();
        return view('transaksi.modal', compact('modals'));
    }

    public function storeModal(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'nominal'     => 'required|numeric|min:1',
            'keterangan'  => 'nullable|string|max:500',
        ]);

        $validated['nominal']  = (int) str_replace(['Rp ', '.', ','], '', $validated['nominal']);
        $validated['user_id']  = Auth::id();

        Modal::create($validated);

        return redirect()->route('transaksi.modal')
            ->with('success', 'Modal berhasil disimpan!');
    }

    // ─── PEMBELIAN ──────────────────────────────────────────────────────────
    public function pembelian()
    {
        $products  = Product::where('user_id', Auth::id())->get();
        $pembelians = Pembelian::where('user_id', Auth::id())
            ->orderByDesc('tanggal')->limit(10)->get();
        return view('transaksi.pembelian', compact('products', 'pembelians'));
    }

    public function storePembelian(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'product_id' => 'nullable|exists:products,id',
            'nama_barang'=> 'required|string|max:255',
            'supplier'   => 'nullable|string|max:255',
            'jumlah'     => 'required|integer|min:1',
            'satuan'     => 'required|string|max:50',
            'harga_beli' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['total']   = $validated['jumlah'] * $validated['harga_beli'];
        $validated['user_id'] = Auth::id();

        // Update stok produk jika dipilih
        if ($validated['product_id']) {
            $product = Product::find($validated['product_id']);
            if ($product) {
                $product->stok        += $validated['jumlah'];
                $product->harga_beli   = $validated['harga_beli'];
                $product->save();
            }
        }

        Pembelian::create($validated);

        return redirect()->route('transaksi.pembelian')
            ->with('success', 'Pembelian berhasil disimpan!');
    }

    // ─── PENJUALAN ──────────────────────────────────────────────────────────
    public function penjualan()
    {
        $products   = Product::where('user_id', Auth::id())->get();
        $penjualans = Penjualan::where('user_id', Auth::id())
            ->orderByDesc('tanggal')->limit(10)->get();
        return view('transaksi.penjualan', compact('products', 'penjualans'));
    }

    public function storePenjualan(Request $request)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'product_id'      => 'nullable|exists:products,id',
            'nama_barang'     => 'required|string|max:255',
            'jumlah'          => 'required|integer|min:1',
            'satuan'          => 'required|string|max:50',
            'harga_jual'      => 'required|integer|min:0',
            'bayar'           => 'nullable|integer|min:0',
            'nama_pelanggan'  => 'nullable|string|max:255',
            'keterangan'      => 'nullable|string',
        ]);

        $validated['total']       = $validated['jumlah'] * $validated['harga_jual'];
        $validated['bayar']       = $request->filled('bayar') ? (int) $request->bayar : $validated['total'];
        $validated['kembalian']   = max(0, $validated['bayar'] - $validated['total']);
        $validated['user_id']     = Auth::id();
        $validated['no_invoice']  = 'INV/' . Carbon::now()->format('Y/m') . '/' . strtoupper(Str::random(6));

        // Kurangi stok jika ada produk
        if ($validated['product_id']) {
            $product = Product::find($validated['product_id']);
            if ($product) {
                $product->stok = max(0, $product->stok - $validated['jumlah']);
                $product->save();
            }
        }

        $penjualan = Penjualan::create($validated);

        if ($request->has('cetak')) {
            return redirect()->route('transaksi.struk', $penjualan->id);
        }

        return redirect()->route('transaksi.penjualan')
            ->with('success', 'Penjualan berhasil disimpan!');
    }

    // ─── STRUK ──────────────────────────────────────────────────────────────
    public function struk($id)
    {
        $penjualan = Penjualan::with('user')->findOrFail($id);

        // Pastikan hanya pemilik yang bisa lihat
        abort_unless($penjualan->user_id === Auth::id(), 403);

        return view('transaksi.struk', compact('penjualan'));
    }

    // ─── PRIVE ──────────────────────────────────────────────────────────────
    public function prive()
    {
        $prives = Prive::where('user_id', Auth::id())
            ->orderByDesc('tanggal')->limit(10)->get();
        return view('transaksi.prive', compact('prives'));
    }

    public function storePrive(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'kategori'   => 'required|string|max:100',
            'nominal'    => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();

        Prive::create($validated);

        return redirect()->route('transaksi.prive')
            ->with('success', 'Prive / pengeluaran berhasil disimpan!');
    }
    // ─── DESTROY METHODS ────────────────────────────────────────────────────────
    public function destroyPembelian($id)
    {
        $pembelian = Pembelian::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $pembelian->delete();

        return back()->with('success', 'Pembelian berhasil dihapus.');
    }

    public function destroyPenjualan($id)
    {
        $penjualan = Penjualan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $penjualan->delete();

        return back()->with('success', 'Penjualan berhasil dihapus.');
    }

    public function destroyModal($id)
    {
        $modal = Modal::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $modal->delete();

        return back()->with('success', 'Modal berhasil dihapus.');
    }

    public function destroyPrive($id)
    {
        $prive = Prive::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $prive->delete();

        return back()->with('success', 'Prive berhasil dihapus.');
    }

    public function batchStruk(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:penjualans,id',
        ]);

        $penjualans = Penjualan::whereIn('id', $request->ids)
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->get();

        return view('transaksi.batch_struk', compact('penjualans'));
    }

}
