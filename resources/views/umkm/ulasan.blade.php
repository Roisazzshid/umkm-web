<x-layouts.umkm title="Ulasan dan rating | Rintasa">
    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-6">Ulasan dan rating</h1>

    <div class="border border-gray-100 rounded-xl p-5 sm:p-6 mb-8">
        <div class="grid sm:grid-cols-[160px_1fr] gap-6 items-center">
            <div class="text-center sm:border-r sm:border-gray-100 sm:pr-6">
                <div class="text-4xl font-bold text-ink mb-1">{{ number_format($averageRating, 1, '.', ',') }}</div>
                <div class="flex items-center justify-center gap-0.5 mb-1.5">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="ti ti-star {{ $i <= round($averageRating) ? 'text-accent' : 'text-gray-200' }} text-base"></i>
                    @endfor
                </div>
                <div class="text-xs text-ink-muted">{{ $totalReviews }} ulasan</div>
            </div>

            <div class="space-y-2">
                @for ($star = 5; $star >= 1; $star--)
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs text-ink-muted w-10 flex-shrink-0">{{ $star }} <i
                                class="ti ti-star text-accent text-xs"></i></span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: {{ $percentages[$star] }}%"></div>
                        </div>
                        <span class="text-xs text-ink-muted w-6 flex-shrink-0 text-right">{{ $counts[$star] }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="flex gap-2 flex-wrap mb-4">
        <x-kategori-chip label="Semua" :active="true" data-filter-bintang="semua" />
        <x-kategori-chip label="5 bintang" data-filter-bintang="5" />
        <x-kategori-chip label="4 bintang" data-filter-bintang="4" />
        <x-kategori-chip label="3 bintang" data-filter-bintang="3" />
        <x-kategori-chip label="2 bintang" data-filter-bintang="2" />
        <x-kategori-chip label="1 bintang" data-filter-bintang="1" />
    </div>

    <div class="font-bold text-ink text-base mb-4">Semua ulasan</div>

    <div id="daftar-ulasan" class="space-y-3">
        @forelse ($reviews as $rev)
            <div data-row data-bintang="{{ $rev->rating }}" class="border border-gray-100 rounded-xl p-4">
                <div class="flex items-center justify-between mb-1.5 flex-wrap gap-1">
                    <span class="font-bold text-ink text-sm">{{ $rev->customer->name }}</span>
                    <span class="flex items-center gap-1 text-xs text-accent">
                        <i class="ti ti-star"></i> {{ number_format($rev->rating, 1, '.', ',') }}
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted mb-1.5">{{ $rev->comment }}</p>
                <div class="text-xs text-ink-muted">{{ $rev->product->name }} &middot; {{ $rev->created_at->format('j M Y') }}</div>
            </div>
        @empty
            <div class="p-5 text-center text-sm text-ink-muted border border-gray-100 rounded-xl bg-white">
                Belum ada ulasan untuk produk Anda.
            </div>
        @endforelse
    </div>

    <div id="ulasan-kosong" class="hidden text-center py-12">
        <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <i class="ti ti-star-off text-2xl text-ink-muted"></i>
        </div>
        <div class="font-bold text-ink text-sm mb-1">Belum ada ulasan</div>
        <p class="text-xs sm:text-sm text-ink-muted">Tidak ada ulasan dengan rating ini untuk saat ini.</p>
    </div>

    <x-pagination target="daftar-ulasan" :per-page="5" />

    <script>
        (function() {
            const semuaRow = Array.from(document.querySelectorAll('#daftar-ulasan [data-row]'));
            const semuaChip = Array.from(document.querySelectorAll('[data-filter-bintang]'));
            let bintangAktif = 'semua';

            function terapkanFilter() {
                semuaRow.forEach(function(row) {
                    const cocok = bintangAktif === 'semua' || row.dataset.bintang === bintangAktif;
                    row.dataset.tersaring = cocok ? 'ya' : 'tidak';
                });
                aturUlangPagination();
            }

            semuaChip.forEach(function(chip) {
                chip.addEventListener('click', function() {
                    bintangAktif = chip.dataset.filterBintang;
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

                    const kosong = document.getElementById('ulasan-kosong');

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
        })();
    </script>
</x-layouts.umkm>
