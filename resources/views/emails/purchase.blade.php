@component('mail::message')
Hola <span style="color: rgb(45, 77, 146)">{{ $member->firstname }} {{ $member->firstname }}</span>,

Gracias por Comprar en Leemon.
<hr class="">
Tu Orden de compra es {{ $order->id}}
<hr class="">
<table>
    <tr>
        <td>
            <h6>Información de Compra</h6>
            <p>
                Via Pago: {{ $order->payment }}
            </p>
        </td>
    </tr>
</table>
Estamos a la espera de recibir la confirmación del pago por parte de tu entidad bancaria en un plazo no mayor a 24 horas.
Una vez confirmado, tu pedido será enviado a nuestro Centro de Distribución para ser preparado. Te enviaremos por correo la notificación cuando vaya en camino a tu domicilio.


<div class="col-12">
    <table>
        <thead>
          <tr>
            <th>PRODUCTO</th>
            <th>PRECIO</th>
            <th>CANT</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($order_details as $detail)
                <tr>
                    <td>{{  $detail->proName }}</td>
                    <td>{{  $detail->proPrice }}</td>
                    <td>{{  $detail->cantidad }}</td>
                    <td>$ {{ $order->amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">SUBTOTAL</td>
                <td class="total">$ {{ $order->amount }}</td>
            </tr>
          <tr>
            <td colspan="4">ENVIO</td>
            <td class="total">$ 0</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$ {{ $order->amount + 0 }}</td>
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
