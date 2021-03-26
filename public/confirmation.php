<?php
    

    require __DIR__.'/../vendor/autoload.php';
    
    $app = require_once __DIR__.'/../bootstrap/app.php';

    

    $app->make(Illuminate\Contracts\Http\Kernel::class)->handle(Illuminate\Http\Request::capture());
    
    
    //qui llegan todas las transacciones echas por PayU en metodo POST 
    //instancia del controlador
    
    $test = new App\Http\Controllers\ConfirmController();
    //acesso a las funciones
    $test->ConfirmTransPayU($_POST);