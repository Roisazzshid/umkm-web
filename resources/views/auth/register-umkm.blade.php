<x-layouts.auth title="Daftar UMKM | Rintasa">
    <div class="max-w-lg mx-auto bg-white border border-gray-100 rounded-2xl p-6 sm:p-8">
        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-1.5 text-center">Daftar sebagai mitra UMKM</h1>
        <p class="text-sm text-ink-muted text-center mb-6">Lengkapi data usahamu, tim admin akan memverifikasi sebelum toko aktif</p>

        <form id="form-register-umkm" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-ink text-sm mb-1.5">Nama UMKM</label>
                    <input type="text" id="nama_umkm" name="nama_umkm" placeholder="Nama toko" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
                </div>
                <div>
                    <label class="block font-bold text-ink text-sm mb-1.5">Nama pemilik</label>
                    <input type="text" id="nama_pemilik" name="nama_pemilik" placeholder="Nama kamu" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-ink text-sm mb-1.5">Username</label>
                    <input type="text" id="username" name="username" placeholder="Contoh: kopisenja" required pattern="^\S+$" title="Tanpa spasi" class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
                </div>
                <div>
                    <label class="block font-bold text-ink text-sm mb-1.5">Email usaha</label>
                    <input type="email" id="email_usaha" name="email_usaha" placeholder="usaha@email.com" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
                </div>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Nomor WhatsApp</label>
                <input type="tel" id="nomor_wa" name="nomor_wa" placeholder="08xxxxxxxxxx" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Password</label>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required minlength="8" class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Alamat toko</label>
                <textarea id="alamat_toko" name="alamat_toko" rows="2" placeholder="Alamat lengkap toko or usaha" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150"></textarea>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Deskripsi usaha</label>
                <textarea id="deskripsi_usaha" name="deskripsi_usaha" rows="3" placeholder="Ceritakan singkat tentang usahamu" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150"></textarea>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Logo UMKM</label>
                <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-lg py-6 cursor-pointer hover:border-primary transition-colors duration-150">
                    <i class="ti ti-upload text-2xl text-ink-muted"></i>
                    <span class="text-xs text-ink-muted">Klik untuk unggah logo (PNG/JPG)</span>
                    <input type="file" id="logo_umkm" name="logo_umkm" accept="image/*" class="hidden">
                </label>
            </div>

            <div class="bg-primary-light rounded-lg p-3.5 flex items-start gap-2.5">
                <i class="ti ti-info-circle text-primary text-base mt-0.5"></i>
                <p class="text-xs text-primary-dark leading-relaxed">Setelah daftar, tim admin akan memverifikasi data usahamu sebelum toko bisa mulai berjualan. Proses ini biasanya memakan waktu 1-2 hari kerja.</p>
            </div>

            <div id="notif-gagal-register" class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-4 flex items-center gap-2.5">
                <i class="ti ti-alert-circle text-lg flex-shrink-0"></i>
                <span id="notif-gagal-teks">Lengkapi semua data wajib terlebih dahulu.</span>
            </div>

            <button type="submit" class="w-full bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base py-3 rounded-lg transition-colors duration-150">
                Daftar sebagai UMKM
            </button>
        </form>

        <p class="text-xs sm:text-sm text-ink-muted text-center mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-bold hover:text-primary-dark">Masuk di sini</a>
        </p>
    </div>

    <div id="modal-sukses-register" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-circle-check text-2xl text-green-600"></i>
            </div>
            <h2 class="font-bold text-ink text-base sm:text-lg mb-1.5">Pendaftaran berhasil dikirim!</h2>
            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">Tim admin akan meninjau data usahamu. Kamu akan bisa login setelah akun disetujui.</p>
            <button type="button" id="btn-ke-login" class="w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm py-3 rounded-lg transition-colors duration-150">
                Masuk sekarang
            </button>
        </div>
    </div>

    <script>
        (function () {
            const inputLogo = document.getElementById('logo_umkm');
            const form = document.getElementById('form-register-umkm');
            const notifGagal = document.getElementById('notif-gagal-register');
            const notifGagalTeks = document.getElementById('notif-gagal-teks');
            const modalSukses = document.getElementById('modal-sukses-register');

            function tandaiError(el, isError) {
                el.classList.toggle('border-red-400', isError);
                el.classList.toggle('border-gray-200', !isError);
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const fields = [
                    document.getElementById('nama_umkm'),
                    document.getElementById('nama_pemilik'),
                    document.getElementById('username'),
                    document.getElementById('email_usaha'),
                    document.getElementById('nomor_wa'),
                    document.getElementById('password'),
                    document.getElementById('alamat_toko'),
                    document.getElementById('deskripsi_usaha')
                ];

                let adaError = false;
                fields.forEach(function (field) {
                    const kosong = field.value.trim() === '';
                    tandaiError(field, kosong);
                    if (kosong) adaError = true;
                });

                if (adaError) {
                    notifGagalTeks.textContent = "Lengkapi semua data wajib terlebih dahulu.";
                    notifGagal.classList.remove('hidden');
                    notifGagal.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                const formData = new FormData(form);

                fetch("{{ route('register.umkm') }}", {
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
                        modalSukses.classList.remove('hidden');
                    } else {
                        notifGagalTeks.textContent = data.message || "Terjadi kesalahan saat mendaftar.";
                        notifGagal.classList.remove('hidden');
                        notifGagal.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                })
                .catch(error => {
                    notifGagalTeks.textContent = "Gagal menghubungi server. Periksa koneksi Anda.";
                    notifGagal.classList.remove('hidden');
                    notifGagal.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            });

            document.getElementById('btn-ke-login').addEventListener('click', function () {
                window.location.href = "{{ route('login') }}";
            });
        })();
    </script>
</x-layouts.auth>
