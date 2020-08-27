@component('mail::message')
# Gracias por su Compra

Apreciado {{$customer}}

@component('mail::button', ['url' => ''])
En Leemon estamos felices de que hayas adquirido nuestros productos, adjunto en este correo encontraras tu Orden de compra.
@endcomponent

Gracias,<br>
{{ config('app.name') }} Team
@endcomponent
