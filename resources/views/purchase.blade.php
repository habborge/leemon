@extends('layouts.app')

@section('content')
<div class="bg-purchase">
    @if ($infosaved == 0)
        <div class="container bg-light">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72" alt="logo leemon">
                <h2>Formulario de Pago</h2> @if ($errors) {{ $errors }} @endif
                <p class="lead">Complete su información para procesar su compra.</p>
            </div>
        
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Información de Facturación</h4>
                    <form class="needs-validation" action="{{ route('saveinfo') }}" method="POST" name="formaut" id="formRegisterwithdrawal" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname">Nombre</label>
                                <input type="text" class="form-control @if ($errors-> has('firstname'))  is-invalid @endif" name="firstname" id="firstname" placeholder="" value="@if(!empty($completeRequest->firstname)){{$completeRequest->firstname}}@endif" required>
                                <div class="invalid-feedback">
                                    El campo Nombre es requerido. 
                                </div>
                                
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control @if ($errors-> has('lastname'))  is-invalid @endif" name="lastname" id="lastname" placeholder="" value="@if(!empty($completeRequest->lastname)){{$completeRequest->lastname}}@endif" required>
                                <div class="invalid-feedback">
                                    El campo Apellidos es requerido.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">Número ID</label>
                                <input type="text" class="form-control @if ($errors-> has('n_doc'))  is-invalid @endif" name="n_doc" id="n_doc" placeholder="" value="@if(!empty($completeRequest->n_doc)){{$completeRequest->n_doc}}@endif" required>
                                <div class="invalid-feedback">
                                    El número de Indentificación es requerido.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @if ($errors-> has('email'))  is-invalid @endif" name="email" id="email" value="@if(!empty($completeRequest->email)){{$completeRequest->email}}@endif" placeholder="">
                                <div class="invalid-feedback">
                                    Ingrese un email valido para las actualizaciones de entrega.
                                </div>
                            </div>
                        </div>
                        
        
                        <div class="mb-3">
                            <label for="address">Dirección de Facturación</label>
                            <input type="text" class="form-control @if ($errors-> has('address'))  is-invalid @endif" name="address" id="address" value="@if(!empty($completeRequest->address)){{$completeRequest->address}}@endif" placeholder="" required>
                            <div class="invalid-feedback">
                            Ingrese su direccion de facturación.
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sameaddress" id="sameaddress">
                            <label class="custom-control-label distancia" for="sameaddress">Dirección de Facturación es la misma de la de envio</label>
                        </div>
                        <hr class="mb-4">
                        <div class="mb-3" id="delivery_a">
                            <label for="address2">Dirección del lugar donde recibirá envio</label>
                            <input type="text" class="form-control" name="delivery_address" id="delivery_address" placeholder="">
                            <hr class="mb-4">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="country">País</label>
                                <select class="custom-select d-block w-100 @if ($errors-> has('country'))  is-invalid @endif" name="country" id="country" required>
                                    <option value="">Escojer...</option>
                                    <option value="colombia" @if (!empty($completeRequest->country)) @if (($completeRequest->country) == 'colombia') selected @endif @endif>Colombia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un país valido.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">Departamento</label>
                                <select class="custom-select d-block w-100 @if ($errors-> has('dpt'))  is-invalid @endif" name="dpt" id="dpt" required>
                                    <option value="">Escojer...</option>
                                    <option value="atlantico"  @if (!empty($completeRequest->dpt)) @if (($completeRequest->dpt) == 'atlantico') selected @endif @endif>Atlántico</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un valido departamento.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="city">Ciudad</label>
                                <input type="text" class="form-control @if ($errors-> has('city'))  is-invalid @endif" name="city" id="city" value="@if(!empty($completeRequest->city)){{$completeRequest->city}}@endif" placeholder="" required>
                                <div class="invalid-feedback">
                                    Ciudad es requerida.
                                </div>
                            </div>
                        </div>
                
                <hr class="mb-4">
        
                <h4 class="mb-3">Metodo de Pago</h4>
        
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Nombre en la Tarjeta</label>
                        <input type="text" class="form-control @if ($errors-> has('cc_name'))  is-invalid @endif" name="cc_name" id="cc_name" value="@if(!empty($completeRequest->cc_name)){{$completeRequest->cc_name}}@endif" placeholder="" required>
                        @if ($errors-> has('cc_name'))  
                            <div class="invalid-feedback">
                                Nombre es Obligatorio.
                            </div> 
                        @else
                            <small class="text-muted">Nombre tal cual aparece desplegado en la tarjeta</small>
                        @endif 
                    
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="cc-number">Numero Tarjeta de Credito</label>
                    <input type="text" class="form-control @if ($errors-> has('cc_number'))  is-invalid @endif" name="cc_number" id="cc_number" value="@if(!empty($completeRequest->cc_number)){{$completeRequest->cc_number}}@endif" placeholder="" required>
                    <div class="invalid-feedback">
                        Numero de Tarjeta es requerida.
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                    <label for="cc-expiration">Vence</label>
                    <input type="text" class="form-control @if ($errors-> has('cc_expiration'))  is-invalid @endif" name="cc_expiration" id="cc_expiration" value="@if(!empty($completeRequest->cc_expiration)){{$completeRequest->cc_expiration}}@endif" placeholder="Ej: 01/22" required>
                    <div class="invalid-feedback">
                        Fecha es requerida.
                    </div>
                    </div>
                    <div class="col-md-3 mb-3">
                    <label for="cc-cvv">CVV</label>
                    <input type="text" class="form-control @if ($errors-> has('cc_cvv'))  is-invalid @endif" name="cc_cvv" id="cc_cvv" value="@if(!empty($completeRequest->cc_cvv)){{$completeRequest->cc_cvv}}@endif" placeholder="Ej: 123" required>
                    <div class="invalid-feedback">
                       Codigo de segurida es solicitado.
                    </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continuar al pago</button>
                </form>
            </div>
        </div>
    @else

    @endif
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sameaddress').change(function(){
        if($(this).prop('checked')){
            $('#delivery_a').hide();
        }else{
            $('#delivery_a').show();
        }
  
  })
    });
</script>
@endsection