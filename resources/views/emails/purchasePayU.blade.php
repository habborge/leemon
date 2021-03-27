@component('mail::message')
Hola <span style="color: rgb(45, 77, 146)">{{ $member->firstname }} {{ $member->lastname }}</span>,

Gracias por Comprar en Leemon.
<hr class="">
Tu Orden de compra No {{ $order['id']}}
<hr class="">
<span id="parrafo">
  Hemos recibido tu orden y empezaremos a procesarla. Pronto recibirás un correo con la confirmación de envío. Recuerda que el tiempo de entrega comienza a partir de la confirmación del pago.
</span>
<br><br><br>
<table>
    <tr>
        <td>
            <h3>Información de Compra</h3>
            <p>
                Cliente: {{ $member->firstname }} {{ $member->lastname }}<br>
                Via Pago: {{ $order['payment'] }}<br>
                Valor: {{ $order['amount'] }}<br>
            </p>
        </td>
    </tr>
</table>


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
                    <td><img src="{{ $detail->picture }}" alt="" style="width: 50px"></td>
                    <td><p>{{  $detail->proName }}</p></td>
                    <td><p>{{  $detail->proPrice }}</p></td>
                    <td><p>{{  $detail->cantidad }}</p></td>
                    <td><p>$ {{ $order->amount }}</p></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4"><p>SUBTOTAL</p></td>
                <td class="total"><p>$ {{ $order['amount'] }}</p></td>
            </tr>
          <tr>
            <td colspan="4"><p>ENVIO</p></td>
            <td class="total"><p>$ {{ $order['delivery_cost'] }}</p></td>
          </tr>
          <tr>
            <td colspan="4" class="grand total"><p>TOTAL</p></td>
            <td class="grand total"><p>$ {{ $order['amount'] + $order['delivery_cost'] }}</p></td>
          </tr>
        </tbody>
      </table>
</div>


@component('mail::button', ['url' =>  config('app.url')  ])
    Estado de tu Orden
@endcomponent

Gracias,<br>
{{ config('app.name') }} Team
@endcomponent
