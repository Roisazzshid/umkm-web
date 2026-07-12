<x-layouts.auth title="Lupa Password | Rintasa">
    <div id="panel-form" class="max-w-sm mx-auto bg-white border border-gray-100 rounded-2xl p-6 sm:p-8">
        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-1.5 text-center">Lupa password?</h1>
        <p class="text-sm text-ink-muted text-center mb-6">Masukkan username kamu, kami akan kirim instruksi reset ke email yang terdaftar.</p>

        <form id="form-lupa-password" class="space-y-4">
            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Username</label>
                <input type="text" id="username" placeholder="Username kamu" required class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div id="notif-gagal-reset" class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-4 flex items-center gap-2.5">
                <i class="ti ti-alert-circle text-lg flex-shrink-0"></i>
                <span>Masukkan username terlebih dahulu.</span>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm sm:text-base py-3 rounded-lg transition-colors duration-150">
                Kirim instruksi reset
            </button>
        </form>

        <p class="text-xs sm:text-sm text-ink-muted text-center mt-6">
            Sudah ingat password? <a href="{{ route('login') }}" class="text-primary font-bold hover:text-primary-dark">Masuk di sini</a>
        </p>
    </div>

    <div id="panel-sukses" class="hidden max-w-sm mx-auto bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 text-center">
        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
            <i class="ti ti-mail-check text-2xl text-green-600"></i>
        </div>
        <h2 class="font-bold text-ink text-base sm:text-lg mb-1.5">Instruksi terkirim</h2>
        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">
            Jika username <span id="username-tampil" class="font-bold text-ink"></span> terdaftar, instruksi reset password sudah dikirim ke email yang terhubung ke akun tersebut.
        </p>
        <a href="{{ route('login') }}" class="block bg-primary hover:bg-primary-dark text-white font-bold text-sm py-3 rounded-lg transition-colors duration-150">
            Kembali ke halaman masuk
        </a>
    </div>

    <script>
        (function () {
            const form = document.getElementById('form-lupa-password');
            const notifGagal = document.getElementById('notif-gagal-reset');
            const panelForm = document.getElementById('panel-form');
            const panelSukses = document.getElementById('panel-sukses');
            const usernameInput = document.getElementById('username');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const username = usernameInput.value.trim();
                const isKosong = username === '';

                usernameInput.classList.toggle('border-red-400', isKosong);
                usernameInput.classList.toggle('border-gray-200', !isKosong);

                if (isKosong) {
                    notifGagal.classList.remove('hidden');
                    return;
                }

                document.getElementById('username-tampil').textContent = username;
                panelForm.classList.add('hidden');
                panelSukses.classList.remove('hidden');
            });
        })();
    </script>
</x-layouts.auth>
