<x-layouts.guest title="Detail Produk | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-6xl mx-auto">
        <nav class="text-xs text-ink-muted mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('produk.index') }}" class="hover:text-primary">Produk</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">{{ $product->name }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-6 md:gap-10">
            <div class="bg-primary-light rounded-2xl h-64 sm:h-80 md:h-96 flex items-center justify-center overflow-hidden">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                @else
                    <i class="ti ti-photo text-5xl text-white"></i>
                @endif
            </div>

            <div>
                <span class="inline-block bg-accent-light text-orange-800 text-xs font-bold px-3 py-1.5 rounded-full mb-3">{{ $product->category->name }}</span>
                <h1 class="text-xl sm:text-2xl font-bold text-ink mb-2 leading-snug">{{ $product->name }}</h1>

                <div class="flex items-center gap-2 mb-4">
                    <div class="flex items-center gap-1.5 text-sm text-ink-muted">
                        <i class="ti ti-star text-accent text-sm"></i> {{ number_format($product->rating, 1, '.', ',') }}
                        <span class="text-gray-300">|</span> {{ $product->sold_count }} terjual
                    </div>
                </div>

                <div class="text-2xl sm:text-3xl font-bold text-ink mb-5">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <a href="{{ route('toko.show', $product->store_id) }}" class="flex items-center gap-2.5 p-3 border border-gray-100 rounded-lg mb-6 hover:border-primary transition-colors duration-150">
                    <div class="w-9 h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if ($product->store->logo)
                            <img src="{{ asset('storage/' . $product->store->logo) }}" class="w-full h-full object-cover">
                        @else
                            <i class="ti ti-building-store text-primary text-sm"></i>
                        @endif
                    </div>
                    <div>
                        <div class="font-bold text-ink text-sm">{{ $product->store->name }}</div>
                        <div class="flex items-center gap-1 text-xs text-ink-muted">
                            <i class="ti ti-map-pin text-xs"></i> {{ explode(',', $product->store->address)[0] }}
                        </div>
                    </div>
                    <i class="ti ti-chevron-right text-ink-muted ml-auto"></i>
                </a>

                <form action="{{ route('pesanan.create', $product->id) }}" method="GET">
                    <div class="mb-6">
                        <div class="font-bold text-ink text-sm mb-2.5">Jumlah</div>
                        <x-qty-stepper name="jumlah" :value="1" :min="1" :max="20" />
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base px-8 py-3.5 rounded-lg transition-colors duration-150">
                        Pesan sekarang
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-10 md:mt-14 border-t border-gray-100 pt-8">
            <h2 class="font-bold text-ink text-base mb-3">Deskripsi produk</h2>
            <p class="text-sm text-ink-muted leading-relaxed">
                {{ $product->description }}
            </p>
        </div>
    </section>
</x-layouts.guest>
