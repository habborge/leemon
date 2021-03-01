@extends('layouts.app')
@section('custom-css')
<style>
    #botonResend{
        display: none
    }
</style>
@endsection
@section('content')
    <div id="main" class="clearfix body-cart">
        <div class="container litlemargin">
            <div class="row ">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="md-stepper-horizontal orange">
                            {{-- <div class="md-step active done"> --}}
                            {{-- <div class="md-step active editable"> --}}
                            <div class="md-step active done">
                              <div class="md-step-circle"><span>1</span></div>
                              <div class="md-step-title">Registro</div>
                              <div class="md-step-bar-left"></div>
                              <div class="md-step-bar-right"></div>
                            </div>
                            <div class="md-step active">
                              <div class="md-step-circle"><span>2</span></div>
                              <div class="md-step-title">Verificación</div>
                              {{-- <div class="md-step-optional">Optional</div> --}}
                              <div class="md-step-bar-left"></div>
                              <div class="md-step-bar-right"></div>
                            </div>
                            <div class="md-step">
                              <div class="md-step-circle"><span>3</span></div>
                              <div class="md-step-title">Envío</div>
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
                    <div class="row">
                        <div class="card col-md-12 bg-light mb-4 mt-4 card-rounded">
                            <div class="card-header row card-round-header"><h4>Verificación de Email</h4></div>
                            <div class="card-body card-body-yellow row card-round-footer">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="">
                                                <p><h5>Por favor escriba los 7-digitos del código verificación enviados al email registrado en Leemon:</h5><h6> (Queremos asegurarnos de que es usted antes de seguir navegando en Leemon)</h6></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row ">
                                                <div class="col-4 col-md-4">

                                                </div>
                                                <div class="col-4 col-md-4">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12">
                                                            <div class="row">
                                                                <input id="code" class="form-control form-control-lg" type="text" name="" id="" style="text-align: center;">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 mt-3">
                                                            <div class="row">
                                                                <button id="verifycode" class="btn btn-primary btn-block">Verificar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-4">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-12 col-md-12 mt-3">
                                                    <hr>
                                                    Reenviar Código de Verificación en <span>00:<span id="countdown"></span></span>
                                                    <a href="/register/auth/email/verify" id="botonResend" class="btn btn-leemon-back btn-sm">Reenviar Código</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function(){
            
            $("#verifycode").click(function () {
                
                var code = $("#code").val();

                $.ajax({
                    url: "{{ url('/secure/verify/email')}}",
                    method: "post",
                    data: {_token: '{{ csrf_token() }}', code: code},
                    beforeSend: function(x){
                        
                    },
                    success: function (response) {
                        if (response.status == 200){
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Código Verificado Correctamente',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            window.location = '{{ route('cart') }}';
                        }else{
                            toastr.error("Codigo incorrecto, Verifique su código");
                        }
                        
                    },
                    
                });
            }); 
        });
    </script>
    <script>
        window.onload = updateClock;
        var totalTime = '{{ $seconds }}';
        function updateClock() {
            document.getElementById('countdown').innerHTML = totalTime;
            if(totalTime==0){
                $("#botonResend").show();
            }else{
                totalTime-=1;
                setTimeout("updateClock()",1000);
            }
        }
    </script>
@endsection