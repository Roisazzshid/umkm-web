<x-layouts.guest title="Rintasa - Platform UMKM Kampus">

    {{-- Hero --}}
    <section class="px-5 md:px-7 py-10 md:py-16 bg-gradient-to-br from-primary-light via-white to-accent-light">
        <div class="grid md:grid-cols-2 gap-8 items-center max-w-6xl mx-auto">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-ink leading-snug mb-3.5">
                    Dukung UMKM kampus, pesan langsung lewat <span class="text-accent">WhatsApp</span>
                </h1>
                <p class="text-base text-ink-muted leading-relaxed mb-7">
                    Temukan produk dari mitra UMKM terdaftar, pilih jumlah yang kamu mau, lalu pesan langsung tanpa
                    ribet.
                </p>
                <div class="flex flex-col sm:flex-row gap-3.5">
                    <a href="{{ route('produk.index') }}"
                        class="bg-primary hover:bg-primary-dark text-white font-bold text-base px-6 py-3.5 rounded-lg text-center transition-colors duration-150">
                        Jelajahi produk
                    </a>
                    <a href="{{ route('register.umkm') }}"
                        class="bg-white text-accent border-2 border-accent hover:bg-accent-light font-bold text-base px-6 py-3 rounded-lg text-center transition-colors duration-150">
                        Gabung jadi mitra
                    </a>
                </div>
                <div class="flex gap-6 sm:gap-8 mt-9 pt-6 border-t border-gray-200/60 flex-wrap">
                    <div>
                        <div class="text-xl font-bold text-ink">{{ $totalStores }}+</div>
                        <div class="text-xs text-ink-muted">UMKM terdaftar</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-ink">{{ $totalProducts }}+</div>
                        <div class="text-xs text-ink-muted">Produk aktif</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-ink">{{ number_format($avgRating, 1, '.', ',') }}</div>
                        <div class="text-xs text-ink-muted">Rating rata-rata</div>
                    </div>
                </div>
            </div>
            <div class="bg-white/60 rounded-2xl h-56 sm:h-72 flex items-center justify-center">
                <i class="ti ti-photo text-5xl text-primary/40"></i>
            </div>
        </div>
    </section>

    {{-- Cara Pesan --}}
    <section class="px-5 md:px-7 py-10 md:py-14 bg-gray-50">
        <h2 class="text-lg sm:text-xl font-bold text-ink text-center mb-8 md:mb-10 max-w-6xl mx-auto">Cara pesan, mudah
            dan cepat</h2>
        <div class="relative grid grid-cols-3 gap-3 sm:gap-8 max-w-4xl mx-auto">
            <div class="hidden sm:block absolute top-8 sm:top-9 left-[16%] right-[16%] h-0.5"
                style="background-image: repeating-linear-gradient(to right, #B5D4F4 0, #B5D4F4 6px, transparent 6px, transparent 12px);">
            </div>
            <x-step-card icon="ti-shopping-bag" nomor="1" title="Pilih produk"
                desc="Atur jumlah pakai tombol plus minus" />
            <x-step-card icon="ti-clipboard-list" nomor="2" title="Isi form pesanan"
                desc="Data otomatis terisi, tinggal dicek" />
            <x-step-card icon="ti-brand-whatsapp" nomor="3" title="Konfirmasi WhatsApp"
                desc="Toko hubungi kamu untuk bayar dan kirim" />
        </div>
    </section>

    {{-- Produk Pilihan --}}
    <section class="px-5 md:px-7 py-10 md:py-12 max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-ink">Produk pilihan</h2>
            <a href="{{ route('produk.index') }}"
                class="text-sm text-primary hover:text-primary-dark font-semibold transition-colors duration-150">Lihat
                semua &rarr;</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
            @foreach ($featuredProducts as $prod)
                <x-produk-card
                    :id="$prod->id"
                    :nama="$prod->name"
                    :kategori="$prod->category->name"
                    :harga="$prod->price"
                    :lokasi="explode(',', $prod->store->address)[0]"
                    :rating="$prod->rating"
                    :terjual="$prod->sold_count" />
            @endforeach
        </div>
    </section>

    {{-- UMKM Populer --}}
    <section class="px-5 md:px-7 py-10 md:py-12 max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-ink">UMKM populer</h2>
            <a href="{{ route('umkm.list') }}"
                class="text-sm text-primary hover:text-primary-dark font-semibold transition-colors duration-150">Lihat
                semua &rarr;</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
            @foreach ($popularStores as $st)
                <x-umkm-card
                    :id="$st->id"
                    :nama="$st->name"
                    :kategori="$st->category_name"
                    :lokasi="explode(',', $st->address)[0]"
                    :rating="$st->rating"
                    :jumlah-produk="$st->products_count" />
            @endforeach
        </div>
    </section>

    {{-- Tentang Kami & CTA Mitra --}}
    <section class="px-5 md:px-7 py-12 md:py-16 pb-16 md:pb-20 max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-8 md:gap-10 items-start">
            <div>
                <span class="text-accent font-bold text-xs uppercase tracking-wide">Tentang kami</span>
                <h2 class="text-xl sm:text-2xl font-bold text-ink mt-2 mb-3 leading-snug">
                    Kolaborasi BizClub dan BEM untuk UMKM kampus
                </h2>
                <p class="text-sm text-ink-muted leading-relaxed mb-6">
                    Rintasa lahir dari kerja sama BizClub dan BEM untuk membantu UMKM di lingkungan kampus menjangkau
                    lebih banyak pembeli secara digital, tanpa proses ribet.
                </p>

                <div class="flex flex-col gap-3 mb-6">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-receipt-2 text-primary text-sm sm:text-base"></i>
                        </div>
                        <span class="font-bold text-ink text-xs sm:text-sm">Gratis daftar, tanpa komisi
                            tersembunyi</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-users text-primary text-sm sm:text-base"></i>
                        </div>
                        <span class="font-bold text-ink text-xs sm:text-sm">Jangkau ribuan mahasiswa dan staf
                            kampus</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-chart-bar text-primary text-sm sm:text-base"></i>
                        </div>
                        <span class="font-bold text-ink text-xs sm:text-sm">Laporan performa toko real-time</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="font-bold text-ink text-sm mb-2.5">Cara bergabung</div>
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-5 h-5 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">
                                1</div>
                            <span class="text-xs sm:text-sm text-ink-muted">Daftar akun UMKM gratis</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-5 h-5 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">
                                2</div>
                            <span class="text-xs sm:text-sm text-ink-muted">Tunggu verifikasi dari admin</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-5 h-5 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">
                                3</div>
                            <span class="text-xs sm:text-sm text-ink-muted">Upload produk dan foto</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-5 h-5 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">
                                4</div>
                            <span class="text-xs sm:text-sm text-ink-muted">Mulai terima pesanan</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('register.umkm') }}"
                        class="inline-block bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-lg text-center transition-colors duration-150">
                        Daftar sebagai UMKM
                    </a>
                    <a href="{{ route('about') }}"
                        class="inline-block bg-white text-primary border-2 border-primary hover:bg-primary-light font-bold text-sm sm:text-base px-6 py-3 rounded-lg text-center transition-colors duration-150">
                        Pelajari tentang kami
                    </a>
                </div>
            </div>

            <div class="mb-8 md:mb-0">
                <div class="bg-primary-light rounded-2xl h-56 sm:h-64 flex items-center justify-center">
                    <i class="ti ti-photo text-4xl sm:text-5xl text-white"></i>
                </div>

                <div class="relative z-10 mx-3 sm:mx-4 -mt-6 bg-white border border-gray-100 rounded-xl p-3.5 sm:p-4">
                    <div class="flex items-center gap-2 mb-2.5">
                        <div class="w-7 h-7 rounded-full bg-accent-light flex items-center justify-center">
                            <i class="ti ti-building-store text-accent text-sm"></i>
                        </div>
                        <span class="font-bold text-ink text-xs">Mitra Rintasa</span>
                    </div>
                    <div class="flex gap-6">
                        <div>
                            <div class="font-bold text-ink text-sm sm:text-base">120+</div>
                            <div class="text-[11px] text-ink-muted">UMKM gabung</div>
                        </div>
                        <div>
                            <div class="font-bold text-ink text-sm sm:text-base">4.8</div>
                            <div class="text-[11px] text-ink-muted">Rating rata-rata</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="font-bold text-ink text-sm mb-3">Kontak kami</div>
                    <div class="flex flex-col gap-2.5">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-mail text-primary text-sm"></i>
                            </div>
                            <span class="text-xs sm:text-sm text-ink-muted">hello@rintasa.id</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-brand-whatsapp text-primary text-sm"></i>
                            </div>
                            <span class="text-xs sm:text-sm text-ink-muted">+62 812-3456-7890</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0">
                                <i class="ti ti-brand-instagram text-primary text-sm"></i>
                            </div>
                            <span class="text-xs sm:text-sm text-ink-muted">@rintasa.kampus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.guest>
