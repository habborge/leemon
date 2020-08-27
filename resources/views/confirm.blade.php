@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <div class="col-xl-2">
                <ul class="nav nav-pills nav-stacked flex-column">
                    <li class="active" id="Bicho_1.png"><a href="#tab_a" data-toggle="pill"><img src="img/Bicho_1.png" class="img-tam" alt=""></a></li>
                    <li id="Candado_1.png"><a href="#tab_b"  data-toggle="pill"><img src="img/Candado_1.png" class="img-tam" alt=""></a></li>
                    <li id="Combo_1.png"><a href="#tab_c" data-toggle="pill"><img src="img/Combo_1.png" class="img-tam" alt=""></a></li>
                    <li id="Iman_1.png"><a href="#tab_d" data-toggle="pill"><img src="img/Iman_1.png" class="img-tam" alt=""></a></li>
                    <li id="Perro_1.png"><a href="#tab_e" data-toggle="pill"><img src="img/Perro_1.png" class="img-tam" alt=""></a></li>
                </ul>
            </div>
            <div class="col-xl-2">
                <ul class="nav nav-pills nav-stacked flex-column">
                    <li id="Bicho_2.png"><a href="#tab_f" data-toggle="pill"><img src="img/Bicho_2.png" class="img-tam" alt=""></a></li>
                    <li id="Candado_2.png"><a href="#tab_g" data-toggle="pill"><img src="img/Candado_2.png" class="img-tam" alt=""></a></li>
                    <li id="Combo_2.png"><a href="#tab_h" data-toggle="pill"><img src="img/Combo_2.png" class="img-tam" alt=""></a></li>
                    <li id="Iman_2.png"><a href="#tab_i" data-toggle="pill"><img src="img/Iman_2.png" class="img-tam" alt=""></a></li>
                    <li id="Perro_2.png"><a href="#tab_j" data-toggle="pill"><img src="img/Perro_2.png" class="img-tam" alt=""></a></li>
                </ul>
            </div>
            <div class="col-xl-6">
                <div class="tab-content" id="father">
                    <div class="tab-pane active" id="tab_a">
                        <h3>First tab with soft transitioning effect.</h3>
                        <img src="img/Bicho_1.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_b">
                        <h3>Second tab with soft transitioning effect.</h3>
                        <img src="img/Candado_1.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_c">
                        <h3>Third tab with soft transitioning effect.</h3>
                        <img src="img/Combo_1.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_d">
                        <h3>four tab with soft transitioning effect.</h3>
                        <img src="img/Iman_1.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_e">
                        <h3>Fit tab with soft transitioning effect.</h3>
                        <img src="img/Perro_1.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_f">
                        <h3>sixth tab with soft transitioning effect.</h3>
                        <img src="img/Bicho_2.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_g">
                        <h3>seventh tab with soft transitioning effect.</h3>
                        <img src="img/Candado_2.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_h">
                        <h3>Eight tab with soft transitioning effect.</h3>
                        <img src="img/Combo_2.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_i">
                        <h3>Nine tab with soft transitioning effect.</h3>
                        <img src="img/Iman_2.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="tab-pane" id="tab_j">
                        <h3>Ten tab with soft transitioning effect.</h3>
                        <img src="img/Perro_2.png" class="img-tam2" alt="">
                        
                    </div>
                    <div class="comentario" id="comentario"></div>
                </div>
                <div>
                    <form action="{{ route('generateimg') }}" method="POST" name="formaut" id="formRegisterwithdrawal">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Comentario sobre Imagen</label>
                          <input type="text" class="form-control" name="texto" id="texto" aria-describedby="emailHelp">
                          <small id="emailHelp" class="form-text text-muted">Escriba uun comentario.</small>
                        </div>
                        <input type="hidden" id="imgname" name="imgname">
                        <button type="submit" class="btn btn-primary">Finalizar pago</button>
                      </form>
                      @if(session('cart'))
                       
                      @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#imgname').val("Bicho_1.png");
        
        $(function() {
            var $a = $(".tabs li");
            $a.click(function() {
                $a.removeClass("active");
                $(this).addClass("active");
                //alert($(this).attr('id'));

                $('#imgname').val($(this).attr('id'));
                

            });
            
        });

        $("#texto").keyup(function () {
            var value = $(this).val();
            $("#comentario").text(value);
            
        }).keyup();
    });
</script>
@endsection