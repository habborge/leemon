@extends('layouts.app')

@section('content')
<div class="tabs">
    <div class="container">
        <div class="row">
            <div class="alert @if ($approval == 1) alert-success @else alert-danger @endif" role="alert">
                <h4 class="alert-heading">@if ($approval == 1) Transacción Approvada @else Atención @endif</h4>
                <p>{{ $message }}</p>
                <hr>
                <p class="mb-0">Continuar Navegando</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>
@endsection