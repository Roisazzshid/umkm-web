<nav class="relative flex items-center justify-between px-5 md:px-7 py-4 border-b border-gray-100">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <img src="{{ asset('assets/logo/logo-rintasa.png') }}" alt="Logo Rintasa" class="w-9 h-9 object-contain">
        <span class="font-bold text-ink">Rintasa</span>
    </a>

    <div class="hidden md:flex items-center gap-7">
        <a href="{{ route('home') }}" class="text-sm text-gray-700 hover:text-primary">Beranda</a>
        <a href="{{ route('produk.index') }}" class="text-sm text-gray-700 hover:text-primary">Produk</a>
        <a href="{{ route('about') }}" class="text-sm text-gray-700 hover:text-primary">Tentang kami</a>
    </div>

    <div class="hidden md:flex items-center gap-3">
        @auth
            @if (auth()->user()->role === 'customer')
                <a href="{{ route('pesanan.riwayat') }}"
                    class="flex items-center gap-1.5 text-sm text-ink-muted hover:text-primary font-medium transition-colors duration-150 mr-2"
                    title="Pesanan saya">
                    <i class="ti ti-package text-base"></i> Pesanan Saya
                </a>
            @else
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('umkm.dashboard') }}"
                    class="flex items-center gap-1.5 text-sm text-primary font-semibold hover:text-primary-dark transition-colors duration-150 mr-2">
                    <i class="ti ti-layout-dashboard text-base"></i> Dashboard
                </a>
            @endif
            <button type="button" onclick="document.getElementById('form-logout-guest').submit();"
                class="flex items-center gap-1.5 text-sm text-red-600 font-semibold hover:text-red-700 transition-colors duration-150">
                <i class="ti ti-logout text-base"></i> Keluar
            </button>
        @else
            <a href="{{ route('login') }}"
                class="flex items-center gap-1.5 text-sm text-primary font-semibold hover:text-primary-dark transition-colors duration-150">
                <i class="ti ti-login-2 text-base"></i> Masuk
            </a>
            <a href="{{ route('register.umkm') }}"
                class="bg-accent hover:bg-accent-dark text-white text-sm font-semibold px-4 py-2.5 rounded-lg flex items-center gap-1.5 transition-colors duration-150">
                <i class="ti ti-building-store text-base"></i> Daftar sebagai UMKM
            </a>
        @endauth
    </div>

    <button id="navbar-toggle" class="md:hidden text-ink text-2xl" aria-label="Buka menu" aria-expanded="false">
        <i class="ti ti-menu-2" id="navbar-toggle-icon"></i>
    </button>

    <div id="navbar-mobile"
        class="hidden md:hidden absolute top-full left-0 right-0 bg-white border-b border-gray-100 px-5 py-4 flex flex-col gap-4 z-50 shadow-sm">
        <a href="{{ route('home') }}" class="text-sm text-gray-700">Beranda</a>
        <a href="{{ route('produk.index') }}" class="text-sm text-gray-700">Produk</a>
        <a href="{{ route('about') }}" class="text-sm text-gray-700">Tentang kami</a>
        <div class="border-t border-gray-100 pt-4 flex flex-col gap-3">
            @auth
                @if (auth()->user()->role === 'customer')
                    <a href="{{ route('pesanan.riwayat') }}" class="text-sm text-gray-700 flex items-center gap-2">
                        <i class="ti ti-package text-base"></i> Pesanan saya
                    </a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('umkm.dashboard') }}" class="text-sm text-gray-700 flex items-center gap-2">
                        <i class="ti ti-layout-dashboard text-base"></i> Dashboard
                    </a>
                @endif
                <button type="button" onclick="document.getElementById('form-logout-guest').submit();" class="flex items-center gap-1.5 text-sm text-red-600 font-semibold text-left">
                    <i class="ti ti-logout text-base"></i> Keluar
                </button>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-sm text-primary font-semibold">
                    <i class="ti ti-login-2 text-base"></i> Masuk
                </a>
                <a href="{{ route('register.umkm') }}"
                    class="bg-accent text-white text-sm font-semibold px-4 py-2.5 rounded-lg flex items-center justify-center gap-1.5">
                    <i class="ti ti-building-store text-base"></i> Daftar sebagai UMKM
                </a>
            @endauth
        </div>
    </div>

    <form id="form-logout-guest" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</nav>

<script>
    document.getElementById('navbar-toggle')?.addEventListener('click', function() {
        const menu = document.getElementById('navbar-mobile');
        const icon = document.getElementById('navbar-toggle-icon');
        const isOpen = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden');
        this.setAttribute('aria-expanded', String(!isOpen));
        icon.className = isOpen ? 'ti ti-menu-2' : 'ti ti-x';
    });
</script>
