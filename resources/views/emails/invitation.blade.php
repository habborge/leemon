@component('mail::message')
# Tu amigo <span style="color: rgb(45, 77, 146)">{{ucwords($member_name)}}</span> Te ha enviado un producto que te puede interesar.
<hr class="">
<div class="col-12">
    <a href="{{ $product_url }}">
        <img src="{{ $product_img }}" alt="" style="width: 400px">
    </a>
    
</div>
<div class="col-12">
    <p>{{ $product_name }}</p>
</div>

@component('mail::button', ['url' => $product_url])
    Ver el Producto
@endcomponent

Gracias,<br>
{{ config('app.name') }} Team
@endcomponent
