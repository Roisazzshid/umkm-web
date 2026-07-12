@props(['icon', 'value', 'label', 'iconColor' => 'text-primary'])

<div class="bg-gray-50 rounded-lg p-3.5">
    <i class="ti {{ $icon }} text-lg {{ $iconColor }}"></i>
    <div class="text-xl font-bold text-ink mt-2">{{ $value }}</div>
    <div class="text-xs text-ink-muted">{{ $label }}</div>
</div>
