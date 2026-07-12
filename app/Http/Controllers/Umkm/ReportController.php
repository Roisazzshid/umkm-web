<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $storeId = $store->id;

        $totalProduct = Product::where('store_id', $storeId)->count();
        $totalOrder = Order::where('store_id', $storeId)->count();

        $totalSold = OrderItem::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->sum('quantity');

        $averageRating = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0.0;

        // 1. Tren Pesanan Toko (3, 6, 12 bulan terakhir)
        $dataTren = [
            3 => $this->getStoreOrdersTrend($storeId, 3),
            6 => $this->getStoreOrdersTrend($storeId, 6),
            12 => $this->getStoreOrdersTrend($storeId, 12),
        ];

        // 2. Produk Terlaris Toko (Top 5)
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('product', function ($q) use ($storeId) {
                $q->where('store_id', $storeId);
            })
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        $produkLabels = $topProducts->pluck('product_name')->toArray();
        $produkData = $topProducts->pluck('total_sold')->map(fn($val) => (int)$val)->toArray();

        if (empty($produkLabels)) {
            $produkLabels = ['Belum ada data'];
            $produkData = [0];
        }

        return view('umkm.laporan', compact(
            'totalProduct',
            'totalOrder',
            'totalSold',
            'averageRating',
            'dataTren',
            'produkLabels',
            'produkData'
        ));
    }

    private function getStoreOrdersTrend($storeId, $months)
    {
        $labels = [];
        $data = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M');

            $count = Order::where('store_id', $storeId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }

        return [
            'label' => $labels,
            'data' => $data
        ];
    }
}
