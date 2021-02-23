@extends('layouts.app')
@section('custom-css')

@endsection
@section('content')
    <div id="main" class="clearfix body-cart">
        <div class="container no-padding-sm-xs dataPosition2">
            <div class="row ">
                <div class="col-md-12">
                    <div class="row">
                        <div class="card col-md-12 bg-light mb-4 mt-4 card-rounded">
                            <div class="card-header row card-round-header"><b>Verificación de Email</b></div>
                            <div class="card-body card-body-yellow row card-round-footer">
                                <div class="col-md-12">
                                    <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <div class="">
                                                        <p><h5>Please enter the 5-digit verification code we sent via SMS:</h5><h6> (we want to make sure it's you before we contact our movers)</h6></p>
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
@endsection