@props(['label', 'active' => false])

<button {{ $attributes }} class="px-4 py-2 rounded-full text-sm font-medium border transition-colors duration-150
    {{ $active ? 'bg-primary text-white border-primary hover:border-primary' : 'bg-white text-ink-muted border-gray-200 hover:border-primary' }}">
    {{ $label }}
</button>
