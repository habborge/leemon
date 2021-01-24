<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leemon Marketing</title>
    
    <link rel="stylesheet" href="../css/landing/style.css">
	<script src="https://unpkg.com/animejs@2.2.0/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
</head>
<style>
    @font-face {
        font-family: "AcuminVariableConcept2";
        src: url("{{ env('APP_URL')}}/css/AcuminVariableConceptCondens.otf") format('opentype');
    }
    @font-face {
        font-family: "AcuminVariableConcept";
        src: url("{{ env('APP_URL') }}/css/AcuminVariableConcept.otf") format('opentype');
    }
</style>
<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <header class="site-header">
			<div class="header-shape header-shape-1">
				{{-- <svg width="337" height="222" viewBox="0 0 337 222" xmlns="http://www.w3.org/2000/svg">
				    <defs>
				        <linearGradient x1="50%" y1="55.434%" x2="50%" y2="0%" id="header-shape-1">
				            <stop stop-color="#E0E1FE" stop-opacity="0" offset="0%"/>
				            <stop stop-color="#E0E1FE" offset="100%"/>
				        </linearGradient>
				    </defs>
				    <path d="M1103.21 0H1440v400h-400c145.927-118.557 166.997-251.89 63.21-400z" transform="translate(-1103)" fill="url(#header-shape-1)" fill-rule="evenodd"/>
                </svg> --}}
                <img src="../img/5.png" alt="" width="350px">
			</div>
			<div class="header-shape header-shape-2">
				<svg width="128" height="128" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" style="overflow:visible">
				    <defs>
				        <linearGradient x1="93.05%" y1="19.767%" x2="15.034%" y2="85.765%" id="header-shape-2">
				            <stop stop-color="#FF3058" offset="0%"/>
				            <stop stop-color="#FF6381" offset="100%"/>
				        </linearGradient>
				    </defs>
				    <circle class="anime-element fadeup-animation" cx="64" cy="64" r="64" fill="url(#header-shape-2)" fill-rule="evenodd"/>
				</svg>
			</div>
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="#">
								<img src="../img/leemon_black_logo.png" width="250px" alt="">
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <main>
            
			<section class="hero" style="background: url('../img/background_landing.png')">
				<div class="container">
					<div class="features-header text-center">
						<div class="container-sm">
							<h2 class="section-title mt-0">Estas a un paso de poder participar de nuestro Give Away</h2>
							<p class="section-paragraph">Registra tus datos a continuación. ¡Te deseamos suerte!</p>
						</div>
					</div>
					
                    <div class="hero ">
						
						
						<br>
						<div class="mb-3 control control-expanded">
							<label for="exampleFormControlInput1" class="form-label">Nombre</label>
							<input type="email" class="input" id="exampleFormControlInput1" placeholder="Nombre Completo">
						</div>
						<br>
						<div class="mb-3 control control-expanded">
						<label for="exampleFormControlInput1" class="form-label">Movil</label>
						<input type="email" class="input" id="exampleFormControlInput1" placeholder="Número de Celular">
						</div>
						<br>
						<div class="mb-3 control control-expanded">
						<label for="exampleFormControlInput1" class="form-label">email</label>
						<input type="email" class="input" id="exampleFormControlInput1" placeholder="Correo electronico">
						</div>
						<br>
						<div class="mb-3 control control-expanded">
						<label for="exampleFormControlInput1" class="form-label">Ciudad</label>
						<input type="email" class="input" id="exampleFormControlInput1" placeholder="Ciudad o Municipio">
						</div>
						<br>
						<div class="control">
							<div class="form-check">
							  <label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
								Acepto terminos y condiciónes, Politica deprivacidad de datos, asi como la politica de tratamieto y protección de datos perosnales.
							  </label>
							</div>
						</div>
						<br>
						<div class="control">
							<a class="button button-primary button-block" href="#">Enviar</a>
						</div>
					</div>
				</div>
                <br><br>
                
			</section>
          

			<section class="newsletter section text-light">
                
            </section>
        </main>

        @include('layouts.footer')
    </div>

    <script src="dist/js/main.min.js"></script>
</body>
</html>
