<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('produk.index', compact('products'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'satuan'     => 'required|string|max:50',
            'stok'       => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $produk)
    {
        $this->authorize('update', $produk);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Product $produk)
    {
        $this->authorize('update', $produk);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'satuan'     => 'required|string|max:50',
            'stok'       => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $produk->update($validated);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $produk)
    {
        $this->authorize('delete', $produk);
        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
