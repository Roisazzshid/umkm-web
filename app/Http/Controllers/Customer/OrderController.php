<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create($id, Request $request)
    {
        $product = Product::with('store')->findOrFail($id);
        $customer = Auth::user();
        $jumlah = $request->query('jumlah', 1);

        return view('customer.form-pesanan', compact('product', 'customer', 'jumlah'));
    }

    public function store($id, Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:20',
            'alamat' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        $product = Product::with('store')->findOrFail($id);
        $store = $product->store;
        $customer = Auth::user();

        $subtotal = $product->price * $request->jumlah;

        // 1. Save to Database
        $order = Order::create([
            'customer_id' => $customer->id,
            'store_id' => $store->id,
            'customer_name' => $request->nama_pemesan,
            'customer_phone' => $request->nomor_wa,
            'customer_address' => $request->alamat,
            'notes' => $request->catatan,
            'total_price' => $subtotal,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => $request->jumlah,
            'subtotal' => $subtotal,
        ]);

        // 2. Format WhatsApp link
        // Clean phone number: remove non-digits, convert leading 0 to 62
        $storePhone = preg_replace('/\D/', '', $store->phone);
        if (strpos($storePhone, '0') === 0) {
            $storePhone = '62' . substr($storePhone, 1);
        }

        $message = "Halo " . $store->name . ", saya ingin memesan:\n";
        $message .= "- " . $product->name . " x" . $request->jumlah . "\n\n";
        $message .= "Nama: " . $request->nama_pemesan . "\n";
        $message .= "WhatsApp: " . $request->nomor_wa . "\n";
        $message .= "Alamat: " . $request->alamat . "\n";
        if ($request->filled('catatan')) {
            $message .= "Catatan: " . $request->catatan . "\n";
        }

        $whatsappUrl = "https://wa.me/" . $storePhone . "?text=" . rawurlencode($message);

        return response()->json([
            'success' => true,
            'whatsapp_url' => $whatsappUrl
        ]);
    }

    public function riwayat()
    {
        $customer = Auth::user();
        $orders = Order::where('customer_id', $customer->id)
            ->with(['items.product', 'store'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.pesanan-saya', compact('orders'));
    }

    public function receive($id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id);
        $order->update(['status' => 'Selesai']);
        return response()->json(['success' => true]);
    }
}
