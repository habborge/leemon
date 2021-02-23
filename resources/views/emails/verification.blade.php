@component('mail::message')
# <span style="color: rgb(45, 77, 146)">{{ucwords($member_name)}}</span> Gracias por registrarte en Leemon.
Has recivido un codigo de verificación.
<hr class="">

# <span style="color: rgb(45, 77, 146)">Código de Verificación</span>
{{-- # <span style="color: rgb(49, 49, 49)" >{{ $radomNum }}</span> --}}


@component('mail::button', ['url' => ''])
<span style="color: rgb(255, 255, 255); font-size:25px" >{{ $radomNum }}</span>
@endcomponent

Gracias,<br>
{{ config('app.name') }} Team
@endcomponent
