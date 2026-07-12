<x-layouts.guest title="Konfirmasi Pesanan | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-3xl mx-auto">
        <nav class="text-xs text-ink-muted mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('produk.show', $product->id) }}" class="hover:text-primary">{{ $product->name }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">Form pemesanan</span>
        </nav>

        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-6">Konfirmasi pesanan</h1>

        <div class="flex items-center gap-3 p-3 sm:p-4 border border-gray-100 rounded-xl mb-6">
            <div
                class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-primary-light flex items-center justify-center flex-shrink-0 overflow-hidden">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                @else
                    <i class="ti ti-photo text-xl sm:text-2xl text-white"></i>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-ink text-sm sm:text-base truncate">{{ $product->name }}</div>
                <div class="text-xs sm:text-sm text-ink-muted">{{ $product->store->name }} &middot; {{ explode(',', $product->store->address)[0] }}</div>
            </div>
            <div class="text-right flex-shrink-0">
                <div id="qty-display" class="text-xs sm:text-sm text-ink-muted">{{ $jumlah }}x</div>
                <div id="subtotal-display" class="font-bold text-ink text-sm sm:text-base">Rp {{ number_format($product->price * $jumlah, 0, ',', '.') }}</div>
            </div>
        </div>

        <form id="form-pesanan" class="space-y-5">
            @csrf
            <input type="hidden" name="jumlah" value="{{ $jumlah }}">

            <div>
                <label class="block font-bold text-ink text-sm mb-2">Nama pemesan</label>
                <input type="text" id="nama_pemesan" name="nama_pemesan" value="{{ $customer->name }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>
            <div>
                <label class="block font-bold text-ink text-sm mb-2">Nomor WhatsApp</label>
                <input type="tel" id="nomor_wa" name="nomor_wa" value="{{ $customer->phone }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>
            <div>
                <label class="block font-bold text-ink text-sm mb-2">Alamat tujuan</label>
                <textarea id="alamat" name="alamat" rows="3" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">{{ $customer->address }}</textarea>
            </div>
            <div>
                <label class="block font-bold text-ink text-sm mb-2">Catatan tambahan <span
                        class="font-normal text-ink-muted">(opsional)</span></label>
                <textarea id="catatan" name="catatan" rows="2" placeholder="Contoh: pedas level 3, warna biru"
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150"></textarea>
            </div>

            <div class="bg-primary-light rounded-lg p-3.5 flex items-start gap-2.5">
                <i class="ti ti-info-circle text-primary text-base mt-0.5"></i>
                <p class="text-xs text-primary-dark leading-relaxed">Data di atas otomatis terisi dari akun kamu dan
                    bisa diedit. Setelah dikirim, kamu akan diarahkan ke WhatsApp toko untuk konfirmasi pembayaran dan
                    pengiriman.</p>
            </div>

            <div id="notif-gagal"
                class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-4 flex items-center gap-2.5">
                <i class="ti ti-alert-circle text-lg flex-shrink-0"></i>
                <span id="notif-gagal-teks">Pesanan gagal dikirim. Lengkapi semua data wajib terlebih dahulu.</span>
            </div>

            <button type="submit"
                class="w-full bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base py-3.5 rounded-lg transition-colors duration-150">
                Kirim pesanan
            </button>
        </form>

        <div id="modal-sukses" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
            <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
                <div
                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-circle-check text-2xl sm:text-3xl text-green-600"></i>
                </div>
                <h2 class="font-bold text-ink text-base sm:text-lg mb-1.5">Pesanan berhasil dikirim!</h2>
                <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-5">Klik tombol di bawah untuk lanjut
                    konfirmasi pesananmu lewat WhatsApp toko.</p>
                <button id="btn-lanjut-wa"
                    class="w-full bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base py-3 rounded-lg transition-colors duration-150 flex items-center justify-center gap-2">
                    <i class="ti ti-brand-whatsapp text-lg"></i> Lanjut ke WhatsApp
                </button>
            </div>
        </div>
    </section>

    <script>
        (function() {
            let waUrlTerakhir = '';

            function tandaiError(el, isError) {
                el.classList.toggle('border-red-400', isError);
                el.classList.toggle('border-gray-200', !isError);
            }

            const form = document.getElementById('form-pesanan');
            const notifGagal = document.getElementById('notif-gagal');
            const notifGagalTeks = document.getElementById('notif-gagal-teks');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const namaEl = document.getElementById('nama_pemesan');
                const waEl = document.getElementById('nomor_wa');
                const alamatEl = document.getElementById('alamat');

                const nama = namaEl.value.trim();
                const wa = waEl.value.trim();
                const alamat = alamatEl.value.trim();

                let adaError = false;
                [
                    [namaEl, nama],
                    [waEl, wa],
                    [alamatEl, alamat]
                ].forEach(function([el, val]) {
                    const kosong = val === '';
                    tandaiError(el, kosong);
                    if (kosong) adaError = true;
                });

                if (adaError) {
                    notifGagalTeks.textContent = "Pesanan gagal dikirim. Lengkapi semua data wajib terlebih dahulu.";
                    notifGagal.classList.remove('hidden');
                    notifGagal.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return;
                }

                const formData = new FormData(form);

                fetch("{{ route('pesanan.store', $product->id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notifGagal.classList.add('hidden');
                        waUrlTerakhir = data.whatsapp_url;
                        document.getElementById('modal-sukses').classList.remove('hidden');
                    } else {
                        notifGagalTeks.textContent = data.message || "Terjadi kesalahan saat menyimpan pesanan.";
                        notifGagal.classList.remove('hidden');
                    }
                })
                .catch(() => {
                    notifGagalTeks.textContent = "Gagal menghubungi server. Periksa koneksi Anda.";
                    notifGagal.classList.remove('hidden');
                });
            });

            document.getElementById('btn-lanjut-wa').addEventListener('click', function() {
                if (waUrlTerakhir) {
                    window.open(waUrlTerakhir, '_blank');
                }
                window.location.href = "{{ route('pesanan.riwayat') }}";
            });
        })();
    </script>
</x-layouts.guest>
