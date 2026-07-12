<x-layouts.guest title="Produk | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-6xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-5">Semua produk</h1>

        <div class="relative max-w-xl mb-5">
            <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-ink-muted"></i>
            <input type="text" id="cari-produk" placeholder="Cari produk..."
                class="w-full pl-11 pr-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
        </div>

        <div class="flex gap-2.5 flex-wrap mb-8">
            <x-kategori-chip label="Semua" :active="true" data-filter-kategori="semua" />
            <x-kategori-chip label="Makanan" data-filter-kategori="Makanan" />
            <x-kategori-chip label="Minuman" data-filter-kategori="Minuman" />
            <x-kategori-chip label="Fashion" data-filter-kategori="Fashion" />
            <x-kategori-chip label="Kerajinan" data-filter-kategori="Kerajinan" />
            <x-kategori-chip label="Aksesoris" data-filter-kategori="Aksesoris" />
        </div>

        <div id="daftar-produk" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($products as $prod)
                <div data-row data-kategori="{{ $prod->category->name }}" data-nama="{{ strtolower($prod->name) }}">
                    <x-produk-card
                        :id="$prod->id"
                        :nama="$prod->name"
                        :kategori="$prod->category->name"
                        :harga="$prod->price"
                        :lokasi="explode(',', $prod->store->address)[0]"
                        :rating="$prod->rating"
                        :terjual="$prod->sold_count" />
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-ink-muted text-sm bg-white border border-gray-100 rounded-xl">
                    Belum ada produk aktif yang tersedia.
                </div>
            @endforelse
        </div>

        <div id="produk-kosong" class="hidden text-center py-12">
            <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <i class="ti ti-search-off text-2xl text-ink-muted"></i>
            </div>
            <div class="font-bold text-ink text-sm mb-1">Produk tidak ditemukan</div>
            <p class="text-xs sm:text-sm text-ink-muted">Coba kata kunci atau kategori lain.</p>
        </div>

        <x-pagination target="daftar-produk" :per-page="8" />
    </section>

    <script>
        (function () {
            const semuaRow = Array.from(document.querySelectorAll('#daftar-produk [data-row]'));
            const semuaChip = Array.from(document.querySelectorAll('[data-filter-kategori]'));
            const inputCari = document.getElementById('cari-produk');
            let kategoriAktif = 'semua';

            function terapkanFilter() {
                const kataKunci = inputCari.value.trim().toLowerCase();

                semuaRow.forEach(function (row) {
                    const cocokKategori = kategoriAktif === 'semua' || row.dataset.kategori === kategoriAktif;
                    const cocokNama = kataKunci === '' || row.dataset.nama.includes(kataKunci);
                    row.dataset.tersaring = (cocokKategori && cocokNama) ? 'ya' : 'tidak';
                });

                aturUlangPagination();
            }

            inputCari.addEventListener('input', terapkanFilter);

            semuaChip.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    kategoriAktif = chip.dataset.filterKategori;
                    semuaChip.forEach(function (c) {
                        c.classList.remove('bg-primary', 'text-white', 'border-primary');
                        c.classList.add('bg-white', 'text-ink-muted', 'border-gray-200');
                    });
                    chip.classList.remove('bg-white', 'text-ink-muted', 'border-gray-200');
                    chip.classList.add('bg-primary', 'text-white', 'border-primary');
                    terapkanFilter();
                });
            });

            let renderPagination = function () {};
            function aturUlangPagination() { renderPagination(); }

            document.querySelectorAll('[data-pagination]').forEach(function (nav) {
                const container = document.getElementById(nav.dataset.target);
                if (!container) return;

                const perPage = parseInt(nav.dataset.perPage || '5');
                const btnPrev = nav.querySelector('[data-page-prev]');
                const btnNext = nav.querySelector('[data-page-next]');
                const numbersWrap = nav.querySelector('[data-page-numbers]');
                let currentPage = 1;

                function ambilRowTersaring() {
                    return semuaRow.filter(function (row) { return row.dataset.tersaring !== 'tidak'; });
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

                    semuaRow.forEach(function (row) { row.style.display = 'none'; });

                    rowTersaring.forEach(function (row, index) {
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
                        btn.addEventListener('click', function () { currentPage = i; render(); });
                        numbersWrap.appendChild(btn);
                    }

                    btnPrev.disabled = currentPage === 1;
                    btnNext.disabled = currentPage === totalPages;
                }

                btnPrev.addEventListener('click', function () { if (currentPage > 1) { currentPage--; render(); } });
                btnNext.addEventListener('click', function () { currentPage++; render(); });

                renderPagination = render;
                render();
            });

            terapkanFilter();
        })();
    </script>
</x-layouts.guest>
