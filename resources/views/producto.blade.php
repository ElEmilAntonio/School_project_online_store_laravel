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
      
            <div class="w3-container" align="center">

  <div class="w3-card-4" style="width:100%">
    <img src="/images/{{$producto->imagen}}" alt="Alps" style="height:60%;width:50%;">
      <p>{{$producto->nombre}} $ {{$producto->precio}} Mx</p>
      <p>{{$producto->descripcion}}</p>
      <form method="POST" action="{{ url('agregar_carrito')}}/{{$producto->id}}" enctype="multipart/form-data">
        @csrf
        <?php
        $numero=(int)$producto->unidades;
        $inicio=1;
         ?>
          cantidad: <select id="unidades" name="unidades" onchange="Total(this.value)">
                    @while($inicio<=$numero)    
                        <option  value="{{$inicio}}">{{$inicio}}</option>
                     <?php $inicio++; ?> 
                     @endwhile
                           </select> <input type="text" name="total" id="total" value="{{$producto->precio}}" disabled>
        <button type="submit" class="btn btn-primary">{{ __('Agregar al carrito') }}
                                </button>
      </form>
    <p><h4>comentario:</h4></p>
    <form method="POST" action="{{ url('comentar_producto')}}/{{$producto->id }}" enctype="multipart/form-data">
                        @csrf
    <textarea style="width:75%;height:55px;" id="comentario" name="comentario"></textarea>
    <input id="imagen" type='file' onchange="readURL(this);"  lass="form-control @error('imagen') is-invalid @enderror" name="imagen" autofocus/>
                                <img id="blah" src="/images/predeterminado.jpg" alt="tu comentario" style="height:120px;width:120px;"/>
    <button type="submit" class="btn btn-primary">{{ __('Comentar') }}
                                </button></form>
  </div>
</div>
 <div class="container" align="center">
   <hr>
   <h3>COMENTARIOS</h3>
   @if(count($comentarios)>0)
   @foreach($comentarios as $comentario)
   <div class="w3-container" align="center">
   <div class="w3-card-4" style="width:100%">
    <?php
    $filename="/comentarios/".$comentario->comentario;
    $path = Storage::disk('local')->path($filename);
     $contenido=file_get_contents($path)?>
    <p>{!!$contenido!!}</p>
    <p>
       <p><a onclick="location.href='/descargar_archivo/{{ $comentario->comentario}}'" method="GET" class="row justify-content-center"><u>{{$comentario->comentario}}</u></a></p>
    </p>
   </div></div>
   @endforeach
   @endif
  </div>
</div>
@endsection
<script type="text/javascript">
function Total(cantidad){
var valor = "<?php echo $producto->precio?>";
document.getElementById("total").value= valor*cantidad;
}

      function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>