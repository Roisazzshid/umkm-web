<footer class="bg-ink px-5 md:px-7 pt-10 md:pt-12 pb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 mb-8 max-w-6xl mx-auto">
        <div class="col-span-2 md:col-span-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center p-1.5">
                    <img src="{{ asset('assets/logo/logo-rintasa.png') }}" alt="Logo Rintasa"
                        class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-sm text-white">Rintasa</span>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed mb-4">
                Platform kolaborasi BizClub dan BEM untuk UMKM kampus.
            </p>
            <div class="flex gap-2">
                <a href="#"
                    class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors duration-150"
                    aria-label="Instagram Rintasa">
                    <i class="ti ti-brand-instagram text-white text-sm"></i>
                </a>
                <a href="#"
                    class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors duration-150"
                    aria-label="WhatsApp Rintasa">
                    <i class="ti ti-brand-whatsapp text-white text-sm"></i>
                </a>
                <a href="#"
                    class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors duration-150"
                    aria-label="TikTok Rintasa">
                    <i class="ti ti-brand-tiktok text-white text-sm"></i>
                </a>
            </div>
        </div>

        <div>
            <div class="font-bold text-xs text-white mb-3.5">Navigasi</div>
            <div class="flex flex-col gap-2.5">
                <a href="{{ route('home') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Beranda</a>
                <a href="{{ route('produk.index') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Produk</a>
                <a href="{{ route('about') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Tentang kami</a>
                <a href="{{ route('register.umkm') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Daftar UMKM</a>
            </div>
        </div>

        <div>
            <div class="font-bold text-xs text-white mb-3.5">Kategori</div>
            <div class="flex flex-col gap-2.5">
                <a href="{{ route('produk.index') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Makanan</a>
                <a href="{{ route('produk.index') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Fashion</a>
                <a href="{{ route('produk.index') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Kerajinan</a>
                <a href="{{ route('produk.index') }}"
                    class="text-xs text-gray-400 hover:text-white transition-colors duration-150">Semua kategori</a>
            </div>
        </div>

        <div class="col-span-2 md:col-span-1">
            <div class="font-bold text-xs text-white mb-3.5">Kontak kami</div>
            <div class="flex flex-col gap-2.5">
                <div class="flex items-center gap-2">
                    <i class="ti ti-mail text-accent text-sm"></i>
                    <span class="text-xs text-gray-400">hello@rintasa.id</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ti ti-brand-whatsapp text-accent text-sm"></i>
                    <span class="text-xs text-gray-400">+62 812-3456-7890</span>
                </div>
            </div>
        </div>
    </div>

    <div
        class="border-t border-white/10 pt-5 max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
        <p class="text-xs text-gray-500 text-center sm:text-left">&copy; {{ date('Y') }} Rintasa. Semua hak
            dilindungi.</p>
        <p class="text-xs text-gray-500">Kerja sama BizClub x BEM</p>
    </div>
</footer>
