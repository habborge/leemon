
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    
  </head>
  <style>
        .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 18cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 250px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
.rojo{
    color: red;
}
    </style>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{ public_path('img/').$data[0]->id.'.png'  }}">
      </div>
      <h1>ORDEN No {{ $data[0]->id }}</h1>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
        <div><span>CLIENTE</span> {{ $data[0]->customer }}</div>
        <div><span>DIRECCIÓN</span> {{ $data[0]->delivery_address }}</div>
        <div><span>EMAIL</span> {{ $data[0]->email }}</div>
        <div><span>FECHA</span> {{ $data[0]->created_at }}</div>
        
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">PRODUCTO</th>
            <th class="desc">DESCRIPCIÓN</th>
            <th>PRECIO</th>
            <th>CANT</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
            <?php 
                $total = 0;
                $delivery = 0;
            ?>
            @for ($i = 0; $i < count($data[1]); $i++)
                <?php 
                $whole = 0;
                $half = 0;
                $nq = 0;
                $h = 0;
                $discount = 0;
                if (($data[1][$i]['prom'] == 1) and ($data[1][$i]['quantity'] >= 2 )){
                    $whole = (int) ($data[1][$i]['quantity'] / 2);
                    $h = (2 * $whole) + $whole;
                    $nq = $data[1][$i]['quantity'] + ($h - $data[1][$i]['quantity']);
                    $discount = round($data[1][$i]['price'] * $whole);
                    //$data[1][$i]['quantity'] = $nq;

                }else if (($data[1][$i]['prom'] == 2) and ($data[1][$i]['quantity'] >= 2)){
                    $whole = (int) ($data[1][$i]['quantity'] / 2);
                    $half = round(($data[1][$i]['price'] / 2) * $whole);
                    $nq = $data[1][$i]['quantity'];
                }else{
                    $nq = $data[1][$i]['quantity'];
                }
                
                    $total += ($data[1][$i]['price'] * $nq) - $half - $discount;
                    $delivery += $data[1][$i]['delivery_cost'] * $nq;
                ?>
                <tr>
                    <td class="service">{{  $data[1][$i]['name']}}</td>
                    <td class="desc">Descripción del producto con sus detalles
                        @if ($data[1][$i]['prom'] == 1) 
                            <br><span class="">Paga 2 Lleva 3</span>
                        @elseif ($data[1][$i]['prom'] == 2)
                            <br><span class="">2nd 50% off</span>
                        @endif
                    </td>
                    <td class="unit">{{  $data[1][$i]['price']}}</td>
                    <td class="qty">{{  $data[1][$i]['quantity']}}
                        @if ($discount > 0)
                            <br>+ {{ $whole }} Art Free.
                        @endif
                    </td>
                    <td class="total">
                        $ {{ $data[1][$i]['price'] * $nq}}
                        @if ($half > 0)
                            <br> <span class="rojo">$ ({{ $half }})</span>
                        @elseif ($discount > 0)
                            <br> <span class="rojo">$ ({{ $discount }})</span>
                        @else
                        @endif
                            <br>A pagar<br>$ {{ ($data[1][$i]['price'] * $nq) - $half - $discount }}
                    </td>
                  </tr>
            @endfor
            
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$ {{ $total }}<br>
                </td>
          </tr>
          <tr>
            <td colspan="4">ENVIO</td>
            <td class="total">$ {{ $delivery }}</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$ {{ $total + $delivery }}</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTA:</div>
        <div class="notice">Pago realizado {{ $data[0]->payment }}</div>
      </div>
    </main>
    <footer>
      Leemon compañia - Colombia
    </footer>
  </body>
</html>