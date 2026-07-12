@props(['status'])

@php
$styles = [
    'Diproses' => 'bg-accent-light text-orange-800',
    'Selesai' => 'bg-green-100 text-green-700',
    'Menunggu' => 'bg-accent-light text-orange-800',
    'Aktif' => 'bg-green-100 text-green-700',
    'Nonaktif' => 'bg-gray-100 text-gray-600',
];
$style = $styles[$status] ?? 'bg-gray-100 text-gray-600';
@endphp

<span class="inline-block w-fit text-xs font-bold px-2.5 py-1 rounded-full {{ $style }}">{{ $status }}</span>
