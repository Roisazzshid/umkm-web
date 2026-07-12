<x-layouts.umkm title="Kelola produk | Rintasa">
    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <h1 class="text-xl sm:text-2xl font-bold text-ink">Kelola produk</h1>
        <a href="{{ route('umkm.produk.create') }}"
            class="bg-accent hover:bg-accent-dark text-white text-sm font-bold px-4 py-2.5 rounded-lg flex items-center gap-1.5 transition-colors duration-150">
            <i class="ti ti-plus text-base"></i> Tambah produk
        </a>
    </div>

    @php
        $berhasil = request()->query('berhasil');
        $pesanBerhasil = [
            'tambah' => 'Produk baru berhasil ditambahkan.',
            'edit' => 'Perubahan produk berhasil disimpan.',
            'hapus' => 'Produk berhasil dihapus.',
        ];
    @endphp

    <div id="banner-sukses"
        class="{{ $berhasil && isset($pesanBerhasil[$berhasil]) ? '' : 'hidden' }} bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-3.5 mb-5 flex items-center gap-2.5 transition-opacity duration-300">
        <i class="ti ti-circle-check text-lg flex-shrink-0"></i>
        <span id="banner-sukses-teks">{{ $pesanBerhasil[$berhasil] ?? '' }}</span>
    </div>

    <div class="relative max-w-md mb-4">
        <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-ink-muted"></i>
        <input type="text" id="cari-produk" placeholder="Cari nama produk..."
            class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
    </div>

    <div class="flex gap-2 flex-wrap mb-5">
        <x-kategori-chip label="Semua" :active="true" data-filter-kategori="semua" />
        @foreach ($categories as $cat)
            <x-kategori-chip label="{{ $cat->name }}" data-filter-kategori="{{ $cat->name }}" />
        @endforeach
    </div>

    <div id="tabel-produk" class="border border-gray-100 rounded-xl overflow-hidden">
        <div
            class="hidden sm:grid grid-cols-[56px_1fr_0.5fr_0.5fr_80px] px-4 py-3 bg-gray-50 text-xs font-bold text-ink-muted items-center">
            <span></span><span>Nama produk</span><span>Kategori</span><span>Harga</span><span>Aksi</span>
        </div>

        @foreach ($products as $prod)
        <div data-row data-id="{{ $prod->id }}" data-nama="{{ strtolower($prod->name) }}" data-kategori="{{ $prod->category->name }}"
            class="flex sm:grid sm:grid-cols-[56px_1fr_0.5fr_0.5fr_80px] px-4 py-3 border-t border-gray-100 items-center gap-3 sm:gap-4">
            <div class="w-11 h-11 rounded-lg bg-primary-light flex items-center justify-center flex-shrink-0 overflow-hidden">
                @if ($prod->image)
                    <img src="{{ asset('storage/' . $prod->image) }}" class="w-full h-full object-cover">
                @else
                    <i class="ti ti-photo text-base text-white"></i>
                @endif
            </div>
            <span class="font-bold text-ink text-sm flex-1 sm:flex-none min-w-0 truncate">{{ $prod->name }}</span>
            <span class="hidden sm:block text-ink-muted text-sm">{{ $prod->category->name }}</span>
            <span class="hidden sm:block text-ink text-sm font-bold">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
            <div class="flex gap-3 flex-shrink-0">
                <a href="{{ route('umkm.produk.edit', $prod->id) }}" class="text-primary hover:text-primary-dark text-base"
                    aria-label="Edit produk"><i class="ti ti-edit"></i></a>
                <button type="button" data-hapus class="text-red-600 hover:text-red-700 text-base"
                    aria-label="Hapus produk"><i class="ti ti-trash"></i></button>
            </div>
        </div>
        @endforeach
    </div>

    <div id="produk-kosong" class="hidden text-center py-12">
        <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <i class="ti ti-search-off text-2xl text-ink-muted"></i>
        </div>
        <div class="font-bold text-ink text-sm mb-1">Produk tidak ditemukan</div>
        <p class="text-xs sm:text-sm text-ink-muted">Coba kata kunci atau kategori lain.</p>
    </div>

    <x-pagination target="tabel-produk" :per-page="5" />

    <div id="modal-hapus-produk" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-alert-circle text-2xl text-red-600"></i>
            </div>
            <h2 class="font-bold text-ink text-base sm:text-lg mb-1.5">Hapus produk ini?</h2>
            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">Produk yang dihapus tidak akan muncul
                lagi di halaman toko kamu.</p>
            <div class="flex gap-3">
                <button type="button" id="modal-hapus-batal"
                    class="flex-1 bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Batal</button>
                <button type="button" id="modal-hapus-oke"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Hapus</button>
            </div>
        </div>
    </div>

    <form id="form-hapus-produk" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        (function() {
            const semuaRow = Array.from(document.querySelectorAll('#tabel-produk [data-row]'));
            const semuaChip = Array.from(document.querySelectorAll('[data-filter-kategori]'));
            const inputCari = document.getElementById('cari-produk');
            let kategoriAktif = 'semua';

            function terapkanFilter() {
                const kataKunci = inputCari.value.trim().toLowerCase();

                semuaRow.forEach(function(row) {
                    const cocokKategori = kategoriAktif === 'semua' || row.dataset.kategori === kategoriAktif;
                    const cocokNama = kataKunci === '' || row.dataset.nama.includes(kataKunci);
                    row.dataset.tersaring = (cocokKategori && cocokNama) ? 'ya' : 'tidak';
                });

                aturUlangPagination();
            }

            inputCari.addEventListener('input', terapkanFilter);

            semuaChip.forEach(function(chip) {
                chip.addEventListener('click', function() {
                    kategoriAktif = chip.dataset.filterKategori;
                    semuaChip.forEach(function(c) {
                        c.classList.remove('bg-primary', 'text-white', 'border-primary');
                        c.classList.add('bg-white', 'text-ink-muted', 'border-gray-200');
                    });
                    chip.classList.remove('bg-white', 'text-ink-muted', 'border-gray-200');
                    chip.classList.add('bg-primary', 'text-white', 'border-primary');
                    terapkanFilter();
                });
            });

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

                    const kosong = document.getElementById('produk-kosong');
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

            const modalHapus = document.getElementById('modal-hapus-produk');
            let rowUntukHapus = null;

            document.querySelectorAll('[data-hapus]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    rowUntukHapus = btn.closest('[data-row]');
                    modalHapus.classList.remove('hidden');
                });
            });

            document.getElementById('modal-hapus-batal').addEventListener('click', function() {
                modalHapus.classList.add('hidden');
                rowUntukHapus = null;
            });

            document.getElementById('modal-hapus-oke').addEventListener('click', function() {
                if (rowUntukHapus) {
                    const id = rowUntukHapus.dataset.id;
                    const form = document.getElementById('form-hapus-produk');
                    form.action = `/umkm/produk/${id}`;
                    form.submit();
                }
            });

            const banner = document.getElementById('banner-sukses');

            function tampilkanBannerSementara() {
                banner.classList.remove('hidden');
                banner.style.opacity = '1';
                setTimeout(function() {
                    banner.style.opacity = '0';
                    setTimeout(function() {
                        banner.classList.add('hidden');
                    }, 300);
                }, 4000);
            }

            if (!banner.classList.contains('hidden')) {
                tampilkanBannerSementara();
                const urlBersih = window.location.pathname;
                window.history.replaceState({}, '', urlBersih);
            }
        })();
    </script>
</x-layouts.umkm>
