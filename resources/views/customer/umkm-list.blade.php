<x-layouts.guest title="UMKM | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-6xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-5">Semua UMKM</h1>

        <div class="relative max-w-xl mb-5">
            <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-ink-muted"></i>
            <input type="text" id="cari-umkm" placeholder="Cari UMKM..."
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

        <div id="daftar-umkm" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($stores as $st)
                <div data-row data-nama="{{ strtolower($st->name) }}" data-kategori="{{ $st->category_name }}">
                    <x-umkm-card
                        :id="$st->id"
                        :nama="$st->name"
                        :kategori="$st->category_name"
                        :lokasi="explode(',', $st->address)[0]"
                        :rating="$st->rating"
                        :jumlah-produk="$st->products_count" />
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-ink-muted text-sm bg-white border border-gray-100 rounded-xl">
                    Belum ada mitra UMKM terdaftar yang aktif.
                </div>
            @endforelse
        </div>
    </section>

    <script>
        (function() {
            const inputCari = document.getElementById('cari-umkm');
            const semuaRow = Array.from(document.querySelectorAll('#daftar-umkm [data-row]'));
            const semuaChip = Array.from(document.querySelectorAll('[data-filter-kategori]'));
            let kategoriAktif = 'semua';

            function terapkanFilter() {
                const kataKunci = inputCari.value.trim().toLowerCase();
                semuaRow.forEach(function(row) {
                    const cocokKategori = kategoriAktif === 'semua' || row.dataset.kategori === kategoriAktif;
                    const cocokNama = kataKunci === '' || row.dataset.nama.includes(kataKunci);
                    if (cocokKategori && cocokNama) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            if (inputCari) {
                inputCari.addEventListener('input', terapkanFilter);
            }

            semuaChip.forEach(function(chip) {
                chip.addEventListener('click', function() {
                    kategoriAktif = chip.dataset.filterKategori;
                    semuaChip.forEach(c => {
                        c.classList.remove('bg-primary', 'text-white', 'border-primary');
                        c.classList.add('bg-white', 'text-ink-muted', 'border-gray-200');
                    });
                    chip.classList.remove('bg-white', 'text-ink-muted', 'border-gray-200');
                    chip.classList.add('bg-primary', 'text-white', 'border-primary');
                    terapkanFilter();
                });
            });
        })();
    </script>
</x-layouts.guest>
