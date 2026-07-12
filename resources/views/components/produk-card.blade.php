@props(['id' => 1, 'nama', 'kategori', 'harga', 'lokasi', 'rating', 'terjual'])

<div class="bg-white border border-gray-100 rounded-xl overflow-hidden flex flex-col h-full hover:border-primary hover:shadow-sm transition-all duration-150">
    <a href="{{ route('produk.show', $id) }}" class="relative h-32 sm:h-40 bg-primary-light flex items-center justify-center">
        <span class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 bg-accent text-white text-xs font-bold px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-md">
            {{ $kategori }}
        </span>
        <i class="ti ti-photo text-2xl sm:text-3xl text-white"></i>
    </a>
    <div class="p-3 sm:p-4 flex flex-col flex-1">
        <a href="{{ route('produk.show', $id) }}" class="font-bold text-ink text-xs sm:text-sm mb-1.5 hover:text-primary transition-colors duration-150">{{ $nama }}</a>
        <div class="flex items-center gap-1 text-xs text-ink-muted mb-1.5">
            <i class="ti ti-star text-accent text-xs"></i> {{ $rating }} &middot; {{ $terjual }} terjual
        </div>
        <div class="font-bold text-ink text-sm sm:text-base mb-1.5">Rp {{ number_format($harga, 0, ',', '.') }}</div>
        <div class="flex items-center gap-1 text-xs text-ink-muted mb-3">
            <i class="ti ti-map-pin text-xs"></i> {{ $lokasi }}
        </div>
        <a href="{{ route('produk.show', $id) }}" class="block bg-accent hover:bg-accent-dark text-white text-xs sm:text-sm font-bold text-center py-2 sm:py-2.5 rounded-lg transition-colors duration-150 mt-auto">
            Pesan sekarang
        </a>
    </div>
</div>
