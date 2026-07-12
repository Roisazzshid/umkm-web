@props(['icon', 'nomor', 'title', 'desc'])

<div class="relative text-center px-2">
    <div class="relative w-16 h-16 sm:w-[72px] sm:h-[72px] rounded-full bg-primary flex items-center justify-center mx-auto mb-3.5">
        <i class="ti {{ $icon }} text-2xl sm:text-3xl text-white"></i>
        <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center">
            {{ $nomor }}
        </div>
    </div>
    <div class="font-bold text-ink text-sm mb-1">{{ $title }}</div>
    <p class="text-xs text-ink-muted leading-relaxed">{{ $desc }}</p>
</div>
