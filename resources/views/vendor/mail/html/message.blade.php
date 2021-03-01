@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => env('APP_URL')."/img/logo_leemon_small_white.png"])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('Todos los Derechos Reservados.')
@endcomponent
@endslot
@endcomponent
