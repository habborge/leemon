@extends('layouts.app')
@section('custom-css')
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/select2.min.css">
    <style>
        select:required:invalid {
            color: rgb(199, 199, 199);
        }
        option[value=""][disabled] {
            display: none;
        }
        option {
            color: black;
        }
    </style>
@endsection
@section('content')
<div class="tabs">
    <div class="container">
        @if ($infosaved == 0)
        <div class="row justify-content-center">
            <div class="md-stepper-horizontal orange">
                {{-- <div class="md-step active done"> --}}
                {{-- <div class="md-step active editable"> --}}
                <div class="md-step active done">
                  <div class="md-step-circle step-confirm"><span>1</span></div>
                  <div class="md-step-title">Registro</div>
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step active done">
                  <div class="md-step-circle step-confirm"><span>2</span></div>
                  <div class="md-step-title">Verificación</div>
                  {{-- <div class="md-step-optional">Optional</div> --}}
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step active">
                  <div class="md-step-circle"><span>3</span></div>
                  <div class="md-step-title">Datos de Envío</div>
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step">
                  <div class="md-step-circle"><span>4</span></div>
                  <div class="md-step-title">Pago</div>
                  <div class="md-step-bar-left"></div>
                  <div class="md-step-bar-right"></div>
                </div>
              </div>
        </div>
            <form class="needs-validation" action="{{ route('saveinfo') }}" method="POST" name="formaut" id="formRegisterwithdrawal">
                @csrf
                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                <div class="card card-rounded">
                    <div class="card-header col-md-12 body-cart card-round-header">
                        <div class="">
                            <h4>Dirección de Envío</h4>
                        </div>
                    </div>
                    
                    <div class="card-body card-body-yellow card-round-footer">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                @if ($errors->any()) 
                                    <div class="alert alert-danger" role="alert">
                                        Revise el formulario que contine errores o campos obligatorios que estan vacios!! <br> 
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-8 order-md-1">
                                
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
                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="text-register " for="">Dirección<br>(Ej: Calle 12A sur # 12 -34)</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    
                                        <div class="col-12 col-md-3 mb-2">
                                            <select name="address_1" id="address_1" class="form-control @if ($errors->has('address_1'))  is-invalid @endif" required>
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
                                        <div class="col-12 col-md-2 mb-2">
                                            
                                                <input type="text" class="form-control @if ($errors-> has('address_2'))  is-invalid @endif" name="address_2" id="address_2" value="@if(!empty($completeRequest->address_2)){{$completeRequest->address_2}}@endif" placeholder="ej: 12A sur" required>
                                                
                                            
                                        </div>
                                        
                                        <div class="col-12 col-md-2 mb-2">
                                            
                                            <select name="address_3" id="address_3" class="form-control @if ($errors->has('address_3'))  is-invalid @endif" required>
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
                                       
                                        <div class="col-5 col-md-2 mb-2">
                            
                                            <div class="">
                                                <input type="text" class="form-control @if ($errors-> has('address_4'))  is-invalid @endif" name="address_4" id="address_4" value="@if(!empty($completeRequest->address_4)){{$completeRequest->address_4}}@endif" placeholder="ej: 12" required>
                                                
                                            </div>
                                        </div >
                                        <div class="col-2 col-md-1 mb-2">
                                            <div class="row justify-content-center align-items-center">
                                               <b> -</b>
                                            </div>
                                            
                                        </div>
                                        <div class="col-5 col-md-2 mb-2">
                                            <div class="">
                                                <input type="text" class="form-control @if ($errors-> has('address_5'))  is-invalid @endif" name="address_5" id="address_5" value="@if(!empty($completeRequest->address_5)){{$completeRequest->address_5}}@endif" placeholder="ej: 34">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="invalid-feedback">
                                                Ingrese su dirección de Envío.
                                            </div>      
                                        </div>     
                                        <div class="col-md-12 mb-3 mt-2">
                                            
                                            <input type="text" class="form-control" name="address_d" id="address_d" value="@if(!empty($completeRequest->address_d)){{$completeRequest->address_d}}@endif" placeholder="Ej: casa 1, Apto 101, Edificio ...">
                                            <div class="invalid-feedback">
                                                Ingrese información de dirección.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="text-register" for="obs">Observaciónes</label>
                                            <input type="text" class="form-control" name="obs" id="obs" value="@if(!empty($completeRequest->obs)){{$completeRequest->obs}}@endif" placeholder="Ej: No hay porteria, por favor llamar a celular" >
                                            <div class="invalid-feedback">
                                                Ingrese información adicional de la dirección.
                                            </div>
                                        </div>
                                    </div>
                               
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
                               
                               
                                <hr class="mb-4">
                                <div class="conatiner">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <button class="btn btn-purchase btn-block" type="submit">Guardar Información y Continuar con el Pago</button>
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

        $("#address_1").change(function(){
            $("#address_2").focus();
        });
        $("#address_3").change(function(){
            $("#address_4").focus();
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