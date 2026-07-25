<x-layouts.guest title="Tentang Kami | Rintasa">
    <section class="px-5 md:px-7 py-10 md:py-14 max-w-3xl mx-auto text-center">
        <span class="text-accent font-bold text-xs uppercase tracking-wide">Tentang kami</span>
        <h1 class="text-2xl sm:text-3xl font-bold text-ink mt-2 mb-4 leading-snug">
            Menghubungkan UMKM kampus dengan pembeli
        </h1>
        <p class="text-sm sm:text-base text-ink-muted leading-relaxed max-w-2xl mx-auto">
            Rintasa adalah platform kolaborasi BizClub dan BEM untuk membantu UMKM di lingkungan kampus menjangkau lebih banyak pembeli secara digital, tanpa proses ribet — mulai dari cari produk sampai konfirmasi pesanan lewat WhatsApp.
        </p>
    </section>

    {{-- Kolaborasi --}}
    <section class="px-5 md:px-7 pb-10 md:pb-14 max-w-3xl mx-auto">
        <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-10">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white border border-gray-100 flex items-center justify-center overflow-hidden mb-2">
                    <img src="{{ asset('assets/logo/logo-bizclub.png') }}" alt="Logo BizClub" class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
                </div>
                <span class="text-xs font-bold text-ink">BizClub Ubermensch</span>
            </div>
            <i class="ti ti-x text-lg text-ink-muted"></i>
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white border border-gray-100 flex items-center justify-center overflow-hidden mb-2">
                    <img src="{{ asset('assets/logo/logo-bem.png') }}" alt="Logo BEM" class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
                </div>
                <span class="text-xs font-bold text-ink">BEM Nawasena</span>
            </div>
        </div>
        <p class="text-xs sm:text-sm text-ink-muted text-center leading-relaxed mt-4 max-w-xl mx-auto">
            Rintasa lahir dari kolaborasi dua organisasi kemahasiswaan yang percaya bahwa UMKM kampus layak punya panggung digital sendiri.
        </p>
    </section>

    {{-- Visi & Misi --}}
    <section class="px-5 md:px-7 pb-10 md:pb-14 max-w-4xl mx-auto">
        <div class="bg-primary-light rounded-2xl p-6 sm:p-8 text-center mb-6">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center mx-auto mb-3">
                <i class="ti ti-telescope text-xl sm:text-2xl text-primary"></i>
            </div>
            <div class="font-bold text-primary-dark text-xs uppercase tracking-wide mb-2">Visi</div>
            <p class="text-sm sm:text-base text-ink font-bold leading-relaxed max-w-2xl mx-auto">
                Menjadi platform digital terdepan yang menghubungkan UMKM kampus dengan komunitas pembeli, serta mendorong pertumbuhan ekonomi kreatif mahasiswa yang berkelanjutan.
            </p>
        </div>

        <div class="font-bold text-ink text-sm mb-4 text-center">Misi</div>
        <div class="grid sm:grid-cols-2 gap-3 sm:gap-4">
            <div class="flex items-start gap-3 p-4 border border-gray-100 rounded-xl">
                <div class="w-7 h-7 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">1</div>
                <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">Menyediakan platform yang mudah diakses untuk UMKM memasarkan produk secara digital.</p>
            </div>
            <div class="flex items-start gap-3 p-4 border border-gray-100 rounded-xl">
                <div class="w-7 h-7 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">2</div>
                <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">Mempermudah mahasiswa dan staf kampus menemukan produk UMKM lokal terpercaya.</p>
            </div>
            <div class="flex items-start gap-3 p-4 border border-gray-100 rounded-xl">
                <div class="w-7 h-7 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">3</div>
                <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">Mendorong kolaborasi antar organisasi kemahasiswaan dalam mendukung ekonomi kreatif kampus.</p>
            </div>
            <div class="flex items-start gap-3 p-4 border border-gray-100 rounded-xl">
                <div class="w-7 h-7 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center flex-shrink-0">4</div>
                <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">Membangun ekosistem transaksi yang transparan dan saling menguntungkan.</p>
            </div>
        </div>
    </section>

    {{-- Statistik --}}
    <section class="px-5 md:px-7 pb-10 md:pb-14 max-w-4xl mx-auto">
        <div class="grid grid-cols-3 gap-3 sm:gap-4 bg-gray-50 rounded-2xl p-5 sm:p-6">
            <div class="text-center">
                <div class="text-xl sm:text-2xl font-bold text-ink">120+</div>
                <div class="text-xs text-ink-muted">UMKM terdaftar</div>
            </div>
            <div class="text-center">
                <div class="text-xl sm:text-2xl font-bold text-ink">450+</div>
                <div class="text-xs text-ink-muted">Produk aktif</div>
            </div>
            <div class="text-center">
                <div class="text-xl sm:text-2xl font-bold text-ink">4.8</div>
                <div class="text-xs text-ink-muted">Rating rata-rata</div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="px-5 md:px-7 pb-12 md:pb-16 max-w-4xl mx-auto text-center">
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('produk.index') }}" class="bg-primary hover:bg-primary-dark text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-lg transition-colors duration-150">
                Jelajahi produk
            </a>
            <a href="{{ route('register.umkm') }}" class="bg-white text-accent border-2 border-accent hover:bg-accent-light font-bold text-sm sm:text-base px-6 py-3 rounded-lg transition-colors duration-150">
                Daftar sebagai UMKM
            </a>
        </div>
    </section>
</x-layouts.guest>
