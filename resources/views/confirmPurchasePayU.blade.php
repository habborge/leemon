@extends('layouts.app')

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
                            <td>{{ $response["processingDate"] }}</td>
                            </tr>
                            <tr>
                            <td>Referencia de Pago</td>
                            <td>{{ $response["referenceCode"] }}</td>
                            </tr>
                            <tr>
                            <td>Descripción</td>
                            <td>{{ $response["description"] }}</td>
                            </tr>
                            <tr>
                            <td>Total Pagado</td>
                            <td>$ {{ $response["total"] }}</td>
                            </tr>
                        </tbody>
                    </table>
                        
                </div>
                <div class="col-12 col-md-6">
                        
                    
                        <table class="table table-bordered table-sm card-rounded">
                            <thead class="table-success">
                            <tr>
                                <th colspan="2">Información de Transacción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Origen de pago</td>
                                <td>{{ $response["origen"] }}</td>
                            </tr>
                            <tr>
                                <td>IP</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Referencia</td>
                                <td>{{ $response["reference"] }}</td>
                            </tr>
                            </tbody>
                        </table>

                    


                   
                        
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
                                <td>{{ $response["name"] }}</td>
                            </tr>
                            <tr>
                                <td>Identificación</td>
                                <td>{{ $response["n_doc"] }}</td>
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
                            <a href="/legality/payment-result/downloadPayU-pdf/{{$url}}" class="btn btn-danger btn-width"><i class="fa fa-file-pdf-o"></i> Descarga PDF</a>
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