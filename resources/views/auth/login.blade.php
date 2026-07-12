<x-layouts.auth title="Masuk | Rintasa">
    <div class="max-w-sm mx-auto bg-white border border-gray-100 rounded-2xl p-6 sm:p-8">
        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-1.5 text-center">Masuk ke akun kamu</h1>
        <p class="text-sm text-ink-muted text-center mb-6">Masuk untuk pesan produk dari UMKM favoritmu</p>

        @php
            $statusAkun = request()->query('status');
        @endphp

        @if ($statusAkun === 'menunggu')
            <div
                class="bg-accent-light border border-orange-200 text-orange-800 text-sm rounded-lg p-3.5 mb-4 flex items-start gap-2.5">
                <i class="ti ti-clock text-base mt-0.5 flex-shrink-0"></i>
                <span>Akun UMKM kamu masih menunggu verifikasi admin. Biasanya diproses 1-2 hari kerja.</span>
            </div>
        @elseif ($statusAkun === 'disetujui')
            <div
                class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-3.5 mb-4 flex items-start gap-2.5">
                <i class="ti ti-circle-check text-base mt-0.5 flex-shrink-0"></i>
                <span>Akun UMKM kamu sudah disetujui. Silakan masuk untuk mulai berjualan di Rintasa.</span>
            </div>
        @elseif ($statusAkun === 'ditolak')
            <div
                class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3.5 mb-4 flex items-start gap-2.5">
                <i class="ti ti-alert-circle text-base mt-0.5 flex-shrink-0"></i>
                <span>Pendaftaran UMKM kamu ditolak. <a href="{{ route('register.umkm') }}"
                        class="font-bold underline">Daftar ulang</a> dengan melengkapi data yang benar.</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3.5 mb-4 flex items-start gap-2.5">
                <i class="ti ti-alert-circle text-base mt-0.5 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username kamu" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>
            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div class="flex items-center justify-between text-xs sm:text-sm">
                <label class="flex items-center gap-2 text-ink-muted">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                    Ingat saya
                </label>
                <a href="{{ route('password.request') }}"
                    class="text-primary font-semibold hover:text-primary-dark">Lupa password?</a>
            </div>

            <button type="submit"
                class="w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm sm:text-base py-3 rounded-lg transition-colors duration-150">
                Masuk
            </button>
        </form>

        <p class="text-xs sm:text-sm text-ink-muted text-center mt-6">
            Belum punya akun? <a href="{{ route('register') }}"
                class="text-primary font-bold hover:text-primary-dark">Daftar di sini</a>
        </p>

        <p class="text-center text-xs text-ink-muted mt-5">
            Punya UMKM? <a href="{{ route('register.umkm') }}"
                class="text-accent font-bold hover:text-accent-dark">Daftar sebagai mitra</a>
        </p>
    </div>
</x-layouts.auth>
