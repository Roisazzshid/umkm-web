<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::whereHas('store', function ($q) {
            $q->where('status', 'Aktif');
        });

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->kategori);
            });
        }

        $products = $query->withAvg('reviews', 'rating')
            ->withCount(['orderItems as sold_count' => function ($q) {
                $q->select(\DB::raw('sum(quantity)'));
            }])
            ->latest()
            ->get()
            ->map(function ($product) {
                $product->rating = $product->reviews_avg_rating ? round($product->reviews_avg_rating, 1) : 4.8;
                $product->sold_count = $product->sold_count ?? 0;
                return $product;
            });

        $categories = Category::all();

        return view('customer.produk-list', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::whereHas('store', function ($q) {
            $q->where('status', 'Aktif');
        })
        ->withAvg('reviews', 'rating')
        ->withCount(['orderItems as sold_count' => function ($q) {
            $q->select(\DB::raw('sum(quantity)'));
        }])
        ->findOrFail($id);

        $product->rating = $product->reviews_avg_rating ? round($product->reviews_avg_rating, 1) : 4.8;
        $product->sold_count = $product->sold_count ?? 0;

        return view('customer.produk-detail', compact('product'));
    }
}
