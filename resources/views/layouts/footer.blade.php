<div id="cajacookies">

  Éste sitio web usa cookies, si permanece aquí acepta su uso.
  Puede leer más sobre el uso de cookies en nuestra <a href="/privacy-policy">política de privacidad</a>.
  <button onclick="aceptarCookies()" class="btn btn-success">Aceptar</button>

</div>
<!-- Footer -->
<footer class="page-footer font-small unique-color-dark"  style="background-color: #403d38;">
    <div class="container">
        <div class="row py-3 align-items-center">
            <div class="col-6 col-md-6">
                Leemon Team
            </div>
            <div class="col-6 col-md-6 text-right">
                <a class="link-a" href="#">Regresar Arriba</a>
            </div>
        </div>
    </div>
    <div style="background-color: #fba38f;">
      <div class="container">
        <!-- Grid row-->
        <div class="row py-4 d-flex align-items-center">
  
          <!-- Grid column -->
          <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
            <h6 class="mb-0">Mantente Conectado con Leemon en las Redes Sociales!</h6>
          </div>
          <!-- Grid column -->
  
          <!-- Grid column -->
          <div class="col-md-6 col-lg-7 text-center text-md-right">
  
            <!-- Facebook -->
            <a id="facebook-f" class="fb-ic facebook-f" href="https://www.facebook.com/leemonmarket" target="_blank">
              <i class="white-text mr-4"></i>
            </a>

            <!-- Twitter 
            <a id="twitter" class="tw-ic">
              <i class="white-text mr-4"> </i>
            </a>-->
            
            <!--Instagram-->
            <a id="instagram" class="ins-ic" href="https://www.instagram.com/leemonmarket/" target="_blank">
              <i class="white-text mr-4"> </i>
            </a>

            <!-- Google +
            <a id="google-plus" class="gplus-ic">
              <i class="white-text mr-4"> </i>
            </a>-->
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row-->
      </div>
    </div>
  
    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4 brand-font">
  
          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Productos</h6>
          <hr class="hr-color accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;"><br>
          @foreach ($menus as $key => $item)
            @if ($item['father_id'] == 0)
                
                    <a class="link-a" href="#!">{{ $item['name'] }}</a><br>
                
            @endif
          @endforeach
          {{-- <p>
            <a  class="link-a" href="#!">MDWordPress</a>
          </p>
          <p>
            <a  class="link-a" href="#!">BrandFlow</a>
          </p>
          <p>
            <a  class="link-a" href="#!">Bootstrap Angular</a>
          </p> --}}
  
        </div>
        <!-- Grid column -->
  
        <!-- Grid column -->
        <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4 brand-font">
  
          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Links de Interes</h6>
          <hr class="hr-color accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a class="link-a" target="_blank" href="/terms/privacy-policy-and-data-processing">Política de privacidad y Tratamiento de Datos</a>
            <br>
            <a class="link-a" href="/terms/service-policy-refound-and-return-policy">Política de Términos de Servicio, Política de Reembolsos y Devoluciones</a>
          <br>
            <a class="link-a" href="/terms/faq">Preguntas Frecuentes</a>
          </p>
  
        </div>
        
        
        <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4 brand-font">
  
          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Contacto</h6>
          <hr class="hr-color accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <i class="fas fa-home mr-3"></i> Barranquilla, 080002, Colombia<br>
            <i class="fas fa-envelope mr-3"></i> servicioalcliente@leemon.com.co<br>
            {{-- <i class="fas fa-phone mr-3"></i> + 57 234 567 88<br>
            <i class="fas fa-print mr-3"></i> + 57 234 567 89 --}}
          </p>
  
        </div>
        <!-- Grid column -->
  
      </div>
      <!-- Grid row -->
  
    </div>
    <!-- Grid column -->
    <div class="container">
      <div class="col-12-col-md-12">
        <div class="row justify-content-center">
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4 text-center">
  
            <!-- Content -->
            <img src="{{ env('APP_URL') }}/img/logo_leemon_small_white.png" alt="" class="leemonlogo">
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
              leemon.com.co
            </div>
          </div>
        </div>
      </div>
    </div>
    
  
  </footer>
  <!-- Footer -->
  <script>
    /* ésto comprueba la localStorage si ya tiene la variable guardada */
    function compruebaAceptaCookies() {
        if(localStorage.aceptaCookies == 'true'){
            cajacookies.style.display = 'none';
        }
    }
/* aquí guardamos la variable de que se ha
aceptado el uso de cookies así no mostraremos
el mensaje de nuevo */
function aceptarCookies() {
   localStorage.aceptaCookies = 'true';
   cajacookies.style.display = 'none';
}

/* ésto se ejecuta cuando la web está cargada */
$(document).ready(function () {
   compruebaAceptaCookies();
});
</script>