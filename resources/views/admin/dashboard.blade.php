<x-layouts.admin title="Dashboard admin | Rintasa">
    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-5">Dashboard admin</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <x-stat-card icon="ti-building-store" value="{{ number_format($totalUMKM, 0, ',', '.') }}" label="Total UMKM" />
        <x-stat-card icon="ti-users" value="{{ number_format($totalCustomer, 0, ',', '.') }}" label="Total customer" />
        <x-stat-card icon="ti-package" value="{{ number_format($totalProduct, 0, ',', '.') }}" label="Total produk" />
        <x-stat-card icon="ti-shopping-cart" value="{{ number_format($totalOrder, 0, ',', '.') }}" label="Total pesanan" icon-color="text-accent" />
    </div>

    <div class="font-bold text-ink text-base mb-4">Menunggu verifikasi</div>
    <div class="border border-gray-100 rounded-xl overflow-hidden">
        <div class="hidden sm:grid grid-cols-[1fr_1fr_120px] px-4 py-3 bg-gray-50 text-xs font-bold text-ink-muted">
            <span>Nama UMKM</span><span>Tanggal daftar</span><span>Aksi</span>
        </div>
        @forelse ($pendingStores as $store)
            <div class="flex sm:grid sm:grid-cols-[1fr_1fr_120px] px-4 py-3 border-t border-gray-100 items-center gap-3 sm:gap-4">
                <span class="font-bold text-ink text-sm flex-1 min-w-0 truncate">{{ $store->name }}</span>
                <span class="hidden sm:block text-ink-muted text-sm">{{ $store->created_at->format('j M Y') }}</span>
                <a href="{{ route('admin.umkm.verifikasi', $store->id) }}?status=Menunggu"
                    class="bg-accent hover:bg-accent-dark text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors duration-150 text-center flex-shrink-0 sm:w-fit">Tinjau</a>
            </div>
        @empty
            <div class="px-4 py-6 text-center text-sm text-ink-muted bg-white">
                Tidak ada UMKM yang menunggu verifikasi saat ini.
            </div>
        @endforelse
    </div>
</x-layouts.admin>
