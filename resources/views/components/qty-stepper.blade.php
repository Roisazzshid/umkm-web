@props(['name' => 'jumlah', 'value' => 1, 'min' => 1, 'max' => 99])

<div class="inline-flex items-center border border-gray-200 rounded-lg" data-qty-stepper>
    <button type="button" class="w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center text-ink hover:bg-gray-50 transition-colors duration-150" data-qty-minus aria-label="Kurangi jumlah">
        <i class="ti ti-minus text-sm"></i>
    </button>
    <input type="number" name="{{ $name }}" value="{{ $value }}" min="{{ $min }}" max="{{ $max }}"
        class="w-12 sm:w-14 text-center text-sm font-bold text-ink border-x border-gray-200 py-2 focus:outline-none" data-qty-input>
    <button type="button" class="w-10 h-10 sm:w-11 sm:h-11 flex items-center justify-center text-ink hover:bg-gray-50 transition-colors duration-150" data-qty-plus aria-label="Tambah jumlah">
        <i class="ti ti-plus text-sm"></i>
    </button>
</div>

<script>
document.querySelectorAll('[data-qty-stepper]:not([data-bound])').forEach(function (stepper) {
    stepper.setAttribute('data-bound', 'true');
    const input = stepper.querySelector('[data-qty-input]');
    const minus = stepper.querySelector('[data-qty-minus]');
    const plus = stepper.querySelector('[data-qty-plus]');
    minus.addEventListener('click', function () {
        const min = parseInt(input.min || '1');
        input.value = Math.max(min, parseInt(input.value || '1') - 1);
    });
    plus.addEventListener('click', function () {
        const max = parseInt(input.max || '99');
        input.value = Math.min(max, parseInt(input.value || '1') + 1);
    });
});
</script>
