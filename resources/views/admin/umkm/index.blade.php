<x-layouts.admin title="Kelola UMKM | Rintasa">
    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-5">Kelola UMKM</h1>

    @php
        $berhasil = request()->query('berhasil');
        $pesanBerhasil = [
            'setujui' => 'Pendaftaran UMKM berhasil disetujui.',
            'tolak' => 'Pendaftaran UMKM berhasil ditolak.',
            'nonaktif' => 'Toko berhasil dinonaktifkan.',
            'aktifkan' => 'Toko berhasil diaktifkan kembali.',
        ];
    @endphp

    <div id="banner-sukses"
        class="{{ $berhasil && isset($pesanBerhasil[$berhasil]) ? '' : 'hidden' }} bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-3.5 mb-5 flex items-center gap-2.5 transition-opacity duration-300">
        <i class="ti ti-circle-check text-lg flex-shrink-0"></i>
        <span id="banner-sukses-teks">{{ $pesanBerhasil[$berhasil] ?? '' }}</span>
    </div>

    <div class="relative max-w-md mb-4">
        <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-ink-muted"></i>
        <input type="text" id="cari-umkm" placeholder="Cari nama UMKM..."
            class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-primary transition-colors duration-150">
    </div>

    <div class="flex gap-2 flex-wrap mb-5">
        <x-kategori-chip label="Semua" :active="true" data-filter-status="semua" />
        <x-kategori-chip label="Menunggu" data-filter-status="Menunggu" />
        <x-kategori-chip label="Aktif" data-filter-status="Aktif" />
        <x-kategori-chip label="Nonaktif" data-filter-status="Nonaktif" />
    </div>

    <div id="tabel-umkm" class="border border-gray-100 rounded-xl overflow-hidden">
        <div class="hidden sm:grid grid-cols-[1fr_1fr_1fr_0.7fr] px-4 py-3 bg-gray-50 text-xs font-bold text-ink-muted">
            <span>Nama UMKM</span><span class="text-center">Tanggal daftar</span><span
                class="text-center">Status</span><span class="text-center">Aksi</span>
        </div>

        @foreach ($stores as $st)
        <div data-row data-nama="{{ strtolower($st->name) }}" data-status="{{ $st->status }}"
            class="flex sm:grid sm:grid-cols-[1fr_1fr_1fr_0.7fr] px-4 py-3 border-t border-gray-100 items-center gap-3 sm:gap-4">
            <span class="font-bold text-ink text-sm flex-1 min-w-0 truncate">{{ $st->name }}</span>
            <span class="hidden sm:block text-ink-muted text-sm whitespace-nowrap text-center">{{ $st->created_at->format('j M Y') }}</span>
            <div class="flex-1 flex justify-center">
                <x-status-badge :status="$st->status" />
            </div>
            @if ($st->status === 'Menunggu')
                <a href="{{ route('admin.umkm.verifikasi', $st->id) }}?status=Menunggu"
                    class="bg-accent hover:bg-accent-dark text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors duration-150 text-center flex-shrink-0 sm:w-fit sm:justify-self-center">Tinjau</a>
            @else
                <a href="{{ route('admin.umkm.verifikasi', $st->id) }}?status={{ $st->status }}"
                    class="text-primary hover:text-primary-dark text-xs font-bold px-3 py-2 text-center flex-shrink-0 sm:w-fit sm:justify-self-center">Lihat</a>
            @endif
        </div>
        @endforeach
    </div>

    <div id="umkm-kosong" class="hidden text-center py-12">
        <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <i class="ti ti-search-off text-2xl text-ink-muted"></i>
        </div>
        <div class="font-bold text-ink text-sm mb-1">UMKM tidak ditemukan</div>
        <p class="text-xs sm:text-sm text-ink-muted">Coba kata kunci atau filter status lain.</p>
    </div>

    <x-pagination target="tabel-umkm" :per-page="5" />

    <script>
        (function() {
            const semuaRow = Array.from(document.querySelectorAll('#tabel-umkm [data-row]'));
            const semuaChip = Array.from(document.querySelectorAll('[data-filter-status]'));
            const inputCari = document.getElementById('cari-umkm');
            let statusAktif = 'semua';

            function terapkanFilter() {
                const kataKunci = inputCari.value.trim().toLowerCase();

                semuaRow.forEach(function(row) {
                    const cocokStatus = statusAktif === 'semua' || row.dataset.status === statusAktif;
                    const cocokNama = kataKunci === '' || row.dataset.nama.includes(kataKunci);
                    row.dataset.tersaring = (cocokStatus && cocokNama) ? 'ya' : 'tidak';
                });

                aturUlangPagination();
            }

            inputCari.addEventListener('input', terapkanFilter);

            semuaChip.forEach(function(chip) {
                chip.addEventListener('click', function() {
                    statusAktif = chip.dataset.filterStatus;
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

                    const kosong = document.getElementById('umkm-kosong');
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
                window.history.replaceState({}, '', window.location.pathname);
            }
        })();
    </script>
</x-layouts.admin>
