@props(['target', 'perPage' => 5])

<div class="flex items-center justify-between mt-4 flex-wrap gap-3" data-pagination data-target="{{ $target }}" data-per-page="{{ $perPage }}">
    <button type="button" data-page-prev class="flex items-center gap-1 text-sm font-bold text-ink-muted hover:text-primary disabled:opacity-40 disabled:cursor-not-allowed transition-colors duration-150">
        <i class="ti ti-chevron-left"></i> Sebelumnya
    </button>
    <div data-page-numbers class="flex items-center gap-1"></div>
    <button type="button" data-page-next class="flex items-center gap-1 text-sm font-bold text-ink-muted hover:text-primary disabled:opacity-40 disabled:cursor-not-allowed transition-colors duration-150">
        Selanjutnya <i class="ti ti-chevron-right"></i>
    </button>
</div>
