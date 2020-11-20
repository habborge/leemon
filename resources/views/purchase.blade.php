@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        @if ($infosaved == 0)
            <form class="needs-validation" action="{{ route('saveinfo') }}" method="POST" name="formaut" id="formRegisterwithdrawal" novalidate>
                @csrf
                <div class="card">
                    <div class="card-header col-md-12">
                        <div class="">
                            Formulario de Pago
                        </div>
                    </div>
                
                    {{-- @if ($errors) {{ $errors }} @endif --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 order-md-1">
                                <h4 class="mb-3">Información de Facturación</h4>
                                <hr class="mb-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="firstname">Nombre</label>
                                        <input type="text" class="form-control @if ($errors-> has('firstname'))  is-invalid @endif" name="firstname" id="firstname" placeholder="" value="@if(!empty($completeRequest->firstname)){{$completeRequest->firstname}}@endif" required>
                                        <div class="invalid-feedback">
                                            El campo Nombre es requerido. 
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="lastname">Apellidos</label>
                                        <input type="text" class="form-control @if ($errors-> has('lastname'))  is-invalid @endif" name="lastname" id="lastname" placeholder="" value="@if(!empty($completeRequest->lastname)){{$completeRequest->lastname}}@endif" required>
                                        <div class="invalid-feedback">
                                            El campo Apellidos es requerido.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="firstName">Número ID</label>
                                        <input type="text" class="form-control @if ($errors-> has('n_doc'))  is-invalid @endif" name="n_doc" id="n_doc" placeholder="" value="@if(!empty($completeRequest->n_doc)){{$completeRequest->n_doc}}@endif" required>
                                        <div class="invalid-feedback">
                                            El número de Indentificación es requerido.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="email">Email</label>
                                        <input type="email" class="form-control @if ($errors-> has('email'))  is-invalid @endif" name="email" id="email" value="@if(!empty($completeRequest->email)){{$completeRequest->email}}@endif" placeholder="">
                                        <div class="invalid-feedback">
                                            Ingrese un email valido para las actualizaciones de entrega.
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="row mb-3">
                                        <div class="col-md-12">
                                            
                                                <label class="text-register" for="address">Dirección de Facturación</label>
                                            
                                        </div>
                                        <div class="col-md-2">
                                            
                                                <select name="address_1" id="address_1" class="form-control @if ($errors->has('address_1'))  is-invalid @endif">
                                                    @if(!empty($completeRequest->address_1))
                                                <option value="{{ $completeRequest->address_1 }}">{{$completeRequest->address_1}}</option>
                                                    @endif
                                                    <option value="">Escoja...</option>
                                                    <option value="Clle">Calle</option>
                                                    <option value="Kr">Carrera</option>
                                                    <option value="Dg">Diagonal</option>
                                                    <option value="Tr">Transversal</option>
                                                    <option value="Av">Avenida</option>
                                                    <option value="Mz">Manzana</option>
                                                    <option value="Lt">Lote</option>
                                                    <option value="Cs">Casa</option>
                                                </select>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            
                                                <input type="text" class="form-control @if ($errors-> has('address_2'))  is-invalid @endif" name="address_2" id="address_2" value="@if(!empty($completeRequest->address_2)){{$completeRequest->address_2}}@endif" placeholder="" required>
                                                <div class="invalid-feedback">
                                                    Ingrese su dirección de facturación.
                                                </div>
                                            
                                        </div>
                                        <div class="col-md-2">
                                            
                                            <select name="address_3" id="address_3" class="form-control @if ($errors->has('address_3'))  is-invalid @endif">
                                                @if(!empty($completeRequest->address_3))
                                                    <option value="{{ $completeRequest->address_3 }}">{{$completeRequest->address_3}}</option>
                                                @endif
                                                    <option value="">Escoja...</option>
                                                <option value="no">No</option>
                                                <option value="Clle">Calle</option>
                                                <option value="Kr">Carrera</option>
                                                <option value="Dg">Diagonal</option>
                                                <option value="Tr">Transversal</option>
                                                <option value="Av">Avenida</option>
                                                <option value="Mz">Manzana</option>
                                                <option value="Lt">Lote</option>
                                                <option value="Cs">Casa</option>
                                            </select>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        
                                            <input type="text" class="form-control @if ($errors-> has('address_4'))  is-invalid @endif" name="address_4" id="address_4" value="@if(!empty($completeRequest->address_4)){{$completeRequest->address_4}}@endif" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Ingrese su dirección de facturación.
                                            </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-register" for="address_d">Información adicional de la dirección</label>
                                        <input type="text" class="form-control" name="address_d" id="address_d" value="" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Ingrese información adicional de la dirección
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="sameaddress" id="sameaddress" @if (isset($checkbox)) checked @endif>
                                            <label class="custom-control-label distancia text-register" for="sameaddress">Dirección de Facturación es la misma de la de envio</label>
                                        </div>
                                    </div>
                               </div>
                               <div id="delivery_a" @if (isset($checkbox)) style="display: none" @endif>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <hr>
                                        <label class="text-register" for="address">Dirección del lugar donde recibirá envio</label>
                                    
                                    </div>
                                    <div class="col-md-2">
                                        
                                            <select name="address_1b" id="address_1b" class="form-control @if (!isset($checkbox)) @if ($errors->has('address_3'))  is-invalid @endif @endif">
                                                @if(!empty($completeRequest->address_1b))
                                                    <option value="{{ $completeRequest->address_1b }}">{{$completeRequest->address_1b}}</option>
                                                @endif
                                                <option value="">Escoja...</option>
                                                <option value="Clle">Calle</option>
                                                <option value="Kr">Carrera</option>
                                                <option value="Dg">Diagonal</option>
                                                <option value="Tr">Transversal</option>
                                                <option value="Av">Avenida</option>
                                                <option value="Mz">Manzana</option>
                                                <option value="Lt">Lote</option>
                                                <option value="Cs">Casa</option>
                                            </select>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        
                                            <input type="text" class="form-control @if (!isset($checkbox)) @if ($errors-> has('address_2b'))  is-invalid @endif  @endif" name="address_2b" id="address_2b" value="@if (!isset($checkbox)) @if(!empty($completeRequest->address_2b)){{$completeRequest->address_2b}}@endif @endif" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Ingrese su dirección de facturación.
                                            </div>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        
                                        <select name="address_3b" id="address_3b" class="form-control @if (!isset($checkbox)) @if ($errors->has('address_3b'))  is-invalid @endif @endif">
                                            @if(!empty($completeRequest->address_3b))
                                                    <option value="{{ $completeRequest->address_3b }}">{{$completeRequest->address_3b}}</option>
                                                @endif
                                            <option value="">Escoja...</option>
                                            <option value="Clle">No</option>
                                            <option value="Clle">Calle</option>
                                            <option value="Kr">Carrera</option>
                                            <option value="Dg">Diagonal</option>
                                            <option value="Tr">Transversal</option>
                                            <option value="Av">Avenida</option>
                                            <option value="Mz">Manzana</option>
                                            <option value="Lt">Lote</option>
                                            <option value="Cs">Casa</option>
                                        </select>
                                    
                                    </div>
                                    <div class="col-md-4">
                                        
                                            <input type="text" class="form-control @if ($errors-> has('address_4b'))  is-invalid @endif" name="address_4b" id="address_4b" value="@if(!empty($completeRequest->address_4b)){{$completeRequest->address_4b}}@endif" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Ingrese su dirección de facturación.
                                            </div>
                                        
                                    </div>
                                </div>
                               <div class="row">
                                    <div class="col-md-12" >
                                        <label class="text-register" for="address_db">Información adicional de la dirección de envio</label>
                                        <input type="text" class="form-control" name="delivery_address" id="delivery_address" placeholder="">
                                    </div>
                                </div>
                               </div>
                               <div class="row">
                                    <div class="col-md-12">
                                        <hr class="mb-4">
                                        <div class="row">
                                            <div class="col-md-5 mb-3">
                                                <label class="text-register" for="country">País</label>
                                                <select class="custom-select d-block w-100 @if ($errors-> has('country'))  is-invalid @endif" name="country" id="country" required>
                                                    <option value="">Escojer...</option>
                                                    <option value="colombia" @if (!empty($completeRequest->country)) @if (($completeRequest->country) == 'colombia') selected @endif @endif>Colombia</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Seleccione un país valido.
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-register" for="state">Departamento</label>
                                                <select class="custom-select d-block w-100 @if ($errors-> has('dpt'))  is-invalid @endif" name="dpt" id="dpt" required>
                                                    <option value="">Escojer...</option>
                                                    <option value="atlantico"  @if (!empty($completeRequest->dpt)) @if (($completeRequest->dpt) == 'atlantico') selected @endif @endif>Atlántico</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Seleccione un valido departamento.
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-register" for="city">Ciudad</label>
                                                <input type="text" class="form-control @if ($errors-> has('city'))  is-invalid @endif" name="city" id="city" value="@if(!empty($completeRequest->city)){{$completeRequest->city}}@endif" placeholder="" required>
                                                <div class="invalid-feedback">
                                                    Ciudad es requerida.
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <hr class="mb-4">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    
                
                    {{-- @if ($errors) {{ $errors }} @endif --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 order-md-1">
                                <h4 class="mb-3">Metodo de Pago</h4>
                                <hr class="mb-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        
                                        <label class="text-register" for="cc-name">Nombre en la Tarjeta</label>
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
                                        <label class="text-register" for="cc-number">Numero Tarjeta de Credito</label>
                                        <input type="text" class="form-control @if ($errors-> has('cc_number'))  is-invalid @endif" name="cc_number" id="cc_number" value="@if(!empty($completeRequest->cc_number)){{$completeRequest->cc_number}}@endif" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Numero de Tarjeta es requerida.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="text-register" for="cc-expiration">Vence</label>
                                        <input type="text" class="form-control @if ($errors-> has('cc_expiration'))  is-invalid @endif" name="cc_expiration" id="cc_expiration" value="@if(!empty($completeRequest->cc_expiration)){{$completeRequest->cc_expiration}}@endif" placeholder="Ej: 01/22" required>
                                        <div class="invalid-feedback">
                                            Fecha es requerida.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="text-register" for="cc-cvv">CVV</label>
                                        <input type="text" class="form-control @if ($errors-> has('cc_cvv'))  is-invalid @endif" name="cc_cvv" id="cc_cvv" value="@if(!empty($completeRequest->cc_cvv)){{$completeRequest->cc_cvv}}@endif" placeholder="Ej: 123" required>
                                        <div class="invalid-feedback">
                                            Codigo de segurida es solicitado.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <span id="nameCard"></span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4">
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
                <br>
                <div class="conatiner">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button class="btn btn-purchase btn-block" type="submit">Guardar Información y Continuar con el pago</button>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </form>
        @else

        @endif
    </div>
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
        });

        $('#cc_number').bind('keyup input', function(){
            var cant = $(this).val().length;

            
            if(cant >= 4){

                if($(this).val().match(/^(?:4[0-9]{12}(?:[0-9]{3})?)$/)){
                    $('#nameCard').text('Visa');
                }else if($(this).val().match(/^(?:5[1-5][0-9]{14})$/)){
                    $('#nameCard').text('MasterCard'); 
                }else if($(this).val().match(/^(?:3[47][0-9]{13})$/)){
                    $('#nameCard').text('American Express'); 
                }else if($(this).val().match(/^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/)){
                    $('#nameCard').text('Discover');
                }
                
            }
        });
    });
</script>
@endsection