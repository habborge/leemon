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
                
                    @if ($errors->any()) 
                        <div class="alert alert-danger" role="alert">
                            Revise el formulario que contine errores!! <br> 
                            @if ($errors->has('notice'))
                                {{ $errors->first('notice') }}
                            @endif
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 order-md-1">
                                <h4 class="mb-3">Información de Personal</h4>
                                <hr class="mb-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="firstname">Nombre</label>
                                        <input type="text" class="form-control @if ($errors-> has('firstname'))  is-invalid @endif" name="firstname" id="firstname" placeholder="Ej: Nombres" value="@if(!empty($completeRequest->firstname)){{$completeRequest->firstname}}@endif" required>
                                        <div class="invalid-feedback">
                                            El campo Nombre es requerido. 
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="lastname">Apellidos</label>
                                        <input type="text" class="form-control @if ($errors-> has('lastname'))  is-invalid @endif" name="lastname" id="lastname" placeholder="Ej: Apellidos" value="@if(!empty($completeRequest->lastname)){{$completeRequest->lastname}}@endif" required>
                                        <div class="invalid-feedback">
                                            El campo Apellidos es requerido.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="n_doc">Número ID</label>
                                        <input type="text" class="form-control @if ($errors-> has('n_doc'))  is-invalid @endif" name="n_doc" id="n_doc" placeholder="Ej: 4893848349" value="@if(!empty($completeRequest->n_doc)){{$completeRequest->n_doc}}@endif" required>
                                        <div class="invalid-feedback">
                                            El número de Indentificación es requerido.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                       
                                    </div>
                                </div>
                                
                                <hr>
                                <h4 class="mb-3">Información de Facturación</h4>
                                <hr class="mb-4">
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
                                    <div class="col-md-8 mb-3">
                                        <label class="text-register" for="address_d">Información adicional de la dirección</label>
                                        <input type="text" class="form-control" name="address_d" id="address_d" value="@if(!empty($completeRequest->address_d)){{$completeRequest->address_d}}@endif" placeholder="Ej: casa, Apto, Edificio" required>
                                        <div class="invalid-feedback">
                                            Ingrese información adicional de la dirección.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="text-register" for="zipcode">Zipcode</label>
                                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="@if(!empty($completeRequest->zipcode)){{$completeRequest->zipcode}}@endif" placeholder="Ej: 080001" required>
                                        <div class="invalid-feedback">
                                            Ingrese el Codigo Zip de su zona.
                                        </div>
                                    </div>
                                </div>
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
                                        <label class="text-register" for="dpt">Departamento</label>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="sameaddress" id="sameaddress" @if (isset($checkbox)) checked @endif>
                                            <label class="custom-control-label distancia text-register" for="sameaddress">Dirección de Facturación es la misma de la de envio</label>
                                        </div>
                                    </div>
                               </div>
                               
                               <div id="delivery_a" @if (isset($checkbox)) style="display: none" @endif>
                                    <hr>
                                    <h4 class="mb-3">Información de Envío</h4>
                                    <hr class="mb-4">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                        
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
                                    <div class="row mb-3">
                                        <div class="col-md-8" >
                                            <label class="text-register" for="address_db">Información adicional de la dirección de envío</label>
                                            <input type="text" class="form-control" name="address_db" id="address_db" placeholder="Ej: casa, Apto, Edificio">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="text-register" for="zipcode_e">Zipcode</label>
                                            <input type="text" class="form-control" name="zipcode_e" id="zipcode_e" value="" placeholder="Ej: 080001" required>
                                            <div class="invalid-feedback">
                                                Ingrese el Codigo postal de su zona de envío.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-5 mb-3">
                                                    <label class="text-register" for="country_e">País</label>
                                                    <select class="custom-select d-block w-100 @if ($errors-> has('country_e'))  is-invalid @endif" name="country_e" id="country_e" required>
                                                        <option value="">Escojer...</option>
                                                        <option value="colombia" @if (!empty($completeRequest->country_e)) @if (($completeRequest->country_e) == 'colombia') selected @endif @endif>Colombia</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione un país valido.
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="text-register" for="dpt_e">Departamento</label>
                                                    <select class="custom-select d-block w-100 @if ($errors-> has('dpt_e'))  is-invalid @endif" name="dpt_e" id="dpt_e" required>
                                                        <option value="">Escojer...</option>
                                                        <option value="atlantico"  @if (!empty($completeRequest->dpt_e)) @if (($completeRequest->dpt_e) == 'atlantico') selected @endif @endif>Atlántico</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione un valido departamento.
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="text-register" for="city_e">Ciudad</label>
                                                    <input type="text" class="form-control @if ($errors-> has('city_e'))  is-invalid @endif" name="city_e" id="city_e" value="@if(!empty($completeRequest->city_e)){{$completeRequest->city_e}}@endif" placeholder="" required>
                                                    <div class="invalid-feedback">
                                                        Ciudad es requerida.
                                                    </div>
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
                                        <input type="text" class="form-control @if ($errors-> has('cc_name'))  is-invalid @endif" name="cc_name" id="cc_name" value="@if(!empty($completeRequest->cc_name)){{$completeRequest->cc_name}}@endif" placeholder="Ej: Nombre Apellido" required>
                                        @if ($errors-> has('cc_name'))  
                                            <div class="invalid-feedback">
                                                Nombre es Obligatorio.
                                            </div> 
                                        @else
                                            <small class="text-muted">Nombre tal cual aparece desplegado en la tarjeta</small>
                                        @endif 
                                    
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-register" for="cc-number">Número Tarjeta de Credito</label>
                                        <input type="text" class="form-control @if ($errors-> has('cc_number'))  is-invalid @elseif ($errors-> has('notice')) is-invalid @endif" name="cc_number" id="cc_number" value="@if(!empty($completeRequest->cc_number)){{$completeRequest->cc_number}}@endif" placeholder="Ej: 123456789212" required>
                                        <div class="invalid-feedback">
                                            @if ($errors-> has('cc_number')) Número de Tarjeta es requerida. @endif
                                            @if ($errors-> has('notice')) Número de Tarjeta es Invalido. @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="text-register" for="cc-expiration">Vence</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6" style="padding-right: 20px;">
                                                    <div class="row">
                                                        <select name="cc_expiration_m" id="cc_expiration_m" class="form-control @if (!isset($checkbox)) @if ($errors->has('cc_expiration_m'))  is-invalid @endif @endif">
                                                            @if(!empty($completeRequest->cc_expiration_m))
                                                                    <option value="{{ $completeRequest->cc_expiration_m }}">{{$completeRequest->cc_expiration_m}}</option>
                                                                @endif
                                                            <option value="">MM</option>
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>
                                                            <option value="07">07</option>
                                                            <option value="08">08</option>
                                                            <option value="09">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <select name="cc_expiration_y" id="cc_expiration_y" class="form-control @if (!isset($checkbox)) @if ($errors->has('cc_expiration_y'))  is-invalid @endif @endif">
                                                            @if(!empty($completeRequest->cc_expiration_y))
                                                                    <option value="{{ $completeRequest->cc_expiration_y }}">{{$completeRequest->cc_expiration_y}}</option>
                                                                @endif
                                                            <option value="" class="select-holder">YYYY</option>
                                                            <option value="21">2021</option>
                                                            <option value="22">2022</option>
                                                            <option value="23">2023</option>
                                                            <option value="24">2024</option>
                                                            <option value="25">2025</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            Fecha es requerida.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <label class="text-register" for="cc-cvv">CVV</label>
                                                <input type="text" class="form-control @if ($errors-> has('cc_cvv'))  is-invalid @endif" name="cc_cvv" id="cc_cvv" value="@if(!empty($completeRequest->cc_cvv)){{$completeRequest->cc_cvv}}@endif" placeholder="Ej: 123" maxlength="4" required>
                                                <div class="invalid-feedback">
                                                    Codigo de segurida es solicitado.
                                                </div>
                                            </div>
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