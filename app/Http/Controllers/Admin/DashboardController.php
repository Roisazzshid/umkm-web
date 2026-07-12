<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUMKM = Store::count();
        $totalCustomer = User::where('role', 'customer')->count();
        $totalProduct = Product::count();
        $totalOrder = Order::count();

        $pendingStores = Store::where('status', 'Menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalUMKM',
            'totalCustomer',
            'totalProduct',
            'totalOrder',
            'pendingStores'
        ));
    }
}
