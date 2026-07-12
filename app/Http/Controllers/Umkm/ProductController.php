<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        $query = Product::where('store_id', $store->id);

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->kategori);
            });
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        return view('umkm.produk.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('umkm.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string', // Kategori nama dari UI
            'harga_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'foto_produk' => 'nullable|image|max:2048',
        ]);

        $category = Category::where('name', $request->kategori_produk)->first();
        if (!$category) {
            // Fallback or create category
            $category = Category::firstOrCreate([
                'name' => $request->kategori_produk,
                'slug' => Str::slug($request->kategori_produk),
            ]);
        }

        $imagePath = null;
        if ($request->hasFile('foto_produk')) {
            $imagePath = $request->file('foto_produk')->store('products', 'public');
        }

        Product::create([
            'store_id' => $store->id,
            'category_id' => $category->id,
            'name' => $request->nama_produk,
            'slug' => Str::slug($request->nama_produk),
            'price' => $request->harga_produk,
            'description' => $request->deskripsi_produk,
            'image' => $imagePath,
        ]);

        return redirect()->route('umkm.produk.index', ['berhasil' => 'tambah']);
    }

    public function edit($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        $categories = Category::all();

        return view('umkm.produk.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string',
            'harga_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'foto_produk' => 'nullable|image|max:2048',
        ]);

        $category = Category::where('name', $request->kategori_produk)->first();
        if (!$category) {
            $category = Category::firstOrCreate([
                'name' => $request->kategori_produk,
                'slug' => Str::slug($request->kategori_produk),
            ]);
        }

        $imagePath = $product->image;
        if ($request->hasFile('foto_produk')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('foto_produk')->store('products', 'public');
        }

        $product->update([
            'category_id' => $category->id,
            'name' => $request->nama_produk,
            'slug' => Str::slug($request->nama_produk),
            'price' => $request->harga_produk,
            'description' => $request->deskripsi_produk,
            'image' => $imagePath,
        ]);

        return redirect()->route('umkm.produk.index', ['berhasil' => 'edit']);
    }

    public function destroy($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('umkm.produk.index', ['berhasil' => 'hapus']);
    }
}
