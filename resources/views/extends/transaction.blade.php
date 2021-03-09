
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
  text-align: left;  
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

.table-bordered {
    border: 1px solid #dee2e6;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    color: #212529;
    border-collapse: collapse;
}
.table td{
    width: 50%;
}
.table-success, .table-success > td, .table-success > th {
    background-color: #c3e6cb;
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
         <img src="{{ public_path('img/logo_leemon_small_black.png')  }}"> 
      </div>
      <h1>ORDEN No {{ $order_id }}</h1>
      
      <div id="project">
        <div><span>CLIENTE</span> {{ ucwords($response[10]) }} {{ ucwords($response[11]) }}</div>
        <div><span>EMAIL</span> {{ $response[13] }}</div>
        <div><span>FECHA</span> {{ $response[19] }}</div>
      </div>
    </header>
    <main>
      <div class="container">

      
      <div class="row">
        <div class="col-12 col-md-6">
                
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                    <th colspan="2">Información de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>Fecha</td>
                    <td>{{ $response[19] }}</td>
                    </tr>
                    <tr>
                    <td>Referencia de Pago</td>
                    <td>{{ $response[1] }}</td>
                    </tr>
                    <tr>
                    <td>Descripción</td>
                    <td>{{ $response[8] }}</td>
                    </tr>
                    <tr>
                    <td>Total Pagado</td>
                    <td>$ {{ $response[6] }}</td>
                    </tr>
                </tbody>
            </table>
                
        </div>
        <div class="col-12 col-md-6">
                
            @if ($response[20] == 29)
                <table class="table table-bordered table-sm card-rounded">
                    <thead class="table-success">
                    <tr>
                        <th colspan="2">Información de Transacción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Origen de pago</td>
                        <td>PSE</td>
                    </tr>
                    <tr>
                        <td>IP</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Banco</td>
                        <td>{{ $response[24] }}</td>
                    </tr>
                    <tr>
                        <td>Codigo de Seguimiento</td>
                        <td>{{ $response[21] }}</td>
                    </tr>
                    </tbody>
                </table>

            @elseif ($response[20] == 32)
                <table class="table table-bordered table-sm">
                    <thead class="table-success">
                    <tr>
                        <th colspan="2">Información de Transacción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Origen de pago</td>
                        <td>Tarjeta de Credito</td>
                    </tr>
                    <tr>
                        <td>IP</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Franquicia</td>
                        <td>{{ $response[23] }}</td>
                    </tr>
                    <tr>
                        <td>Codigo de Seguimiento</td>
                        <td>{{ $response[21] }}</td>
                    </tr>
                    </tbody>
                </table>
            @else


            @endif
                
        </div>
    </div>

    {{-- end row --}}
    <div class="row">
        <div class="col-12 col-md-6">
            <table class="table table-bordered table-sm">
                <thead class="table-success">
                    <tr>
                        <th colspan="2">Tus Datos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nombre Completo</td>
                        <td>{{ $response[10] }} {{ $response[11] }}</td>
                    </tr>
                    <tr>
                        <td>Identificación</td>
                        <td>{{ $response[9] }}</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        <div class="col-12 col-md-6">
            <table class="table table-bordered table-sm">
                <thead class="table-success">
                    <tr>
                        <th colspan="2">Información de Comercio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nombre</td>
                        <td>Leemon Nutrición</td>
                    </tr>
                    <tr>
                        <td>Identificación</td>
                        <td>NIT 901.416.234</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
    </main>
    <footer>
      2021 - Leemon Nutrición
    </footer>
  </body>
</html>