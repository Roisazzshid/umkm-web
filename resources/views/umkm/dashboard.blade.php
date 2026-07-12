<x-layouts.umkm title="Dashboard toko | Rintasa">
    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-5">Dashboard toko</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <x-stat-card icon="ti-package" value="{{ number_format($totalProduct, 0, ',', '.') }}" label="Produk aktif" />
        <x-stat-card icon="ti-shopping-cart" value="{{ number_format($totalOrder, 0, ',', '.') }}" label="Pesanan masuk" />
        <x-stat-card icon="ti-truck-delivery" value="{{ number_format($totalSold, 0, ',', '.') }}" label="Produk terjual" />
        <x-stat-card icon="ti-star" value="{{ number_format($averageRating, 1, '.', ',') }}" label="Rating toko" icon-color="text-accent" />
    </div>

    <div class="font-bold text-ink text-base mb-4">Ulasan terbaru</div>
    <div class="space-y-3">
        @forelse ($recentReviews as $rev)
            <div class="border border-gray-100 rounded-xl p-4">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="font-bold text-ink text-sm">{{ $rev->customer->name }}</span>
                    <span class="flex items-center gap-1 text-xs text-accent">
                        <i class="ti ti-star"></i> {{ number_format($rev->rating, 1, '.', ',') }}
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted mb-1">{{ $rev->comment }}</p>
                <div class="text-2xs text-ink-muted mt-1">{{ $rev->product->name }} &middot; {{ $rev->created_at->format('j M Y') }}</div>
            </div>
        @empty
            <div class="p-5 text-center text-sm text-ink-muted border border-gray-100 rounded-xl">
                Belum ada ulasan untuk produk Anda.
            </div>
        @endforelse
    </div>
</x-layouts.umkm>
