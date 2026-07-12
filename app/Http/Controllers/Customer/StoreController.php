<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($id)
    {
        $store = Store::where('status', 'Aktif')->findOrFail($id);

        $products = Product::where('store_id', $store->id)
            ->withAvg('reviews', 'rating')
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

        $rating = Review::whereHas('product', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->avg('rating');
        $store->rating = $rating ? round($rating, 1) : 4.8;

        return view('customer.toko-detail', compact('store', 'products'));
    }
}
