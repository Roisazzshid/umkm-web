<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Metrics stats
        $totalStores = Store::where('status', 'Aktif')->count();
        $totalProducts = Product::whereHas('store', function ($q) {
            $q->where('status', 'Aktif');
        })->count();

        $avgRating = Review::avg('rating');
        $avgRating = $avgRating ? round($avgRating, 1) : 4.8; // default to 4.8 if empty

        // 2. Featured/Latest Products (Produk pilihan)
        $featuredProducts = Product::whereHas('store', function ($q) {
            $q->where('status', 'Aktif');
        })
        ->withAvg('reviews', 'rating')
        ->withCount(['orderItems as sold_count' => function ($q) {
            $q->select(\DB::raw('sum(quantity)'));
        }])
        ->latest()
        ->limit(4)
        ->get()
        ->map(function ($product) {
            $product->rating = $product->reviews_avg_rating ? round($product->reviews_avg_rating, 1) : 4.8;
            $product->sold_count = $product->sold_count ?? 0;
            return $product;
        });

        // 3. Popular Stores (UMKM populer)
        $popularStores = Store::where('status', 'Aktif')
            ->withCount('products')
            ->limit(4)
            ->get()
            ->map(function ($store) {
                // Calculate average rating of store's products
                $rating = Review::whereHas('product', function ($q) use ($store) {
                    $q->where('store_id', $store->id);
                })->avg('rating');
                $store->rating = $rating ? round($rating, 1) : 4.8;

                // Get main category name
                $firstProduct = Product::where('store_id', $store->id)->with('category')->first();
                $store->category_name = $firstProduct ? $firstProduct->category->name : 'UMKM';
                return $store;
            });

        return view('customer.home', compact(
            'totalStores',
            'totalProducts',
            'avgRating',
            'featuredProducts',
            'popularStores'
        ));
    }

    public function umkmList(Request $request)
    {
        $query = Store::where('status', 'Aktif');

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('products.category', function ($q) use ($request) {
                $q->where('name', $request->kategori);
            });
        }

        $stores = $query->withCount('products')->get()->map(function ($store) {
            $rating = Review::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->avg('rating');
            $store->rating = $rating ? round($rating, 1) : 4.8;

            $firstProduct = Product::where('store_id', $store->id)->with('category')->first();
            $store->category_name = $firstProduct ? $firstProduct->category->name : 'UMKM';
            return $store;
        });

        return view('customer.umkm-list', compact('stores'));
    }
}
