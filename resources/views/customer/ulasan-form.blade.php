<x-layouts.guest title="Beri Ulasan | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-2xl mx-auto">
        <nav class="text-xs text-ink-muted mb-5">
            <a href="{{ route('pesanan.riwayat') }}" class="hover:text-primary">Pesanan saya</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">Beri ulasan</span>
        </nav>

        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-6">Beri ulasan</h1>

        <div class="flex items-center gap-3 p-3 sm:p-4 border border-gray-100 rounded-xl mb-7">
            <div
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-primary-light flex items-center justify-center flex-shrink-0">
                <i class="ti ti-photo text-xl sm:text-2xl text-white"></i>
            </div>
            <div class="min-w-0">
                <div class="font-bold text-ink text-sm sm:text-base truncate">Batik tulis motif parang</div>
                <div class="text-xs sm:text-sm text-ink-muted truncate">Batik Aruna &middot; 1x</div>
                <div class="flex items-center gap-1 text-xs text-ink-muted mt-0.5">
                    <i class="ti ti-calendar text-xs"></i> Dipesan 3 Jul 2026
                </div>
            </div>
        </div>

        <form id="form-ulasan">
            <div class="mb-6 text-center">
                <label class="block font-bold text-ink text-sm mb-3">Gimana kualitas produknya?</label>
                <div id="star-rating" class="flex items-center justify-center gap-1.5 sm:gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" data-star="{{ $i }}"
                            class="text-3xl sm:text-4xl text-gray-200 hover:scale-110 transition-transform duration-150"
                            aria-label="Beri {{ $i }} bintang">
                            <i class="ti ti-star"></i>
                        </button>
                    @endfor
                </div>
                <input type="hidden" id="rating_value" value="0">
                <p id="rating-text" class="text-xs text-ink-muted mt-2">Ketuk bintang untuk memberi nilai</p>
            </div>

            <div class="mb-6">
                <label class="block font-bold text-ink text-sm mb-2">Ceritakan pengalamanmu <span
                        class="font-normal text-ink-muted">(opsional)</span></label>
                <textarea id="ulasan_teks" rows="4" placeholder="Contoh: Kualitas bagus, pengiriman cepat, sesuai deskripsi..."
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150"></textarea>
            </div>

            <div id="notif-gagal-ulasan"
                class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-4 mb-5 flex items-center gap-2.5">
                <i class="ti ti-alert-circle text-lg flex-shrink-0"></i>
                <span>Pilih rating bintang terlebih dahulu.</span>
            </div>

            <button type="submit"
                class="w-full bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base py-3.5 rounded-lg transition-colors duration-150">
                Kirim ulasan
            </button>
        </form>

        <div id="ulasan-berhasil" class="hidden text-center py-8">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-circle-check text-3xl text-green-600"></i>
            </div>
            <h2 class="font-bold text-ink text-lg mb-1.5">Terima kasih atas ulasannya!</h2>
            <p class="text-sm text-ink-muted mb-6">Ulasan kamu membantu UMKM ini berkembang lebih baik.</p>
            <a href="{{ route('pesanan.riwayat') }}"
                class="inline-block bg-primary hover:bg-primary-dark text-white font-bold text-sm px-6 py-3 rounded-lg transition-colors duration-150">
                Kembali ke pesanan saya
            </a>
        </div>
    </section>

    <script>
        (function() {
            const stars = document.querySelectorAll('[data-star]');
            const ratingValue = document.getElementById('rating_value');
            const ratingText = document.getElementById('rating-text');
            const labels = ['', 'Kurang', 'Cukup', 'Baik', 'Sangat baik', 'Luar biasa'];

            function renderStars(value) {
                stars.forEach(function(star) {
                    const isActive = parseInt(star.dataset.star) <= value;
                    star.classList.toggle('text-accent', isActive);
                    star.classList.toggle('text-gray-200', !isActive);
                });
            }

            stars.forEach(function(star) {
                star.addEventListener('click', function() {
                    const value = parseInt(star.dataset.star);
                    ratingValue.value = value;
                    renderStars(value);
                    ratingText.textContent = labels[value];
                });
            });

            document.getElementById('form-ulasan').addEventListener('submit', function(e) {
                e.preventDefault();

                const notifGagal = document.getElementById('notif-gagal-ulasan');

                if (parseInt(ratingValue.value) === 0) {
                    notifGagal.classList.remove('hidden');
                    return;
                }

                notifGagal.classList.add('hidden');
                document.getElementById('form-ulasan').classList.add('hidden');
                document.getElementById('ulasan-berhasil').classList.remove('hidden');
            });
        })();
    </script>
</x-layouts.guest>
