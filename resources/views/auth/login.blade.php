@extends('layouts.app')

@section('content')
<div class="container litlemargin">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Iniciar Sesión') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                        <div class="form-group row">
                            
                            @if($errors->has("recaptcha_token"))
                                {{$errors->first("recaptcha_token")}}
                            @endif

                            <div class="col-md-12">
                                <label for="email" class="col-form-label text-md-right text-register">{{ __('Correo Electronico') }}</label>
                                <input id="email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-12">
                                <label for="password" class="col-form-label text-md-right text-register">{{ __('Contraseña') }}</label>
                                <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check brand-font">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recuerdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('Acceder') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link brand-font" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="a-divide a-divider"><h5>¿Eres nuevo en Leemon?</h5>
                <a href="{{ route('register') }}" class="btn btn-info btn-sm btn-block" >Crea una Cuenta en Leemon</a> </div>
            </div>
        </div>
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
@endsection
