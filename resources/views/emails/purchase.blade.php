@component('mail::message')
Hola <span style="color: rgb(45, 77, 146)">{{ $member->firstname }} {{ $member->firstname }}</span>,

Gracias por Comprar en Leemon.
<hr class="">
Tu Orden de compra es {{ $order->id}}
<hr class="">
<table>
    <tr>
        <td>
            <h3>Información de Compra</h3>
            <p>
                Via Pago: {{ $order->payment }}
            </p>
        </td>
    </tr>
</table>
<span>
Estamos a la espera de recibir la confirmación del pago por parte de tu entidad bancaria en un plazo no mayor a 24 horas.
Una vez confirmado, tu pedido será enviado a nuestro Centro de Distribución para ser preparado. Te enviaremos por correo la notificación cuando vaya en camino a tu domicilio.
</span>

<div class="col-12">
    <table class="table" style="width: 100%" >
        <thead>
          <tr>
            <th>PRODUCTO</th>
            <th>DESCRIPCIÓN</th>
            <th>PRECIO</th>
            <th>CANT</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($order_details as $detail)
                <tr>
                    <td><img src="{{ $detail->picture }}" alt="" style="width: 100px"></td>
                    <td><p>{{  $detail->proName }}</p></td>
                    <td><p>{{  $detail->proPrice }}</p></td>
                    <td><p>{{  $detail->cantidad }}</p></td>
                    <td><p>$ {{ $order->amount }}</p></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4"><p>SUBTOTAL</p></td>
                <td class="total"><p>$ {{ $order->amount }}</p></td>
            </tr>
          <tr>
            <td colspan="4"><p>ENVIO</p></td>
            <td class="total"><p>$ 0</p></td>
          </tr>
          <tr>
            <td colspan="4" class="grand total"><p>TOTAL</p></td>
            <td class="grand total"><p>$ {{ $order->amount + 0 }}</p></td>
          </tr>
        </tbody>
      </table>
</div>


@component('mail::button', ['url' => $order->id])
    Ver el Producto
@endcomponent

Gracias,<br>
{{ config('app.name') }} Team
@endcomponent
