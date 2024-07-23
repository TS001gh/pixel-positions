@php
    $classes = 'p-4 bg-white/5 rounded-xl border border-transparent hover:border-secondary transition-colors group';
@endphp

<div {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</div>
