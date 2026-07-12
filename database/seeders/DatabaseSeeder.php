<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@rintasa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Kantor Rintasa, Jakarta',
        ]);

        // 2. Create UMKM Users
        $umkm1 = User::create([
            'name' => 'Sari Wulandari',
            'username' => 'kopisenja',
            'email' => 'kopisenja@email.com',
            'password' => Hash::make('password'),
            'role' => 'umkm',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 8, Klaten, Jawa Tengah',
        ]);

        $umkm2 = User::create([
            'name' => 'Aruna Kusuma',
            'username' => 'batikaruna',
            'email' => 'batikaruna@email.com',
            'password' => Hash::make('password'),
            'role' => 'umkm',
            'phone' => '087712345678',
            'address' => 'Kawasan Batik Kauman, Solo',
        ]);

        $umkm3 = User::create([
            'name' => 'Bunda Maria',
            'username' => 'rajutbunda',
            'email' => 'rajutbunda@email.com',
            'password' => Hash::make('password'),
            'role' => 'umkm',
            'phone' => '089987654321',
            'address' => 'Kec. Mlati, Sleman, Yogyakarta',
        ]);

        // 3. Create Stores
        $store1 = Store::create([
            'user_id' => $umkm1->id,
            'name' => 'Kopi Senja',
            'owner_name' => 'Sari Wulandari',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 8, Klaten, Jawa Tengah',
            'description' => 'Kopi Senja menyajikan kopi robusta dan arabika pilihan langsung dari petani lokal, diracik segar setiap hari.',
            'logo' => null,
            'status' => 'Aktif',
        ]);

        $store2 = Store::create([
            'user_id' => $umkm2->id,
            'name' => 'Batik Aruna',
            'owner_name' => 'Aruna Kusuma',
            'phone' => '087712345678',
            'address' => 'Kawasan Batik Kauman, Solo',
            'description' => 'Batik Aruna memproduksi batik tulis dan cap premium dengan pewarna alam ramah lingkungan.',
            'logo' => null,
            'status' => 'Menunggu',
        ]);

        $store3 = Store::create([
            'user_id' => $umkm3->id,
            'name' => 'Rajut Bunda',
            'owner_name' => 'Bunda Maria',
            'phone' => '089987654321',
            'address' => 'Kec. Mlati, Sleman, Yogyakarta',
            'description' => 'Kerajinan rajut buatan tangan yang dibuat dengan penuh kasih sayang untuk kebutuhan bayi, pakaian, hingga dekorasi rumah.',
            'logo' => null,
            'status' => 'Nonaktif',
        ]);

        // 4. Create Customers
        $cust1 = User::create([
            'name' => 'Dewi Anjani',
            'username' => 'dewi',
            'email' => 'dewi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '08122334455',
            'address' => 'Kost Sendowo, Sleman, DIY',
        ]);

        $cust2 = User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '08566778899',
            'address' => 'Sleman, Yogyakarta',
        ]);

        // 5. Create Categories
        $categories = [
            'Makanan' => Category::create(['name' => 'Makanan', 'slug' => 'makanan']),
            'Minuman' => Category::create(['name' => 'Minuman', 'slug' => 'minuman']),
            'Fashion' => Category::create(['name' => 'Fashion', 'slug' => 'fashion']),
            'Kerajinan' => Category::create(['name' => 'Kerajinan', 'slug' => 'kerajinan']),
            'Aksesoris' => Category::create(['name' => 'Aksesoris', 'slug' => 'aksesoris']),
        ];

        // 6. Create Products
        // Products for Kopi Senja
        $p1 = Product::create([
            'store_id' => $store1->id,
            'category_id' => $categories['Minuman']->id,
            'name' => 'Es Kopi Kekinian',
            'slug' => 'es-kopi-kekinian',
            'price' => 15000,
            'description' => 'Kopi susu dengan racikan sirup rahasia yang manis, dingin, dan segar.',
            'image' => null,
        ]);

        $p2 = Product::create([
            'store_id' => $store1->id,
            'category_id' => $categories['Minuman']->id,
            'name' => 'Kopi Susu Gula Aren',
            'slug' => 'kopi-susu-gula-aren',
            'price' => 18000,
            'description' => 'Kopi espresso robusta dipadu susu segar dan gula aren murni premium.',
            'image' => null,
        ]);

        $p3 = Product::create([
            'store_id' => $store1->id,
            'category_id' => $categories['Minuman']->id,
            'name' => 'Kopi Robusta Special',
            'slug' => 'kopi-robusta-special',
            'price' => 25000,
            'description' => 'Kopi robusta kualitas terbaik dengan metode seduh manual brew.',
            'image' => null,
        ]);

        // Products for Batik Aruna
        $p4 = Product::create([
            'store_id' => $store2->id,
            'category_id' => $categories['Fashion']->id,
            'name' => 'Batik Tulis Motif Parang',
            'slug' => 'batik-tulis-motif-parang',
            'price' => 250000,
            'description' => 'Batik tulis sutra motif parang klasik warna soga alam.',
            'image' => null,
        ]);

        // Products for Rajut Bunda
        $p5 = Product::create([
            'store_id' => $store3->id,
            'category_id' => $categories['Kerajinan']->id,
            'name' => 'Tas Rajut Cantik',
            'slug' => 'tas-rajut-cantik',
            'price' => 85000,
            'description' => 'Tas rajut serbaguna benang nylon berkualitas tinggi, awet dan modis.',
            'image' => null,
        ]);

        // 7. Create Orders & Items (Historical data for 6 months back)
        $months = [
            Carbon::now()->subMonths(5),
            Carbon::now()->subMonths(4),
            Carbon::now()->subMonths(3),
            Carbon::now()->subMonths(2),
            Carbon::now()->subMonths(1),
            Carbon::now(),
        ];

        // Store 1 Orders
        $orderCounts = [12, 16, 14, 20, 24, 30]; // Trend orders for Kopi Senja
        foreach ($months as $idx => $month) {
            $count = $orderCounts[$idx];
            for ($k = 0; $k < $count; $k++) {
                $orderTime = (clone $month)->subDays(rand(1, 28))->subHours(rand(1, 12));
                $qty1 = rand(1, 3);
                $qty2 = rand(1, 2);
                $total = ($p1->price * $qty1) + ($p2->price * $qty2);

                $order = Order::create([
                    'customer_id' => $cust1->id,
                    'store_id' => $store1->id,
                    'customer_name' => $cust1->name,
                    'customer_phone' => $cust1->phone,
                    'customer_address' => $cust1->address,
                    'notes' => 'Tolong buat manis sedang',
                    'total_price' => $total,
                    'created_at' => $orderTime,
                    'updated_at' => $orderTime,
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p1->id,
                    'product_name' => $p1->name,
                    'product_price' => $p1->price,
                    'quantity' => $qty1,
                    'subtotal' => $p1->price * $qty1,
                    'created_at' => $orderTime,
                    'updated_at' => $orderTime,
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p2->id,
                    'product_name' => $p2->name,
                    'product_price' => $p2->price,
                    'quantity' => $qty2,
                    'subtotal' => $p2->price * $qty2,
                    'created_at' => $orderTime,
                    'updated_at' => $orderTime,
                ]);
            }
        }

        // Store 2 Orders (a few orders for Batik Aruna)
        for ($i = 0; $i < 5; $i++) {
            $orderTime = Carbon::now()->subDays(rand(1, 30));
            $order = Order::create([
                'customer_id' => $cust2->id,
                'store_id' => $store2->id,
                'customer_name' => $cust2->name,
                'customer_phone' => $cust2->phone,
                'customer_address' => $cust2->address,
                'notes' => 'Kirim rapi',
                'total_price' => $p4->price,
                'created_at' => $orderTime,
                'updated_at' => $orderTime,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p4->id,
                'product_name' => $p4->name,
                'product_price' => $p4->price,
                'quantity' => 1,
                'subtotal' => $p4->price,
                'created_at' => $orderTime,
                'updated_at' => $orderTime,
            ]);
        }

        // 8. Create Reviews
        Review::create([
            'customer_id' => $cust1->id,
            'product_id' => $p1->id,
            'rating' => 5,
            'comment' => 'Kopinya mantap sekali! Sangat segar.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        Review::create([
            'customer_id' => $cust2->id,
            'product_id' => $p1->id,
            'rating' => 4,
            'comment' => 'Enak, cuma agak sedikit kemanisan untuk seleraku.',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        Review::create([
            'customer_id' => $cust1->id,
            'product_id' => $p2->id,
            'rating' => 5,
            'comment' => 'Kopi susu arennya terbaik se-Klaten, langganan terus!',
            'created_at' => Carbon::now()->subDays(1),
        ]);
    }
}
