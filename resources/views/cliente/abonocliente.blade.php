    <?php 
     $user= Auth::user()->roles->pluck('name');
     $extencion="";
     if($user->contains('cliente')){$extencion="layouts.appcliente";
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
             @if(count($productosventa) > 0)
             <tbody>
                @foreach ($productosventa as $productoventa)
                @foreach($productos as $producto)
                @if($productoventa->id_producto==$producto->id)
                <tr>
                    <td><div> <img type="image" src="/images/{{$producto->imagen}}" alt="Foto de perfil"  style="height:40px;width:40px;">   </div></td> 
                   <td align="center" class="table-text"><div>{{ $producto->nombre}}</div></td>
                   <td align="center" class="table-text"><div>{{ $productoventa->cantidad}}</div></td>
                   <td align="center" class="table-text"><div>$ {{ $producto->precio}}</div></td>
                  <?php $preciototal=$producto->precio*$productoventa->cantidad ?>  
                    <td align="center" class="table-text"><div>$ {{ $preciototal}}</div></td>
            </tr>
            @endif
            @endforeach
            @endforeach
            <tr>
                   <td align="center" class="table-text"></td>
                 <td align="center" class="table-text"></td>
                 <td align="center" class="table-text">Costo :{{$venta->importe}}</td>
                 <td align="center" class="table-text">Iva :{{$venta->iva}}</td>
                 <td align="center" class="table-text">Total:{{$venta->total}}</td>
            </tr>
        </tbody>
    </table>
    @endif

        </div>
        
    </div>

  </div>
</div>
   <div  class="col-sm-6">
     <p><h4>Mensualdiad: {{$deuda->meses}} Abonado:${{$deuda->abono}} Total:${{$deuda->deuda_actual}}</h4><p>
    <?php $mesesfaltantes=$deuda->meses-$deuda->meses_pagados ?>
    <?php $abonomensual=$deuda->deuda_actual/$deuda->meses ?>
    <?php $redondeo=round($abonomensual,2) ?>
    <p><h4>Meses faltantes:{{$mesesfaltantes}} abono por mes: {{$redondeo}}</h4></p>
    <hr>
     
                        
    <form method="POST" action="{{ url('pagar_abono_cliente')}}/{{$venta->id}}" enctype="multipart/form-data">
                        @csrf

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tarjeta') }}</label>

                            <div class="col-md-6">
                                <input id="kek" type="number" class="form-control @error('sucursal') is-invalid @enderror" name="kek" required  autofocus>

                                @error('sucursal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
     <div class="form-group row">
          

                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Meses a pagar:') }}</label>

                            <div class="col-md-6">

                        <select id="meses" name="meses">

                @for($a=1;$a<=(int)$mesesfaltantes;$a++)
                <?php $abonoapagar=$redondeo*$a

                ?>
                @if($abonoapagar>=$deuda->deuda_actual)
                <?php $abonoapagar=$deuda->deuda_actual ?>
                @endif
                        <option  value="{{$a}}">{{$a}}- ${{$abonoapagar}}</option>
                @endfor
                           </select>
                                @error('unidades')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                
                             <div class="card-body">
                   
                        
                        
                                <button  id="botonunico" type="submit" class="btn btn-primary">
                                    {{ __('Completar abono') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                        </div>
   </div>
</div>

    @endsection
