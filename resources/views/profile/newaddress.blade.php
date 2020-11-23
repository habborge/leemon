@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        
            <form class="needs-validation" action="/addresses" method="POST" name="formaut" id="formRegisterwithdrawal" novalidate>
                @csrf
                <div class="card">
                    <div class="card-header col-md-12">
                        <div class="">
                           Nueva dirección de envío
                        </div>
                    </div>
                
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 order-md-1">
                                @if ($errors->any()) 
                                    <div class="alert alert-danger" role="alert">
                                        Revise el formulario que contine errores!! <br> 
                                    </div>
                                @endif
                                <h4 class="mb-3">Ingrese Nueva dirección de entrega</h4>
                                <hr class="mb-4">
                                <div class="row mb-3">
                                        <div class="col-md-12">
                                            
                                                <label class="text-register" for="address">Dirección</label>
                                            
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
                                        <input type="text" class="form-control @if ($errors-> has('zipcode'))  is-invalid @endif" name="zipcode" id="zipcode" value="@if(!empty($completeRequest->zipcode)){{$completeRequest->zipcode}}@endif" placeholder="Ej: 080001" required>
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
                                    <div class="col-md-8 mb-3">
                                        <label class="text-register" for="contact">Nombre de contacto</label>
                                        <input type="text" class="form-control @if ($errors-> has('contact'))  is-invalid @endif" name="contact" id="contact" value="@if(!empty($completeRequest->contact)){{$completeRequest->contact}}@endif" placeholder="Ej: nombre de quien recibe" required>
                                        <div class="invalid-feedback">
                                            Ingrese el nombre de la persona que recibira el envío.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="text-register" for="phone">Teléfono</label>
                                        <input type="text" class="form-control @if ($errors-> has('phone'))  is-invalid @endif" name="phone" id="phone" value="@if(!empty($completeRequest->phone)){{$completeRequest->phone}}@endif" placeholder="Ej: 355 555 5555" required>
                                        <div class="invalid-feedback">
                                            Ingrese Un teléfono valido.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="sameaddress" id="sameaddress" @if (isset($checkbox)) checked @endif>
                                            <label class="custom-control-label distancia text-register" for="sameaddress">Establecer como dirección por defecto</label>
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
                    
                </div>
                <br>
                <div class="conatiner">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button class="btn btn-purchase btn-block" type="submit">Guardar Dirección</button>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </form>
        
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>
@endsection