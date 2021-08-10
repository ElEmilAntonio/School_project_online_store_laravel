    <?php 
     $user= Auth::user()->roles->pluck('name');
     $extencion="";
     if($user->contains('empleado')){$extencion="layouts.appempleado";
     }else if($user->contains('administrador')){$extencion="layouts.appadministrador";}
     $seguidorexterno=1;
     $costototal=$carrito->total+$carrito->iva;
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
    <div class="container">
        <div class="row">
        <div  class="col-sm-6">
        <div class="row justify-content-left">
         
           <div class="panel panel-default">
        <div class="panel-heading">
          Carrito
        </div>
        <div class="panel-body">
            <table class="table table-striped ">
                <thead>
                 <th align="center" style="padding:1px">Imagen</th>
                 <th align="center" style="padding:1px">Nombre</th>
                 <th align="center" style="padding:1px">Cantidad</th>
                 <th align="center" style="padding:1px">Precio</th>
                  <th align="center" style="padding:1px">Total</th>
             </thead>
             @if(count($productocarritos) > 0)
             <tbody>
                @foreach ($productocarritos as $productocarrito)
                  <?php $seguidorinterno=1; ?>
                @foreach($productos as $producto)
                @if($seguidorinterno==$seguidorexterno)
                <tr>
                    <td><div> <img type="image" src="/images/{{$producto->imagen}}" alt="Foto de perfil"  style="height:40px;width:40px;">   </div></td> 
                   <td align="center" class="table-text"><div>{{ $producto->nombre}}</div></td>
                   <td align="center" class="table-text"><div>{{ $productocarrito->cantidad}}</div></td>
                   <td align="center" class="table-text"><div>$ {{ $producto->precio}}</div></td>
                    <td align="center" class="table-text"><div>$ {{ $productocarrito->costo}}</div></td>
            </tr>
            @endif
             <?php $seguidorinterno++; ?>
            @endforeach

            <?php $seguidorexterno++; ?>
            @endforeach
            <tr>
                 <td align="center" class="table-text"></td>
                 <td align="center" class="table-text"></td>
                 <td align="center" class="table-text">Costo :{{$carrito->total}}</td>
                 <td align="center" class="table-text">Iva :{{$carrito->iva}}</td>
                 <td align="center" class="table-text">Total:{{$costototal}}</td>
            </tr>
        </tbody>
    </table>
    @endif
        
        </div>
    </div>

  </div>
</div>
   <div  class="col-sm-6">
    Nota: En las ventas en el local solo se permiten el pago completo del producto
    <hr>
     <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Metodo de pago:') }}</label>

                            <div class="col-md-6">
                        <select id="pago" name="pago">
                        <option  value="0">Efectivo</option>
                            <option  value="1">Débito</option>
                           </select>
                                @error('unidades')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Entrega:') }}</label>

                            <div class="col-md-6">
                        <select id="seleccion" name="seleccion" onchange="sucursal(this.value)">
                          <option  value="kek">------</option>
                             @if(count($sucursales) > 0)
                @foreach ($sucursales as $sucursal)
                <option  value="{{$sucursal->id}}">{{$sucursal->calle_colonia}}</option>
                @endforeach
                @endif 
                            <option  value="">Otra direccion</option>
                           </select>
                                @error('unidades')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                             <div class="card-body">
                    <form method="POST" action="{{ route('completar_venta') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group row" style="display:none;">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('sucursal') }}</label>

                            <div class="col-md-6">
                                <input id="sucursal" type="text" class="form-control @error('sucursal') is-invalid @enderror" name="sucursal"  autofocus>

                                @error('sucursal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Calle y colonia') }}</label>

                            <div class="col-md-6">
                                <input id="calle" type="text" class="form-control @error('calle') is-invalid @enderror" name="calle" value="{{ old('calle') }}" autocomplete="calle" autofocus disabled>

                                @error('calle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('CP') }}</label>

                            <div class="col-md-6">
                                <input id="cp" type="number" class="form-control @error('cp') is-invalid @enderror" name="cp" value="{{old('cp')}}" autocomplete="cp" autofocus disabled>

                                @error('cp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                            <div class="col-md-6">
                                <input id="ciudad" type="text" class="form-control @error('ciudad') is-invalid @enderror" name="ciudad" value="{{old('ciudad')}}" autocomplete="ciudad" autofocus disabled>

                                @error('ciudad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <input id="estado" type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{old('estado')}}" autocomplete="estado" autofocus disabled>

                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button  id="botonunico" type="submit" class="btn btn-primary" disabled>
                                    {{ __('Completar compra') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                        </div>
   </div>
</div>

    @endsection
<script type="text/javascript">
function sucursal($sucursal){
document.getElementById("sucursal").value=$sucursal;
if($sucursal=="kek"){
document.getElementById("botonunico").disabled=true;
}
if($sucursal==""){
document.getElementById("calle").required = true;
document.getElementById("cp").required = true;
document.getElementById("ciudad").required = true;
document.getElementById("estado").required = true;
document.getElementById("calle").disabled = false;
document.getElementById("cp").disabled = false;
document.getElementById("ciudad").disabled = false;
document.getElementById("estado").disabled = false;
document.getElementById("botonunico").disabled=false;
}else{
document.getElementById("calle").required =false;
document.getElementById("cp").required = false;
document.getElementById("ciudad").required = false;
document.getElementById("estado").required = false;
document.getElementById("calle").disabled = true;
document.getElementById("cp").disabled = true;
document.getElementById("ciudad").disabled = true;
document.getElementById("estado").disabled = true;
document.getElementById("botonunico").disabled=false;
}
}

  

</script>