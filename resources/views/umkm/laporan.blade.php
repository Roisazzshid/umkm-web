<x-layouts.umkm title="Laporan | Rintasa">
    <h1 class="text-xl sm:text-2xl font-bold text-ink mb-5">Laporan performa toko</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <x-stat-card icon="ti-shopping-cart" value="{{ number_format($totalOrder, 0, ',', '.') }}" label="Total pesanan" />
        <x-stat-card icon="ti-truck-delivery" value="{{ number_format($totalSold, 0, ',', '.') }}" label="Produk terjual" />
        <x-stat-card icon="ti-package" value="{{ number_format($totalProduct, 0, ',', '.') }}" label="Produk aktif" />
        <x-stat-card icon="ti-star" value="{{ number_format($averageRating, 1, '.', ',') }}" label="Rating toko" icon-color="text-accent" />
    </div>

    <div class="border border-gray-100 rounded-xl p-5 mb-8">
        <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
            <div class="font-bold text-ink text-sm">Tren pesanan</div>
            <select id="filter-rentang" class="border border-gray-200 rounded-lg text-sm px-3 py-1.5 focus:outline-none focus:border-primary">
                <option value="3">3 bulan terakhir</option>
                <option value="6" selected>6 bulan terakhir</option>
                <option value="12">12 bulan terakhir</option>
            </select>
        </div>
        <div class="h-60">
            <canvas id="chart-tren"></canvas>
        </div>
    </div>

    <div class="border border-gray-100 rounded-xl p-5">
        <div class="font-bold text-ink text-sm mb-4">Produk terlaris di toko ini</div>
        <div class="h-60">
            <canvas id="chart-produk"></canvas>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            const dataTren = @json($dataTren);

            const chartTren = new Chart(document.getElementById('chart-tren'), {
                type: 'line',
                data: {
                    labels: dataTren[6].label,
                    datasets: [{
                        label: 'Pesanan',
                        data: dataTren[6].data,
                        borderColor: '#1E56B0',
                        backgroundColor: 'rgba(30, 86, 176, 0.08)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#1E56B0'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F1F3F6' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            document.getElementById('filter-rentang').addEventListener('change', function (e) {
                const rentang = dataTren[e.target.value];
                chartTren.data.labels = rentang.label;
                chartTren.data.datasets[0].data = rentang.data;
                chartTren.update();
            });

            new Chart(document.getElementById('chart-produk'), {
                type: 'bar',
                data: {
                    labels: @json($produkLabels),
                    datasets: [{ label: 'Terjual', data: @json($produkData), backgroundColor: '#F2701C', borderRadius: 6, maxBarThickness: 22 }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true, grid: { color: '#F1F3F6' } }, y: { grid: { display: false } } }
                }
            });
        });
    </script>
</x-layouts.umkm>
