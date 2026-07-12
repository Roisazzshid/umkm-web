@props(['icon', 'label', 'href' => '#', 'active' => false])

<a href="{{ $href }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg mb-1 {{ $active ? 'bg-primary-light text-primary font-medium' : 'text-ink-muted hover:bg-gray-50' }}">
    <i class="ti {{ $icon }} text-lg"></i>
    <span class="text-sm">{{ $label }}</span>
</a>
