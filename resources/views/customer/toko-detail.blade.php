<x-layouts.guest title="Detail Toko | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-6xl mx-auto">
        <nav class="text-xs text-ink-muted mb-5">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('umkm.list') }}" class="hover:text-primary">UMKM</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink">{{ $store->name }}</span>
        </nav>

        <div class="bg-primary-light rounded-2xl h-32 sm:h-40 mb-[-32px] sm:mb-[-40px]"></div>

        <div class="relative px-1">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white border-4 border-white shadow-none flex items-center justify-center mb-3 overflow-hidden"
                style="background-color:#E6F1FB;">
                @if ($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                @else
                    <i class="ti ti-building-store text-3xl sm:text-4xl text-primary"></i>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <h1 class="text-xl sm:text-2xl font-bold text-ink">{{ $store->name }}</h1>
                        <span
                            class="bg-accent-light text-orange-800 text-xs font-bold px-2.5 py-1 rounded-full">{{ $store->category_name }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-ink-muted flex-wrap">
                        <span class="flex items-center gap-1">
                            <i class="ti ti-star text-accent text-sm"></i> {{ number_format($store->rating, 1, '.', ',') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="ti ti-map-pin text-sm"></i> {{ explode(',', $store->address)[0] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="ti ti-package text-sm"></i> {{ $store->products_count }} produk
                        </span>
                    </div>
                </div>
            </div>

            <p class="text-sm text-ink-muted leading-relaxed max-w-2xl mb-8 sm:mb-10">
                {{ $store->description }}
            </p>
        </div>

        <div class="border-t border-gray-100 pt-8">
            <h2 class="text-lg font-bold text-ink mb-5">Produk dari toko ini</h2>

            <div class="relative max-w-xl mb-5">
                <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-ink-muted"></i>
                <input type="text" id="cari-produk-toko" placeholder="Cari produk di toko ini..."
                    class="w-full pl-11 pr-4 py-3 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
            </div>

            <div class="flex gap-2 flex-wrap mb-6">
                <x-kategori-chip label="Semua" :active="true" data-filter-kategori="semua" />
                @foreach ($products->pluck('category.name')->unique() as $catName)
                    <x-kategori-chip label="{{ $catName }}" data-filter-kategori="{{ $catName }}" />
                @endforeach
            </div>

            <div id="daftar-produk-toko" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
                @forelse ($products as $prod)
                    <div data-row data-kategori="{{ $prod->category->name }}" data-nama="{{ strtolower($prod->name) }}">
                        <x-produk-card
                            :id="$prod->id"
                            :nama="$prod->name"
                            :kategori="$prod->category->name"
                            :harga="$prod->price"
                            :lokasi="explode(',', $store->address)[0]"
                            :rating="$prod->rating"
                            :terjual="$prod->sold_count" />
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-ink-muted text-sm bg-white border border-gray-100 rounded-xl">
                        Toko ini belum memiliki produk aktif.
                    </div>
                @endforelse
            </div>

            <div id="produk-toko-kosong" class="hidden text-center py-12">
                <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                    <i class="ti ti-search-off text-2xl text-ink-muted"></i>
                </div>
                <div class="font-bold text-ink text-sm mb-1">Produk tidak ditemukan</div>
                <p class="text-xs sm:text-sm text-ink-muted">Coba kata kunci atau kategori lain.</p>
            </div>

            <x-pagination target="daftar-produk-toko" :per-page="8" />

            <script>
                (function() {
                    const semuaRow = Array.from(document.querySelectorAll('#daftar-produk-toko [data-row]'));
                    const semuaChip = Array.from(document.querySelectorAll('[data-filter-kategori]'));
                    const inputCari = document.getElementById('cari-produk-toko');
                    let kategoriAktif = 'semua';

                    function terapkanFilter() {
                        const kataKunci = inputCari.value.trim().toLowerCase();

                        semuaRow.forEach(function(row) {
                            const cocokKategori = kategoriAktif === 'semua' || row.dataset.kategori ===
                                kategoriAktif;
                            const cocokNama = kataKunci === '' || row.dataset.nama.includes(kataKunci);
                            row.dataset.tersaring = (cocokKategori && cocokNama) ? 'ya' : 'tidak';
                        });

                        aturUlangPagination();
                    }

                    if (inputCari) {
                        inputCari.addEventListener('input', terapkanFilter);
                    }

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

                        const perPage = parseInt(nav.dataset.perPage || '8');
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

                            const kosong = document.getElementById('produk-toko-kosong');
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
                                row.style.display = (page === currentPage) ? '' : 'none';
                            });

                            numbersWrap.innerHTML = '';
                            for (let i = 1; i <= totalPages; i++) {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.textContent = i;
                                btn.className =
                                    'w-8 h-8 rounded-lg text-sm font-bold transition-colors duration-150 ' +
                                    (i === currentPage ? 'bg-primary text-white' :
                                        'text-ink-muted hover:bg-gray-50');
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
                })();
            </script>
        </div>
    </section>
</x-layouts.guest>
