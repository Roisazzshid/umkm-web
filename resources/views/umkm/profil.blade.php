<x-layouts.umkm title="Profil toko | Rintasa">
    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-6">Profil toko</h1>

    <div class="max-w-xl">
        <div id="notif-gagal-profil"
            class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-4 mb-5 flex items-center gap-2.5 transition-opacity duration-300">
            <i class="ti ti-alert-circle text-lg flex-shrink-0"></i>
            <span>Lengkapi semua data wajib terlebih dahulu.</span>
        </div>

        <div id="notif-sukses-profil"
            class="hidden bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-4 mb-5 flex items-center gap-2.5 transition-opacity duration-300">
            <i class="ti ti-circle-check text-lg flex-shrink-0"></i>
            <span>Profil toko berhasil diperbarui.</span>
        </div>

        <form id="form-profil" class="space-y-5" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="block font-bold text-ink text-sm mb-2">Logo toko</label>
                <div class="flex items-center gap-4">
                    <div id="preview-logo"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-primary-light flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if ($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                        @else
                            <i class="ti ti-building-store text-2xl sm:text-3xl text-primary"></i>
                        @endif
                    </div>
                    <label class="cursor-pointer">
                        <span
                            class="inline-block bg-white text-primary border-2 border-primary hover:bg-primary-light text-xs sm:text-sm font-bold px-4 py-2 rounded-lg transition-colors duration-150">
                            Ganti logo
                        </span>
                        <input type="file" id="input-logo" name="logo_toko" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Nama toko</label>
                <input type="text" id="nama_toko" name="nama_toko" value="{{ $store->name }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Nomor WhatsApp</label>
                <input type="tel" id="wa_toko" name="wa_toko" value="{{ $store->phone }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Alamat toko</label>
                <textarea id="alamat_toko" name="alamat_toko" rows="2" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">{{ $store->address }}</textarea>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Deskripsi usaha</label>
                <textarea id="deskripsi_toko" name="deskripsi_toko" rows="3" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">{{ $store->description }}</textarea>
            </div>

            <button type="submit"
                class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-bold text-sm sm:text-base px-8 py-3 rounded-lg transition-colors duration-150">
                Simpan perubahan
            </button>
        </form>
    </div>

    <script>
        (function() {
            const inputLogo = document.getElementById('input-logo');
            const previewLogo = document.getElementById('preview-logo');

            inputLogo.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewLogo.innerHTML = '<img src="' + e.target.result +
                        '" class="w-full h-full object-cover">';
                };
                reader.readAsDataURL(file);
            });

            const form = document.getElementById('form-profil');
            const notifGagal = document.getElementById('notif-gagal-profil');
            const notifSukses = document.getElementById('notif-sukses-profil');

            function tandaiError(el, isError) {
                el.classList.toggle('border-red-400', isError);
                el.classList.toggle('border-gray-200', !isError);
            }

            function tampilkanSementara(el) {
                el.classList.remove('hidden');
                el.style.opacity = '1';
                setTimeout(function() {
                    el.style.opacity = '0';
                    setTimeout(function() {
                        el.classList.add('hidden');
                    }, 300);
                }, 4000);
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const fields = [
                    document.getElementById('nama_toko'),
                    document.getElementById('wa_toko'),
                    document.getElementById('alamat_toko'),
                    document.getElementById('deskripsi_toko')
                ];

                let adaError = false;
                fields.forEach(function(field) {
                    const kosong = field.value.trim() === '';
                    tandaiError(field, kosong);
                    if (kosong) adaError = true;
                });

                notifSukses.classList.add('hidden');

                if (adaError) {
                    tampilkanSementara(notifGagal);
                    notifGagal.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return;
                }

                const formData = new FormData(form);

                fetch("{{ route('umkm.profil') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notifGagal.classList.add('hidden');
                        tampilkanSementara(notifSukses);
                        notifSukses.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    } else {
                        tampilkanSementara(notifGagal);
                    }
                })
                .catch(() => tampilkanSementara(notifGagal));
            });
        })();
    </script>
</x-layouts.umkm>
