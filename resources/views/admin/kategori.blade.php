<x-layouts.admin title="Kelola kategori | Rintasa">
    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <h1 class="text-xl sm:text-2xl font-bold text-ink">Kelola kategori</h1>
        <button type="button" id="btn-tambah-kategori"
            class="bg-accent hover:bg-accent-dark text-white text-sm font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 transition-colors duration-150">
            <i class="ti ti-plus text-base"></i> Tambah kategori
        </button>
    </div>

    <div id="banner-sukses"
        class="hidden bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-3.5 mb-5 flex items-center gap-2.5 transition-opacity duration-300">
        <i class="ti ti-circle-check text-lg flex-shrink-0"></i>
        <span id="banner-sukses-teks"></span>
    </div>

    <div class="relative max-w-md mb-4">
        <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-ink-muted"></i>
        <input type="text" id="cari-kategori" placeholder="Cari nama kategori..."
            class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
    </div>

    <div id="list-kategori" class="border border-gray-100 rounded-xl overflow-hidden">
        <div class="hidden sm:grid grid-cols-[1fr_1fr_100px] px-4 py-3 bg-gray-50 text-xs font-bold text-ink-muted">
            <span>Nama kategori</span><span>Jumlah produk</span><span>Aksi</span>
        </div>

        @foreach ($categories as $cat)
        <div data-row data-id="{{ $cat->id }}" data-nama="{{ strtolower($cat->name) }}"
            class="flex sm:grid sm:grid-cols-[1fr_1fr_100px] px-4 py-3 border-t border-gray-100 items-center gap-3 sm:gap-4">
            <div class="flex-1 sm:flex-none min-w-0">
                <span data-nama-tampil class="font-bold text-ink text-sm truncate block">{{ $cat->name }}</span>
                <span data-jumlah-mobile class="sm:hidden text-xs text-ink-muted">{{ $cat->products_count }} produk</span>
            </div>
            <span class="hidden sm:block text-ink-muted text-sm">{{ $cat->products_count }} produk</span>
            <div class="flex gap-3 flex-shrink-0">
                <button type="button" data-edit class="text-primary hover:text-primary-dark text-base"
                    aria-label="Edit {{ $cat->name }}"><i class="ti ti-edit"></i></button>
                <button type="button" data-hapus class="text-red-600 hover:text-red-700 text-base"
                    aria-label="Hapus {{ $cat->name }}"><i class="ti ti-trash"></i></button>
            </div>
        </div>
        @endforeach
    </div>

    <div id="kategori-kosong" class="hidden text-center py-12">
        <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <i class="ti ti-search-off text-2xl text-ink-muted"></i>
        </div>
        <div class="font-bold text-ink text-sm mb-1">Kategori tidak ditemukan</div>
        <p class="text-xs sm:text-sm text-ink-muted">Coba kata kunci lain.</p>
    </div>

    <x-pagination target="list-kategori" :per-page="5" />

    <div id="modal-kategori" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full">
            <h2 id="modal-kategori-judul" class="font-bold text-ink text-base sm:text-lg mb-4">Tambah kategori</h2>
            <label class="block font-bold text-ink text-sm mb-1.5">Nama kategori</label>
            <input type="text" id="input-nama-kategori" placeholder="Contoh: Elektronik"
                class="w-full px-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150 mb-5">
            <div class="flex gap-3">
                <button type="button" id="modal-kategori-batal"
                    class="flex-1 bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Batal</button>
                <button type="button" id="modal-kategori-simpan"
                    class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Simpan</button>
            </div>
        </div>
    </div>

    <div id="modal-hapus" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-alert-circle text-2xl text-red-600"></i>
            </div>
            <h2 class="font-bold text-ink text-base sm:text-lg mb-1.5">Hapus kategori ini?</h2>
            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">Produk yang masih pakai kategori ini
                perlu dipindah ke kategori lain terlebih dahulu.</p>
            <div class="flex gap-3">
                <button type="button" id="modal-hapus-batal"
                    class="flex-1 bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Batal</button>
                <button type="button" id="modal-hapus-oke"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            let semuaRow = Array.from(document.querySelectorAll('#list-kategori [data-row]'));
            const inputCari = document.getElementById('cari-kategori');
            const kosong = document.getElementById('kategori-kosong');

            function terapkanFilter() {
                const kataKunci = inputCari.value.trim().toLowerCase();

                semuaRow.forEach(function(row) {
                    const cocokNama = kataKunci === '' || row.dataset.nama.includes(kataKunci);
                    row.dataset.tersaring = cocokNama ? 'ya' : 'tidak';
                });

                aturUlangPagination();
            }

            inputCari.addEventListener('input', terapkanFilter);

            let renderPagination = function() {};

            function aturUlangPagination() {
                renderPagination();
            }

            document.querySelectorAll('[data-pagination]').forEach(function(nav) {
                const container = document.getElementById(nav.dataset.target);
                if (!container) return;

                const perPage = parseInt(nav.dataset.perPage || '5');
                const btnPrev = nav.querySelector('[data-page-prev]');
                const btnNext = nav.querySelector('[data-page-next]');
                const numbersWrap = nav.querySelector('[data-page-numbers]');
                let currentPage = 1;

                function ambilRowTersaring() {
                    return semuaRow.filter(function(row) {
                        return row.dataset.tersaring !== 'tidak';
                    });
                }

                function render() {
                    const rowTersaring = ambilRowTersaring();
                    const totalPages = Math.max(1, Math.ceil(rowTersaring.length / perPage));
                    if (currentPage > totalPages) currentPage = 1;

                    if (rowTersaring.length === 0) {
                        kosong.classList.remove('hidden');
                        nav.classList.add('hidden');
                    } else {
                        kosong.classList.add('hidden');
                        nav.classList.remove('hidden');
                    }

                    semuaRow.forEach(function(row) {
                        row.style.display = 'none';
                    });

                    rowTersaring.forEach(function(row, index) {
                        const page = Math.floor(index / perPage) + 1;
                        row.style.display = (page !== currentPage) ? 'none' : '';
                    });

                    numbersWrap.innerHTML = '';
                    for (let i = 1; i <= totalPages; i++) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.textContent = i;
                        btn.className = 'w-8 h-8 rounded-lg text-sm font-bold transition-colors duration-150 ' +
                            (i === currentPage ? 'bg-primary text-white' : 'text-ink-muted hover:bg-gray-50');
                        btn.addEventListener('click', function() {
                            currentPage = i;
                            render();
                        });
                        numbersWrap.appendChild(btn);
                    }

                    btnPrev.disabled = currentPage === 1;
                    btnNext.disabled = currentPage === totalPages;
                }

                btnPrev.addEventListener('click', function() {
                    if (currentPage > 1) {
                        currentPage--;
                        render();
                    }
                });
                btnNext.addEventListener('click', function() {
                    currentPage++;
                    render();
                });

                renderPagination = render;
                render();
            });

            terapkanFilter();

            const banner = document.getElementById('banner-sukses');
            const bannerTeks = document.getElementById('banner-sukses-teks');

            function tampilkanBannerSementara(pesan) {
                bannerTeks.textContent = pesan;
                banner.classList.remove('hidden');
                banner.style.opacity = '1';
                setTimeout(function() {
                    banner.style.opacity = '0';
                    setTimeout(function() {
                        banner.classList.add('hidden');
                    }, 300);
                }, 4000);
            }

            const modalKategori = document.getElementById('modal-kategori');
            const modalJudul = document.getElementById('modal-kategori-judul');
            const inputNama = document.getElementById('input-nama-kategori');
            const btnBatalKategori = document.getElementById('modal-kategori-batal');
            const btnSimpanKategori = document.getElementById('modal-kategori-simpan');

            const modalHapus = document.getElementById('modal-hapus');
            const btnBatalHapus = document.getElementById('modal-hapus-batal');
            const btnOkeHapus = document.getElementById('modal-hapus-oke');

            const list = document.getElementById('list-kategori');
            let modeEdit = null;
            let rowUntukHapus = null;

            function bukaTambah() {
                modeEdit = null;
                modalJudul.textContent = 'Tambah kategori';
                inputNama.value = '';
                modalKategori.classList.remove('hidden');
                inputNama.focus();
            }

            function bukaEdit(row) {
                modeEdit = row;
                modalJudul.textContent = 'Edit kategori';
                inputNama.value = row.querySelector('[data-nama-tampil]').textContent;
                modalKategori.classList.remove('hidden');
                inputNama.focus();
            }

            function pasangEvent(row) {
                row.querySelector('[data-edit]').addEventListener('click', function() {
                    bukaEdit(row);
                });
                row.querySelector('[data-hapus]').addEventListener('click', function() {
                    rowUntukHapus = row;
                    modalHapus.classList.remove('hidden');
                });
            }

            function buatBarisBaru(nama, id) {
                const div = document.createElement('div');
                div.setAttribute('data-row', '');
                div.setAttribute('data-id', id);
                div.setAttribute('data-nama', nama.toLowerCase());
                div.className =
                    'flex sm:grid sm:grid-cols-[1fr_1fr_100px] px-4 py-3 border-t border-gray-100 items-center gap-3 sm:gap-4';
                div.innerHTML =
                    '<div class="flex-1 sm:flex-none min-w-0">' +
                    '<span data-nama-tampil class="font-bold text-ink text-sm truncate block">' + nama + '</span>' +
                    '<span data-jumlah-mobile class="sm:hidden text-xs text-ink-muted">0 produk</span>' +
                    '</div>' +
                    '<span class="hidden sm:block text-ink-muted text-sm">0 produk</span>' +
                    '<div class="flex gap-3 flex-shrink-0">' +
                    '<button type="button" data-edit class="text-primary hover:text-primary-dark text-base" aria-label="Edit ' +
                    nama + '"><i class="ti ti-edit"></i></button>' +
                    '<button type="button" data-hapus class="text-red-600 hover:text-red-700 text-base" aria-label="Hapus ' +
                    nama + '"><i class="ti ti-trash"></i></button>' +
                    '</div>';
                pasangEvent(div);
                return div;
            }

            document.getElementById('btn-tambah-kategori').addEventListener('click', bukaTambah);

            btnBatalKategori.addEventListener('click', function() {
                modalKategori.classList.add('hidden');
            });

            btnSimpanKategori.addEventListener('click', function() {
                const nama = inputNama.value.trim();
                if (!nama) return;

                if (modeEdit) {
                    const id = modeEdit.dataset.id;
                    fetch(`/admin/kategori/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ name: nama })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            modeEdit.querySelector('[data-nama-tampil]').textContent = nama;
                            modeEdit.dataset.nama = nama.toLowerCase();
                            modalKategori.classList.add('hidden');
                            terapkanFilter();
                            tampilkanBannerSementara('Kategori berhasil diperbarui.');
                        } else {
                            alert(data.message || 'Gagal memperbarui kategori.');
                        }
                    })
                    .catch(() => alert('Terjadi kesalahan koneksi.'));
                } else {
                    fetch('/admin/kategori', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ name: nama })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const barisBaru = buatBarisBaru(data.category.name, data.category.id);
                            list.appendChild(barisBaru);
                            semuaRow.push(barisBaru);
                            modalKategori.classList.add('hidden');
                            terapkanFilter();
                            tampilkanBannerSementara('Kategori baru berhasil ditambahkan.');
                        } else {
                            alert(data.message || 'Gagal menambahkan kategori.');
                        }
                    })
                    .catch(() => alert('Terjadi kesalahan koneksi.'));
                }
            });

            btnBatalHapus.addEventListener('click', function() {
                modalHapus.classList.add('hidden');
                rowUntukHapus = null;
            });

            btnOkeHapus.addEventListener('click', function() {
                if (rowUntukHapus) {
                    const id = rowUntukHapus.dataset.id;
                    fetch(`/admin/kategori/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        return response.json().then(err => { throw err; });
                    })
                    .then(data => {
                        if (data.success) {
                            semuaRow = semuaRow.filter(function(row) {
                                return row !== rowUntukHapus;
                            });
                            rowUntukHapus.remove();
                            modalHapus.classList.add('hidden');
                            rowUntukHapus = null;
                            terapkanFilter();
                            tampilkanBannerSementara('Kategori berhasil dihapus.');
                        }
                    })
                    .catch(err => {
                        modalHapus.classList.add('hidden');
                        rowUntukHapus = null;
                        alert(err.message || 'Terjadi kesalahan saat menghapus kategori.');
                    });
                }
            });

            semuaRow.forEach(pasangEvent);
        })();
    </script>
</x-layouts.admin>
