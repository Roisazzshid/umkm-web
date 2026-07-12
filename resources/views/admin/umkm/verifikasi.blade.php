<x-layouts.admin title="Verifikasi UMKM | Rintasa">
    @php
        $status = $store->status;
    @endphp

    <nav class="text-xs text-ink-muted mb-5">
        <a href="{{ route('admin.umkm.index') }}" class="hover:text-primary">Kelola UMKM</a>
        <span class="mx-1.5">/</span>
        <span class="text-ink">{{ $store->name }}</span>
    </nav>

    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <h1 class="text-xl sm:text-2xl font-bold text-ink">{{ $store->name }}</h1>
        <x-status-badge :status="$status" />
    </div>

    <div class="grid md:grid-cols-[1fr_1.5fr] gap-6">
        <div>
            <div class="w-28 h-28 rounded-2xl bg-primary-light flex items-center justify-center mb-4 overflow-hidden">
                @if ($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                @else
                    <i class="ti ti-building-store text-4xl text-primary"></i>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <div class="text-xs font-bold text-ink-muted mb-1">Nama pemilik</div>
                    <div class="text-sm text-ink">{{ $store->owner_name }}</div>
                </div>
                <div>
                    <div class="text-xs font-bold text-ink-muted mb-1">Email usaha</div>
                    <div class="text-sm text-ink">{{ $store->user->email }}</div>
                </div>
                <div>
                    <div class="text-xs font-bold text-ink-muted mb-1">Nomor WhatsApp</div>
                    <div class="text-sm text-ink">{{ $store->phone }}</div>
                </div>
                <div>
                    <div class="text-xs font-bold text-ink-muted mb-1">Tanggal daftar</div>
                    <div class="text-sm text-ink">{{ $store->created_at->format('j F Y') }}</div>
                </div>
            </div>

            <div>
                <div class="text-xs font-bold text-ink-muted mb-1">Alamat toko</div>
                <div class="text-sm text-ink">{{ $store->address }}</div>
            </div>

            <div>
                <div class="text-xs font-bold text-ink-muted mb-1">Deskripsi usaha</div>
                <p class="text-sm text-ink leading-relaxed">{{ $store->description }}</p>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-100 mt-8 pt-6 flex flex-col sm:flex-row gap-3">
        @if ($status === 'Menunggu')
            <button type="button" id="btn-setujui"
                class="bg-primary hover:bg-primary-dark text-white font-bold text-sm px-6 py-3 rounded-lg transition-colors duration-150">
                Setujui pendaftaran
            </button>
            <button type="button" id="btn-tolak"
                class="bg-white text-red-600 border-2 border-red-200 hover:bg-red-50 font-bold text-sm px-6 py-3 rounded-lg transition-colors duration-150">
                Tolak pendaftaran
            </button>
        @elseif ($status === 'Aktif')
            <button type="button" id="btn-nonaktif"
                class="bg-white text-red-600 border-2 border-red-200 hover:bg-red-50 font-bold text-sm px-6 py-3 rounded-lg transition-colors duration-150">
                Nonaktifkan toko
            </button>
        @else
            <button type="button" id="btn-aktifkan"
                class="bg-primary hover:bg-primary-dark text-white font-bold text-sm px-6 py-3 rounded-lg transition-colors duration-150">
                Aktifkan kembali
            </button>
        @endif
    </div>

    <form id="form-verifikasi" action="{{ route('admin.umkm.verify', $store->id) }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="action" id="input-action">
    </form>

    <div id="modal-konfirmasi" class="hidden fixed inset-0 bg-ink/50 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
            <div id="modal-icon-wrap" class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="modal-icon" class="text-2xl"></i>
            </div>
            <h2 id="modal-judul" class="font-bold text-ink text-base sm:text-lg mb-1.5"></h2>
            <p id="modal-teks" class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6"></p>
            <div class="flex gap-3">
                <button type="button" id="modal-batal"
                    class="flex-1 bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">
                    Batal
                </button>
                <button type="button" id="modal-oke"
                    class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">
                    Oke
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const modal = document.getElementById('modal-konfirmasi');
            const judul = document.getElementById('modal-judul');
            const teks = document.getElementById('modal-teks');
            const iconWrap = document.getElementById('modal-icon-wrap');
            const icon = document.getElementById('modal-icon');
            const btnOke = document.getElementById('modal-oke');
            const btnBatal = document.getElementById('modal-batal');

            const konten = {
                setujui: {
                    judul: 'Setujui pendaftaran ini?',
                    teks: '{{ $store->name }} akan aktif dan langsung bisa login ke dashboard untuk mulai berjualan di Rintasa.',
                    warna: 'green',
                    tombol: 'bg-primary hover:bg-primary-dark'
                },
                tolak: {
                    judul: 'Tolak pendaftaran ini?',
                    teks: 'Pendaftaran ditandai ditolak. Toko ini tidak bisa login sampai mendaftar ulang dengan data yang benar.',
                    warna: 'red',
                    tombol: 'bg-red-600 hover:bg-red-700'
                },
                nonaktif: {
                    judul: 'Nonaktifkan toko ini?',
                    teks: 'Toko tidak bisa login dan produknya hilang dari pencarian sampai diaktifkan kembali.',
                    warna: 'red',
                    tombol: 'bg-red-600 hover:bg-red-700'
                },
                aktifkan: {
                    judul: 'Aktifkan kembali toko ini?',
                    teks: 'Toko bisa login lagi dan langsung muncul di pencarian.',
                    warna: 'green',
                    tombol: 'bg-primary hover:bg-primary-dark'
                }
            };

            function bukaModal(tipe) {
                const data = konten[tipe];
                judul.textContent = data.judul;
                teks.textContent = data.teks;
                iconWrap.className = 'w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 ' + (data
                    .warna === 'green' ? 'bg-green-100' : 'bg-red-100');
                icon.className = 'text-2xl ' + (data.warna === 'green' ? 'ti ti-circle-check text-green-600' :
                    'ti ti-alert-circle text-red-600');
                btnOke.className =
                    'flex-1 text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150 ' + data
                    .tombol;
                modal.dataset.tipe = tipe;
                modal.classList.remove('hidden');
            }

            ['btn-setujui', 'btn-tolak', 'btn-nonaktif', 'btn-aktifkan'].forEach(function(id) {
                const btn = document.getElementById(id);
                if (!btn) return;
                const tipe = id.replace('btn-', '');
                btn.addEventListener('click', function() {
                    bukaModal(tipe);
                });
            });

            btnBatal.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            btnOke.addEventListener('click', function() {
                const tipe = modal.dataset.tipe;
                document.getElementById('input-action').value = tipe;
                document.getElementById('form-verifikasi').submit();
            });
        })();
    </script>
</x-layouts.admin>
