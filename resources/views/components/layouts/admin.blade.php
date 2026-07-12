<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard admin | Rintasa' }}</title>
    <link class="icon" type="image/png" href="{{ asset('assets/logo/logo-rintasa.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-ink font-sans min-h-screen">
    <div class="md:grid md:grid-cols-[220px_1fr] min-h-screen">
        <div
            class="md:hidden fixed top-0 left-0 right-0 bg-white border-b border-gray-100 flex items-center justify-between px-4 py-3 z-40">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/logo/logo-rintasa.png') }}" alt="Logo Rintasa"
                    class="w-7 h-7 object-contain">
                <span class="font-bold text-sm text-ink">Admin panel</span>
            </div>
            <button id="sidebar-toggle" class="text-ink text-xl" aria-label="Buka menu" aria-expanded="false">
                <i class="ti ti-menu-2" id="sidebar-toggle-icon"></i>
            </button>
        </div>

        <div id="sidebar-backdrop" class="hidden fixed inset-0 bg-ink/40 z-40 md:hidden"></div>

        <aside id="sidebar"
            class="hidden md:flex md:flex-col fixed md:static top-0 left-0 bottom-0 w-64 md:w-auto bg-gray-50 border-r border-gray-100 p-3.5 z-50 overflow-y-auto">
            <div class="flex items-center justify-between px-2 pb-5">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/logo/logo-rintasa.png') }}" alt="Logo Rintasa"
                        class="w-7 h-7 object-contain">
                    <span class="font-bold text-sm text-ink">Admin panel</span>
                </div>
                <button id="sidebar-close" class="md:hidden text-ink text-lg" aria-label="Tutup menu">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <x-sidebar-item icon="ti-layout-dashboard" label="Dashboard" href="{{ route('admin.dashboard') }}"
                :active="request()->routeIs('admin.dashboard')" />
            <x-sidebar-item icon="ti-building-store" label="Kelola UMKM" href="{{ route('admin.umkm.index') }}"
                :active="request()->routeIs('admin.umkm.*')" />
            <x-sidebar-item icon="ti-category" label="Kelola kategori" href="{{ route('admin.kategori') }}"
                :active="request()->routeIs('admin.kategori')" />
            <x-sidebar-item icon="ti-chart-bar" label="Laporan" href="{{ route('admin.laporan') }}" :active="request()->routeIs('admin.laporan')" />

            <div class="mt-auto pt-4 border-t border-gray-200">
                <button type="button" id="btn-logout"
                    class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-red-600 hover:bg-red-50 transition-colors duration-150">
                    <i class="ti ti-logout text-lg"></i>
                    <span class="text-sm font-bold">Keluar</span>
                </button>
            </div>
        </aside>

        <main class="p-5 md:p-7 pt-20 md:pt-7">
            {{ $slot }}
        </main>
    </div>

    <div id="modal-logout" class="hidden fixed inset-0 bg-ink/55 flex items-center justify-center px-5 z-50">
        <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full text-center">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-logout text-2xl text-red-600"></i>
            </div>
            <h2 class="font-bold text-ink text-base sm:text-lg mb-1.5">Keluar dari akun admin?</h2>
            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">Kamu perlu login lagi untuk mengakses
                dashboard admin.</p>
            <div class="flex gap-3">
                <button type="button" id="modal-logout-batal"
                    class="flex-1 bg-white text-ink border-2 border-gray-200 hover:bg-gray-50 font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Batal</button>
                <button type="button" id="modal-logout-oke"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-sm py-2.5 rounded-lg transition-colors duration-150">Keluar</button>
            </div>
        </div>
    </div>

    <form id="form-logout" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        (function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggle = document.getElementById('sidebar-toggle');
            const toggleIcon = document.getElementById('sidebar-toggle-icon');
            const closeBtn = document.getElementById('sidebar-close');

            function openSidebar() {
                sidebar.classList.remove('hidden');
                backdrop.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
                toggleIcon.className = 'ti ti-x';
            }

            function closeSidebar() {
                sidebar.classList.add('hidden');
                backdrop.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
                toggleIcon.className = 'ti ti-menu-2';
            }

            toggle.addEventListener('click', function() {
                sidebar.classList.contains('hidden') ? openSidebar() : closeSidebar();
            });
            closeBtn.addEventListener('click', closeSidebar);
            backdrop.addEventListener('click', closeSidebar);

            const modalLogout = document.getElementById('modal-logout');
            document.getElementById('btn-logout').addEventListener('click', function() {
                modalLogout.classList.remove('hidden');
            });
            document.getElementById('modal-logout-batal').addEventListener('click', function() {
                modalLogout.classList.add('hidden');
            });
            document.getElementById('modal-logout-oke').addEventListener('click', function() {
                document.getElementById('form-logout').submit();
            });
        })();
    </script>
</body>

</html>
