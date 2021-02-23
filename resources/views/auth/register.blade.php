@extends('layouts.app')
@section('custom-css')
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
@endsection
@section('content')
<div class="container litlemargin">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                        <div class="form-group row">
                            @if($errors->has("recaptcha_token"))
                                <div class="col-12 alert alert-danger text-center" role="alert">
                                    Ha intentado enviar información despues de un tiempo de inactividad. Vuelva a intentar enviar la información.
                                </div>
                             @endif

                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-right text-register">{{ __('Nombres y Apellidos') }}</label>
                                <input id="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                             <div class="col-md-12">
                                <label class="text-register" for="birthday">Fecha de Nacimiento</label>
                                <input type="text" class="form-control form-control-sm bg-white @error('birthday')  is-invalid @enderror" name="birthday" id="birthday" placeholder="Click para escojer fecha" value="{{ old('birthday') }}" readonly>
                                <div class="invalid-feedback" role="alert">
                                    La fecha de nacimiento es requerida.
                                </div>
                            </div> 
                            {{-- <div class="col-md-4 mb-3">
                                <label class="text-register" for="n_doc">Número Cedula</label>
                                <input type="text" class="form-control @if ($errors-> has('n_doc'))  is-invalid @endif" name="n_doc" id="n_doc" placeholder="Ej: 4893848349" value="@if(!empty($completeRequest->n_doc)){{$completeRequest->n_doc}}@endif" required>
                                <div class="invalid-feedback">
                                    El número de Indentificación es requerido.
                                </div>
                            </div> --}}
                        </div>
                        <div class="form-group row">
                             <div class="col-md-12">
                                <label class="text-register" for="phone">Teléfono</label>
                                <input type="text" class="form-control form-control-sm @error('phone')  is-invalid @enderror" name="phone" id="phone" placeholder="Ej: 4893848349" value="{{ old('phone') }}" required>
                                <div class="invalid-feedback" role="alert">
                                    El número de Teléfono es requerido.
                                </div>
                            </div> 
                        </div>
                        <div class="form-group row">
                            

                            <div class="col-md-12">
                                <label for="email" class="col-form-label text-md-right text-register">{{ __('Correo Electronico') }}</label>
                                <input id="email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            
                            <div class="col-md-12">
                                <label for="password" class="col-form-label text-md-right text-register">{{ __('Contraseña segura') }}</label>

                                <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password-confirm" class="col-form-label text-md-right text-register">{{ __('Confirma la contraseña') }}</label>
                                <input id="password-confirm" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-register2">Al crear una cuenta, aceptas los <a href="">terminos y condiciones</a> , asi el como la <a href="">Privacidad de datos</a> en Leemon.com.co.</div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('Registra tu cuenta en Leemon') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-register3">¿Ya tienes tu cuenta? <a href="">Iniciar sesión en Leemon</a></div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RE_KEY') }}"></script>
<script src="/js/jquery-ui.min.js" defer></script>
<script>
    grecaptcha.ready(function() {
    grecaptcha.execute('{{ env('RE_KEY') }}')    .then(function(token) {
    document.getElementById("recaptcha_token").value = token;
    }); });
</script>
<script type="text/javascript">
    
    $(document).ready(function(){
        $("#birthday").datepicker({
            changeMonth: true,
            changeYear: true
        }); 

        $('#name').on('input', function () { 
            this.value = this.value.replace(/[^ a-záéíóúüñA-Z]/g,'');
        });

        $('#phone').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });
    });
</script>        
@endsection