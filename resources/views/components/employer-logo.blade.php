@props(['employer', 'width' => '90'])

{{-- aseet will prepare full url --}}
<img src="{{ asset($employer->logo) }}" alt="" class="rounded-xl" width="{{ $width }}">
