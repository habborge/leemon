@extends('layouts.app')

@section('content')
    @if ($infosaved == 0)
        <div class="container">
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72" alt="logo leemon">
                <h2>Formulario de Pago</h2> @if ($errors) {{ $errors }} @endif
                <p class="lead">Complete su información para procesar su compra.</p>
            </div>
        
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                    </h4>
                    <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                        <h6 class="my-0">Product name</h6>
                        <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$12</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                        <h6 class="my-0">Second product</h6>
                        <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$8</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                        <h6 class="my-0">Third item</h6>
                        <small class="text-muted">Brief description</small>
                        </div>
                        <span class="text-muted">$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                        <h6 class="my-0">Promo code</h6>
                        <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">-$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$20</strong>
                    </li>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Información de Facturación</h4>
                    <form class="needs-validation" action="{{ route('saveinfo') }}" method="POST" name="formaut" id="formRegisterwithdrawal" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname">Nombre</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    El campo Nombre es requerido.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname">Apellidos</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    El campo Apellidos es requerido.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">Número ID</label>
                                <input type="text" class="form-control" name="n_doc" id="n_doc" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    El número de Indentificación es requerido.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="">
                                <div class="invalid-feedback">
                                    Ingrese un email valido para las actualizaciones de entrega.
                                </div>
                            </div>
                        </div>
                        
        
                        <div class="mb-3">
                            <label for="address">Dirección de Facturación</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="" required>
                            <div class="invalid-feedback">
                            Ingrese su direccion de facturación.
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sameaddress" id="sameaddress">
                            <label class="custom-control-label distancia" for="same-address">Dirección de Facturación es la misma de la de envio</label>
                        </div>
                        <hr class="mb-4">
                        <div class="mb-3">
                            <label for="address2">Dirección del lugar donde recibirá envio</label>
                            <input type="text" class="form-control" name="delivery_address" id="delivery_address" placeholder="">
                        </div>
                        <hr class="mb-4">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="country">País</label>
                                <select class="custom-select d-block w-100" name="country" id="country" required>
                                    <option value="">Escojer...</option>
                                    <option value="colombia">Colombia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un país valido.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">Departamento</label>
                                <select class="custom-select d-block w-100" name="dpt" id="dpt" required>
                                    <option value="">Escojer...</option>
                                    <option value="atlantico">Atlántico</option>
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un valido departamento.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Ciudad</label>
                                <input type="text" class="form-control" name="city" id="city" placeholder="" required>
                                <div class="invalid-feedback">
                                    Ciudad es requerida.
                                </div>
                            </div>
                        </div>
                
                <hr class="mb-4">
        
                <h4 class="mb-3">Metodo de Pago</h4>
        
                <div class="row">
                    <div class="col-md-6 mb-3">
                    <label for="cc-name">Nombre en la Tarjeta</label>
                    <input type="text" class="form-control" name="cc_name" id="cc_name" placeholder="" required>
                    <small class="text-muted">Nombre tal cual aparece desplegado en la tarjeta</small>
                    <div class="invalid-feedback">
                        Nombre es Obligatorio.
                    </div>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="cc-number">Numero Tarjeta de Credito</label>
                    <input type="text" class="form-control" name="cc_number" id="cc_number" placeholder="" required>
                    <div class="invalid-feedback">
                        Numero de Tarjeta es requerida.
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                    <label for="cc-expiration">Fecha de Vencimiento</label>
                    <input type="text" class="form-control" name="cc_expiration" id="cc_expiration" placeholder="" required>
                    <div class="invalid-feedback">
                        Fecha es requerida.
                    </div>
                    </div>
                    <div class="col-md-3 mb-3">
                    <label for="cc-cvv">CVV</label>
                    <input type="text" class="form-control" name="cc_cvv" id="cc_cvv" placeholder="" required>
                    <div class="invalid-feedback">
                       Codigo de segurida es solicitado.
                    </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continuar al pago</button>
                </form>
            </div>
        </div>
    @else

    @endif
@endsection