<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $totalUMKM = Store::count();
        $totalCustomer = User::where('role', 'customer')->count();
        $totalProduct = Product::count();
        $totalOrder = Order::count();

        // 1. Tren Pesanan (3, 6, 12 bulan terakhir)
        $dataTren = [
            3 => $this->getOrdersTrend(3),
            6 => $this->getOrdersTrend(6),
            12 => $this->getOrdersTrend(12),
        ];

        // 2. Produk Terlaris (Top 5 berdasarkan total kuantitas)
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        $produkLabels = $topProducts->pluck('product_name')->toArray();
        $produkData = $topProducts->pluck('total_sold')->map(fn($val) => (int)$val)->toArray();

        // Fallback data jika kosong
        if (empty($produkLabels)) {
            $produkLabels = ['Belum ada data'];
            $produkData = [0];
        }

        // 3. UMKM Teraktif (Top 5 berdasarkan jumlah order)
        $topStores = Order::select('stores.name', DB::raw('COUNT(orders.id) as total_orders'))
            ->join('stores', 'orders.store_id', '=', 'stores.id')
            ->groupBy('orders.store_id', 'stores.name')
            ->orderBy('total_orders', 'desc')
            ->limit(5)
            ->get();

        $umkmLabels = $topStores->pluck('name')->toArray();
        $umkmData = $topStores->pluck('total_orders')->map(fn($val) => (int)$val)->toArray();

        if (empty($umkmLabels)) {
            $umkmLabels = ['Belum ada data'];
            $umkmData = [0];
        }

        return view('admin.laporan', compact(
            'totalUMKM',
            'totalCustomer',
            'totalProduct',
            'totalOrder',
            'dataTren',
            'produkLabels',
            'produkData',
            'umkmLabels',
            'umkmData'
        ));
    }

    private function getOrdersTrend($months)
    {
        $labels = [];
        $data = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M'); // e.g. "Mei", "Jun"

            $count = Order::whereYear('created_at', $date->year)
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
