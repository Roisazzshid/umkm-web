<x-layouts.guest title="Pesanan Saya | Rintasa">
    <section class="px-5 md:px-7 py-8 md:py-10 max-w-3xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold text-ink mb-6">Pesanan saya</h1>

        <div class="space-y-3">
            @forelse ($orders as $order)
                @php
                    $firstItem = $order->items->first();
                @endphp
                <div class="flex items-center gap-3 border border-gray-100 rounded-xl p-3 sm:p-4 bg-white">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 rounded-lg bg-primary-light flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if ($firstItem && $firstItem->product && $firstItem->product->image)
                            <img src="{{ asset('storage/' . $firstItem->product->image) }}" class="w-full h-full object-cover">
                        @else
                            <i class="ti ti-photo text-lg sm:text-xl text-white"></i>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-ink text-sm truncate">{{ $firstItem ? $firstItem->product_name : 'Produk' }}</div>
                        <div class="text-xs text-ink-muted truncate">{{ $order->store->name }} &middot; {{ $firstItem ? $firstItem->quantity : 1 }}x &middot; {{ $order->created_at->format('j M Y') }}</div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0" data-status-area>
                        @if ($order->status === 'Selesai')
                            <x-status-badge status="Selesai" />
                            <a href="{{ route('ulasan.create', $firstItem ? $firstItem->product_id : 1) }}"
                                class="bg-accent hover:bg-accent-dark text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors duration-150 whitespace-nowrap">
                                Ulasan
                            </a>
                        @else
                            <span data-badge
                                class="inline-block text-xs font-bold px-2.5 py-1 rounded-full bg-accent-light text-orange-800">Diproses</span>
                            <button type="button" data-btn-terima data-id="{{ $order->id }}"
                                class="border-2 border-primary text-primary text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-primary-light transition-colors duration-150 whitespace-nowrap">
                                Diterima
                            </button>
                            <a href="{{ route('ulasan.create', $firstItem ? $firstItem->product_id : 1) }}" data-btn-ulasan
                                class="hidden bg-accent hover:bg-accent-dark text-white text-xs font-bold px-3 py-2 rounded-lg transition-colors duration-150 whitespace-nowrap">
                                Ulasan
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-ink-muted text-sm border border-gray-100 rounded-xl bg-white">
                    Kamu belum pernah memesan produk apapun.
                </div>
            @endforelse
        </div>

        <script>
            document.querySelectorAll('[data-btn-terima]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = btn.dataset.id;

                    fetch(`/pesanan/${id}/terima`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const area = btn.closest('[data-status-area]');
                            const badge = area.querySelector('[data-badge]');

                            badge.textContent = 'Selesai';
                            badge.className =
                                'inline-block text-xs font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700';

                            btn.remove();
                            area.querySelector('[data-btn-ulasan]').classList.remove('hidden');
                        } else {
                            alert('Gagal memperbarui status pesanan.');
                        }
                    })
                    .catch(() => alert('Terjadi kesalahan koneksi.'));
                });
            });
        </script>
    </section>
</x-layouts.guest>
