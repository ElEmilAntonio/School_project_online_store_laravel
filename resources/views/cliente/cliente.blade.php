@extends('layouts.appcliente')

@section('content')
<p class="row justify-content-center"></p>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inicio</div>
                @csrf
                {{ csrf_field() }}
                <div class="card-body">
                    <p>
                  <img type="image" src="images/{{$cliente->foto}}" alt="Foto de perfil"  style="height:120px;width:120px;">   
                 </p>
                 <p> Hola: {{$cliente->Nombres}} {{$cliente->Apellidos}}</p>
                 <p>Es un gusto tenerlo de vuelta c:</p>
                 
             </div>
         </div>
     </div>
 </div>
</div>
@endsection

