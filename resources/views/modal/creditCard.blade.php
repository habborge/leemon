<div class="modal fade text-left" id="modalCard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
    <div class="modal-dialog modal-width" role="document" style="">
        <div class="modal-content">
            <form method="POST" name="form_edit_info_card" id="form_edit_info_card" class="nm" target="hidden_iframe" onsubmit="submitted=true;"  novalidate="novalidate">
                <div class="">
                    <div class="modal-header bg-color-b">
                        <span class="modal-title white" id="myModalLabel9">Nueva Tarjeta de Credito</span>
                        <button type="button" class="close x-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-12 modal-body" style="">
                        <div class="row">
                            
                            <div class="col-md-12 order-md-1">
                            
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        
                                        <label class="text-register" for="cc_name">Nombre en la Tarjeta</label>
                                        <input type="text" class="form-control @if ($errors-> has('cc_name'))  is-invalid @endif" name="cc_name" id="cc_name" value="@if(!empty($completeRequest->cc_name)){{$completeRequest->cc_name}}@endif" placeholder="Ej: Nombre Apellido" required>
                                        @if ($errors-> has('cc_name'))  
                                            <div class="invalid-feedback">
                                                Nombre es Obligatorio.
                                            </div> 
                                        @else
                                            <small class="text-muted">Nombre tal cual aparece desplegado en la tarjeta</small>
                                        @endif 
                                    
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-register" for="cc_number">Número Tarjeta de Credito</label>
                                        <input type="text" class="form-control @if ($errors-> has('cc_number'))  is-invalid @elseif ($errors-> has('notice')) is-invalid @endif" name="cc_number" id="cc_number" value="@if(!empty($completeRequest->cc_number)){{$completeRequest->cc_number}}@endif" placeholder="Ej: 123456789212" required>
                                        <div class="invalid-feedback">
                                            @if ($errors-> has('cc_number')) Número de Tarjeta es requerida. @endif
                                            @if ($errors-> has('notice')) Número de Tarjeta es Invalido. @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
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
                                
                                
                            </div>
                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row float-left">
                                        <button type="button" class="btn btn-success btn-sm" onclick="submitForm()">Guardar Informacíon</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row float-right">
                                        <button type="button" class="btn grey btn-outline-danger btn-sm" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@section('modal-js')
  <script>
    // $(document).ready(function(){
//---------------------------------------------------------------------
        $("#form_edit_info_card").validate({
            submitHandler: function(form) {
                    
            }
        });
    // });

   
    </script>
@endsection