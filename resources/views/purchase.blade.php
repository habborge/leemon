@extends('layouts.app')
@section('custom-css')
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/select2.min.css">
    
@endsection
@section('content')
<div class="tabs">
    <div class="container">
        @if ($infosaved == 0)
            <form class="needs-validation" action="{{ route('saveinfo') }}" method="POST" name="formaut" id="formRegisterwithdrawal" novalidate>
                @csrf
                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                <div class="card card-rounded">
                    <div class="card-header col-md-12  card-round-header">
                        <div class="">
                            Dirección de Envío
                        </div>
                    </div>
                    
                    <div class="card-body card-body-yellow card-round-footer">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($errors->any()) 
                                    <div class="alert alert-warnig" role="alert">
                                        Revise el formulario que contine errores!! <br> 
                                        @if ($errors->has('notice'))
                                            {{ $errors->first('notice') }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-8 order-md-1">
                                
                                <div class="col-md-12">
                                    <div class="row mb-5">
                                        <h2>Dirección de Envío</h2>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="text-register " for="country">País</label>
                                        <select class="custom-select d-block w-100 @if ($errors-> has('country'))  is-invalid @endif js-example-basic-single" name="country" id="country" required>
                                            <option value="47" @if (!empty($completeRequest->country)) @if (($completeRequest->country) == '57') selected @endif @endif>Colombia</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione un país valido.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div id="loading_web2">
                                            <img src="/img/preloader.gif" id="img_loading" alt="">
                                        </div>
                                        <label class="text-register" for="dpt">Departamento</label>
                                        <select class="custom-select d-block w-100 @if ($errors-> has('dpt'))  is-invalid @endif js-example-basic-single" name="dpt" id="dpt" required>
                                            <option class="color" value=""><span class="">Seleccione el Departamento</span></option>
                                                @foreach ($dpts as $dpto)
                                                    <option value="{{ $dpto->code }}">{{ $dpto->department }}</option>
                                                @endforeach
                                            {{-- <option value="atlantico"  @if (!empty($completeRequest->dpt)) @if (($completeRequest->dpt) == 'atlantico') selected @endif @endif>Atlántico</option> --}}
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione un valido departamento.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="text-register" for="city">Ciudad</label>
                                        {{-- <input type="text" class="form-control @if ($errors-> has('city'))  is-invalid @endif" name="city" id="city" value="@if(!empty($completeRequest->city)){{$completeRequest->city}}@endif" placeholder="" required> --}}
                                        <select class="custom-select d-block w-100 @if ($errors-> has('city'))  is-invalid @endif js-example-basic-single" name="city" id="city" disabled required>
                                            
                                            {{-- <option value="atlantico"  @if (!empty($completeRequest->dpt)) @if (($completeRequest->dpt) == 'atlantico') selected @endif @endif>Atlántico</option> --}}
                                        </select>
                                        <div class="invalid-feedback">
                                            Ciudad es requerida.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="text-register" for="birthday">Fecha de Nacimiento</label>
                                        <input type="text" class="form-control bg-white @if ($errors-> has('birthday'))  is-invalid @endif" name="birthday" id="birthday" placeholder="Click para escojer fecha" value="@if(!empty($completeRequest->birthday)){{$completeRequest->birthday}}@endif" readonly>
                                        <div class="invalid-feedback">
                                            La fecha de nacimiento es requerida.
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="text-register" for="n_doc">Número Cedula</label>
                                        <input type="text" class="form-control @if ($errors-> has('n_doc'))  is-invalid @endif" name="n_doc" id="n_doc" placeholder="Ej: 4893848349" value="@if(!empty($completeRequest->n_doc)){{$completeRequest->n_doc}}@endif" required>
                                        <div class="invalid-feedback">
                                            El número de Indentificación es requerido.
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="text-register" for="phone">Teléfono</label>
                                        <input type="text" class="form-control @if ($errors-> has('phone'))  is-invalid @endif" name="phone" id="phone" placeholder="Ej: 4893848349" value="@if(!empty($completeRequest->phone)){{$completeRequest->phone}}@endif" required>
                                        <div class="invalid-feedback">
                                            El número de Teléfono es requerido.
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <label for="">Ej: Calle 12A sur # 12 -34</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    
                                        <div class="col-md-3">
                                            <select name="address_1" id="address_1" class="form-control @if ($errors->has('address_1'))  is-invalid @endif">
                                                @if(!empty($completeRequest->address_1))
                                            <option value="{{ $completeRequest->address_1 }}">{{$completeRequest->address_1}}</option>
                                                @endif
                                                <option class="one" value="">Ej: Calle</option>
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
                                        <div class="col-md-2">
                                            
                                                <input type="text" class="form-control @if ($errors-> has('address_2'))  is-invalid @endif" name="address_2" id="address_2" value="@if(!empty($completeRequest->address_2)){{$completeRequest->address_2}}@endif" placeholder="ej: 12A sur" required>
                                                <div class="invalid-feedback">
                                                    Ingrese su dirección de Envío.
                                                </div>
                                            
                                        </div>
                                        
                                        <div class="col-md-3">
                                            
                                            <select name="address_3" id="address_3" class="form-control @if ($errors->has('address_3'))  is-invalid @endif">
                                                @if(!empty($completeRequest->address_3))
                                                    <option value="{{ $completeRequest->address_3 }}">{{$completeRequest->address_3}}</option>
                                                @endif
                                                    <option value="">Ej: #</option>
                                                <option value="no">#</option>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                        
                                                        <div class="row">
                                                            <input type="text" class="form-control @if ($errors-> has('address_4'))  is-invalid @endif" name="address_4" id="address_4" value="@if(!empty($completeRequest->address_4)){{$completeRequest->address_4}}@endif" placeholder="ej: 12" required>
                                                        <div class="invalid-feedback">
                                                            Ingrese su dirección de Envío.
                                                        </div>
                                                        </div>
                                                    
                                                </div >
                                                <div class="col-md-1">
                                                    -
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                    <input type="text" class="form-control @if ($errors-> has('address_5'))  is-invalid @endif" name="address_5" id="address_5" value="@if(!empty($completeRequest->address_5)){{$completeRequest->address_5}}@endif" placeholder="ej: 34" required>
                                                    <div class="invalid-feedback">
                                                        Ingrese su dirección de Envío.
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                    <div class="col-md-12 mb-3 mt-2">
                                        
                                        <input type="text" class="form-control" name="address_d" id="address_d" value="@if(!empty($completeRequest->address_d)){{$completeRequest->address_d}}@endif" placeholder="Ej: casa 1, Apto 101, Edificio ..." required>
                                        <div class="invalid-feedback">
                                            Ingrese información de dirección.
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-register" for="obs">Observaciónes</label>
                                        <input type="text" class="form-control" name="obs" id="obs" value="@if(!empty($completeRequest->obs)){{$completeRequest->obs}}@endif" placeholder="Ej: No hay porteria, por favor llamar a celular" required>
                                        <div class="invalid-feedback">
                                            Ingrese información adicional de la dirección.
                                        </div>
                                    </div>
                                    
                                </div>
                                {{-- <div class="row">
                                    
                                    <div class="col-md-4 mb-3">
                                        <label class="text-register" for="zipcode">Zipcode (Opcional)</label>
                                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="@if(!empty($completeRequest->zipcode)){{$completeRequest->zipcode}}@endif" placeholder="Ej: 080001">
                                        <div class="invalid-feedback">
                                            Ingrese el Codigo Zip de su zona.
                                        </div>
                                    </div>
                                </div> --}}
                                
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="sameaddress" id="sameaddress" @if (isset($checkbox)) checked @endif>
                                            <label class="custom-control-label distancia text-register" for="sameaddress">Dirección de Envío es la misma de la de Envío</label>
                                        </div>
                                    </div>
                               </div> --}}
                               <div class="row">
                                <div class="col-md-12 mt-3">
                                    <div class="alert alert-warning" role="alert">
                                        <p class="mb-0">
                                            <b>* No olvides siempre verificar que la dirección suministrada sea la correcta.</b><br>
                                            {{-- Si has suministrado mal la información de tu dirección, posiblemente tu articulo no podra ser entregado. --}}
                                        </p> 
                                    </div>
                               </div>
                                
                            </div>
                               
                                {{-- <div id="delivery_a" @if (isset($checkbox)) style="display: none" @endif>
                                    
                                    <hr class="mb-4">
                                    <div class="row mb-3">
                                        
                                        <div class="col-md-12">
                                            <label class="text-register" for="contact">Nombre completo</label>
                                            <input type="text" class="form-control @if ($errors-> has('contact'))  is-invalid @endif" name="contact" id="contact" placeholder="Ej: Nombre del destinatario" value="@if(!empty($completeRequest->contact)){{$completeRequest->contact}}@endif" required>
                                            <div class="invalid-feedback">
                                                El campo Nombre es requerido. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        
                                        <div class="col-md-12">
                                            <label class="text-register" for="address">Dirección del lugar donde recibirá Envío</label>
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
                                        
                                            <input type="text" class="form-control @if (!isset($checkbox)) @if ($errors-> has('address_2b'))  is-invalid @endif  @endif" name="address_2b" id="address_2b" placeholder="ej: 12A sur" value="@if(!empty($completeRequest->address_2b)){{$completeRequest->address_2b}}@endif" required>
                                           
                                            <div class="invalid-feedback">
                                                Ingrese su dirección de Envío.
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
                                            
                                                <input type="text" class="form-control @if ($errors-> has('address_4b'))  is-invalid @endif" name="address_4b" id="address_4b" value="@if(!empty($completeRequest->address_4b)){{$completeRequest->address_4b}}@endif" placeholder="ej: 12 - 34" required>
                                                <div class="invalid-feedback">
                                                    Ingrese su dirección de Envío.
                                                </div>
                                            
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="alert alert-warning" role="alert">
                                                <p class="mb-0">
                                                    <b>* No olvides siempre verificar que la dirección suministrada sea la correcta.</b><br>
                                                     Si has suministrado mal la información de tu dirección, posiblemente tu articulo no podra ser entregado. 
                                                </p> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-8" >
                                            <label class="text-register" for="address_db">Información adicional de la dirección de envío</label>
                                            <input type="text" class="form-control" name="address_db" id="address_db" placeholder="Ej: casa, Apto, Edificio">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-register" for="zipcode_e">Zipcode (Opcional)</label>
                                            <input type="text" class="form-control" name="zipcode_e" id="zipcode_e" value="" placeholder="Ej: 080001" required>
                                            <div class="invalid-feedback">
                                                Ingrese el Codigo postal de su zona de envío.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        
                                                <div class="col-md-5">
                                                    <label class="text-register" for="country_e">País</label>
                                                    <select class="custom-select d-block w-100 @if ($errors-> has('country_e'))  is-invalid @endif" name="country_e" id="country_e" required>
                                                        <option value="">Escojer...</option>
                                                        <option value="47" @if (!empty($completeRequest->country_e)) @if (($completeRequest->country_e) == 'colombia') selected @endif @endif>Colombia</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione un país valido.
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="loading_web3">
                                                        <img src="/img/preloader.gif" id="img_loading" alt="">
                                                    </div>
                                                    <label class="text-register" for="dpt_e">Departamento</label>
                                                    <select class="custom-select d-block w-100 @if ($errors-> has('dpt_e'))  is-invalid @endif" name="dpt_e" id="dpt_e" disabled required>
                                                        <option value="">Escojer...</option>
                                                        <option value="atlantico"  @if (!empty($completeRequest->dpt_e)) @if (($completeRequest->dpt_e) == 'atlantico') selected @endif @endif>Atlántico</option> 
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Seleccione un valido departamento.
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-register" for="city_e">Ciudad</label>
                                                    <input type="text" class="form-control @if ($errors-> has('city_e'))  is-invalid @endif" name="city_e" id="city_e" value="@if(!empty($completeRequest->city_e)){{$completeRequest->city_e}}@endif" placeholder="" required> 
                                                    <select class="custom-select d-block w-100 @if ($errors-> has('city_e'))  is-invalid @endif" name="city_e" id="city_e" disabled required>
                                                        <option value="">Escojer...</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Ciudad es requerida.
                                                    </div>
                                                </div>
                                                
                                            
                                        
                                    </div>
                                    
                                </div> --}}
                                <hr class="mb-4">
                                <div class="conatiner">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <button class="btn btn-purchase btn-block" type="submit">Guardar Información y Continuar con el pago</button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else

        @endif
    </div>
</div>
@endsection
@section('custom-js')
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RE_KEY') }}"></script>
<script>
    grecaptcha.ready(function() {
    grecaptcha.execute('{{ env('RE_KEY') }}')    .then(function(token) {
    document.getElementById("recaptcha_token").value = token;
    }); });
</script>
<script src="/js/jquery-ui.min.js" defer></script>
<script src="/js/select2.min.js" defer></script>
<script type="text/javascript">
    
    $(document).ready(function(){
        
        
        $('#firstname').on('input', function () { 
            this.value = this.value.replace(/[^ a-záéíóúüñA-Z]/g,'');
        });
        $('#lastname').on('input', function () { 
            this.value = this.value.replace(/[^ a-záéíóúüñA-Z]/g,'');
        });

        $('#contact').on('input', function () { 
            this.value = this.value.replace(/[^ a-záéíóúüñA-Z]/g,'');
        });
        $('#phone').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });

        $('#zipcode').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });

        $('#n_doc').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });

        $('#zipcode_e').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });
        $('#sameaddress').change(function(){
            if($(this).prop('checked')){
                $('#delivery_a').hide();
            }else{
                $('#delivery_a').show();
            }
        });

        $('#country').change(function(){
            var countryId = $(this).val();
            bringDpts(countryId, "#dpt", 2);
            
        });

        // $('#country_e').change(function(){
        //     var countryId = $(this).val();
        //     bringDpts(countryId, "#dpt_e", 3);
        // });

        $('#dpt').change(function(){
            var dptId = $(this).val();
            bringCities(dptId, "#city", 2);
        });

        $('#dpt_e').change(function(){
            var dptId = $(this).val();
            bringCities(dptId, "#city_e", 3);
        });

        $('.js-example-basic-single').select2({
            theme: "classic",
            placeholder: "Selecciona una opción",
        });
        
    });

    // function bringDpts(id, se, loading){
        
    //     var countryId = id;
            
    //         $.ajax({
    //             type:'POST',   
    //             dataType:'json',      
    //             url:'/region/dpt',
    //             data: {'id':countryId},
    //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //             beforeSend: function(x){
    //                 $('#loading_web'+loading).show();
    //             },
    //             success:function(data){
    //                 if(data.status==200){
    //                     $('#loading_web'+loading).hide(); 

    //                     var dptsList = '<option value="">Seleccione el Departamento</option>'
    //                     for (var i=0; i<data.dpts.length;i++){
    //                         dptsList +='<option value="'+data.dpts[i].code+'">'+data.dpts[i].department+'</option>';
    //                     }
    //                     $(se).removeAttr('disabled');    
    //                     $(se).html(dptsList);
                        
    //                 }else if(data.status==403){
    //                     $('#loading_web' + loading).hide(); 
    //                     $.each(data.errors, function( index, value ) {         
    //                         toastr.error(value, 'Error!', {  timeOut: 5e3});
    //                     });  
    //                 }else{ 
    //                     $('#loading_web' + loading).hide(); 
    //                     toastr.error(data.message, "Error!");      
    //                 }  
    //             }
    //         });
    // }

    function bringCities(id, se, loading){
        
        var dptId = id;
            
            $.ajax({
                type:'POST',   
                dataType:'json',      
                url:'/region/city',
                data: {'id':dptId},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function(x){
                    $('#loading_web'+loading).show();
                },
                success:function(data){
                    if(data.status==200){
                        $('#loading_web'+loading).hide(); 

                        var cityList = '<option value="">Seleccione Ciudad o Municipio</option>'
                        for (var i=0; i<data.city.length;i++){
                            cityList +='<option value="'+data.city[i].id+'">'+data.city[i].city_d_id+'</option>';
                        }

                        $(se).removeAttr('disabled');      
                        $(se).html(cityList);
                         
                    }else if(data.status==403){
                        $('#loading_web' + loading).hide(); 
                        $.each(data.errors, function( index, value ) {         
                            toastr.error(value, 'Error!', {  timeOut: 5e3});
                        });  
                    }else{ 
                        $('#loading_web' + loading).hide(); 
                        toastr.error(data.message, "Error!");      
                    }  
                }
            });
    }
    
</script>
@endsection