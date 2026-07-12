<x-layouts.umkm title="Tambah produk | Rintasa">
    <nav class="text-xs text-ink-muted mb-5">
        <a href="{{ route('umkm.produk.index') }}" class="hover:text-primary">Kelola produk</a>
        <span class="mx-1.5">/</span>
        <span class="text-ink">Tambah produk</span>
    </nav>

    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-6">Tambah produk baru</h1>

    <div class="max-w-xl">
        <form id="form-produk" action="{{ route('umkm.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block font-bold text-ink text-sm mb-2">Foto produk</label>
                <div class="flex items-center gap-4">
                    <div id="preview-foto"
                        class="w-20 h-20 rounded-xl bg-primary-light flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <i class="ti ti-photo text-2xl text-white"></i>
                    </div>
                    <label class="cursor-pointer">
                        <span
                            class="inline-block bg-white text-primary border-2 border-primary hover:bg-primary-light text-xs sm:text-sm font-bold px-4 py-2 rounded-lg transition-colors duration-150">
                            Unggah foto
                        </span>
                        <input type="file" id="input-foto" name="foto_produk" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Nama produk</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Contoh: Kopi robusta special" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-ink text-sm mb-1.5">Kategori</label>
                    <select id="kategori_produk" name="kategori_produk" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-ink text-sm mb-1.5">Harga (Rp)</label>
                    <input type="number" id="harga_produk" name="harga_produk" placeholder="25000" required min="0"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
                </div>
            </div>

            <div>
                <label class="block font-bold text-ink text-sm mb-1.5">Deskripsi produk</label>
                <textarea id="deskripsi_produk" name="deskripsi_produk" rows="3" placeholder="Ceritakan detail produkmu" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150"></textarea>
            </div>

            <div id="notif-gagal-produk"
                class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-4 flex items-center gap-2.5">
                <i class="ti ti-alert-circle text-lg flex-shrink-0"></i>
                <span>Lengkapi semua data wajib terlebih dahulu.</span>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="bg-accent hover:bg-accent-dark text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg transition-colors duration-150">
                    Simpan produk
                </button>
                <button type="button" id="btn-batal-produk"
                    class="bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm sm:text-base px-6 py-3 rounded-lg transition-colors duration-150">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <div id="modal-konfirmasi" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
            <div id="modal-icon-wrap" class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="modal-icon" class="text-2xl"></i>
            </div>
            <h2 id="modal-judul" class="font-bold text-ink text-base sm:text-lg mb-1.5"></h2>
            <p id="modal-teks" class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6"></p>
            <div class="flex gap-3">
                <button type="button" id="modal-tutup"
                    class="flex-1 bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Batal</button>
                <button type="button" id="modal-oke"
                    class="flex-1 text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Oke</button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const inputFoto = document.getElementById('input-foto');
            const previewFoto = document.getElementById('preview-foto');

            inputFoto.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.innerHTML = '<img src="' + e.target.result +
                        '" class="w-full h-full object-cover">';
                };
                reader.readAsDataURL(file);
            });

            const form = document.getElementById('form-produk');
            const notifGagal = document.getElementById('notif-gagal-produk');

            const modal = document.getElementById('modal-konfirmasi');
            const modalIconWrap = document.getElementById('modal-icon-wrap');
            const modalIcon = document.getElementById('modal-icon');
            const modalJudul = document.getElementById('modal-judul');
            const modalTeks = document.getElementById('modal-teks');
            const modalOke = document.getElementById('modal-oke');

            function tandaiError(el, isError) {
                el.classList.toggle('border-red-400', isError);
                el.classList.toggle('border-gray-200', !isError);
            }

            function bukaModal(tipe) {
                if (tipe === 'simpan') {
                    modalJudul.textContent = 'Simpan produk ini?';
                    modalTeks.textContent = 'Produk akan langsung muncul di halaman toko kamu.';
                    modalIconWrap.className =
                        'w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4';
                    modalIcon.className = 'ti ti-circle-check text-2xl text-green-600';
                    modalOke.className =
                        'flex-1 bg-primary hover:bg-primary-dark text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150';
                } else {
                    modalJudul.textContent = 'Batalkan penambahan produk?';
                    modalTeks.textContent = 'Data yang sudah kamu isi tidak akan disimpan.';
                    modalIconWrap.className =
                        'w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4';
                    modalIcon.className = 'ti ti-alert-circle text-2xl text-red-600';
                    modalOke.className =
                        'flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150';
                }
                modal.dataset.tipe = tipe;
                modal.classList.remove('hidden');
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const fields = [
                    document.getElementById('nama_produk'),
                    document.getElementById('kategori_produk'),
                    document.getElementById('harga_produk'),
                    document.getElementById('deskripsi_produk')
                ];

                let adaError = false;
                fields.forEach(function(field) {
                    const kosong = field.value.trim() === '';
                    tandaiError(field, kosong);
                    if (kosong) adaError = true;
                });

                if (adaError) {
                    notifGagal.classList.remove('hidden');
                    notifGagal.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return;
                }

                notifGagal.classList.add('hidden');
                bukaModal('simpan');
            });

            document.getElementById('btn-batal-produk').addEventListener('click', function() {
                bukaModal('batal');
            });

            document.getElementById('modal-tutup').addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            modalOke.addEventListener('click', function() {
                const tipe = modal.dataset.tipe;
                if (tipe === 'simpan') {
                    form.submit();
                } else {
                    window.location.href = "{{ route('umkm.produk.index') }}";
                }
            });
        })();
    </script>
</x-layouts.umkm>
