<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(404, 'Toko tidak ditemukan.');
        }

        $storeId = $store->id;

        $totalProduct = Product::where('store_id', $storeId)->count();
        $totalOrder = Order::where('store_id', $storeId)->count();

        $totalSold = OrderItem::whereHas('product', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })->sum('quantity');

        $averageRating = Review::whereHas('product', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })->avg('rating');

        $averageRating = $averageRating ? round($averageRating, 1) : 0.0;

        $recentReviews = Review::whereHas('product', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();

        return view('umkm.dashboard', compact(
            'totalProduct',
            'totalOrder',
            'totalSold',
            'averageRating',
            'recentReviews'
        ));
    }
}
