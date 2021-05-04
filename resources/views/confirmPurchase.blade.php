@extends('layouts.app')
@section('custom-css')
    <title>Leemon - Confirmar Compra</title>
@endsection
@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="alert @if ($approval == 1) alert-success @else alert-danger @endif card-rounded" role="alert" style="width: 100%">
                    <h4 class="alert-heading">@if ($approval == 1) Transacción Aprobada @else Atención @endif</h4>
                    <p>{{ $message }}</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{ url('/') }}" class="btn btn-leemon-back">
                            Continuar Navegando
                        </a>
                    </p>
                </div>
            </div>
            
        </div>
        @if ($response == "error")
        @else
            <div class="row">
                <div class="col-12 col-md-6">
                        
                    <table class="table table-bordered table-sm card-rounded">
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
                            <thead class="bg-success">
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
            {{-- end row --}}
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-4 text-center">
                            <a href="/legality/payment-result/download-pdf/{{$url}}" class="btn btn-danger btn-width"><i class="fa fa-file-pdf-o"></i> Descarga PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>
@endsection