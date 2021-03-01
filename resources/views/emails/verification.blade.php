@component('mail::message')
# <span style="color: rgb(45, 77, 146)">{{ucwords($member_name)}}</span> Gracias por registrarte en Leemon.
Has recibido un código de verificación.
<hr class="">

# <span style="color: rgb(45, 77, 146)">Código de Verificación</span>
{{-- # <span style="color: rgb(49, 49, 49)" >{{ $radomNum }}</span> --}}



<div style="text-align: center"><div style="width:150px; margin:0px auto; padding:5px; background-color:rgb(18, 31, 66)"><span style="color: rgb(235, 235, 235); font-size:25px" >{{ $radomNum }}</span></div></div>


Gracias,<br>
{{ config('app.name') }} Team
@endcomponent
