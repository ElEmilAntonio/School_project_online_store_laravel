<?php 
 $user= Auth::user()->roles->pluck('name');
 $extencion="";
 if ( $user->contains('cliente') ) {$extencion="layouts.appcliente";
 }else if($user->contains('empleado')){$extencion="layouts.appempleado";
 }else if($user->contains('administrador')){$extencion="layouts.appadministrador";}
?>
@extends($extencion)
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<div class="container">
        <div class="row">
         @if (count($productos) > 0)

            @foreach ($productos as $producto)
             <div  class="col-sm-3">
            <div class="w3-container" align="center" onclick="location.href='/descripcion_producto/{{$producto->id}}'">

  <div class="w3-card-4" style="width:100%">
    <img src="/images/{{$producto->imagen}}" alt="Alps" style="height:200px;width:210px;">
    <div class="w3-container w3-center">
      <p>{{$producto->nombre}}</p>
      <p>$ {{$producto->precio}} Mx</p>
    </div>
  </div>
</div>
 </div>
@endforeach   
@endif 
</div>
</div>
@endsection
