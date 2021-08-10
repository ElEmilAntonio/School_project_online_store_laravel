    <?php 
     $user= Auth::user()->roles->pluck('name');
     $extencion="";
     $sicliente=0;
     if ( $user->contains('cliente') ) {$extencion="layouts.appcliente";
     $sicliente=1;
     }else if($user->contains('empleado')){$extencion="layouts.appempleado";
     }else if($user->contains('administrador')){$extencion="layouts.appadministrador";}
     $seguidorexterno=1;
     $vervacio=0;
     $restante=0;
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
      <h1>Pagos</h1>     
        <div class="row justify-content-left">
           <div class="panel panel-default">
            
        <div class="panel-heading">
          Ventas
        </div>
        <div class="panel-body">
            <table class="table table-striped ">
                <thead>
                <th align="center" style="padding:1px">id</th>
                 <th align="center" style="padding:1px">Meses</th>
                <th align="center" style="padding:1px">Fecha</th>
                <th align="center" style="padding:1px">Hora</th>
                <th align="center" style="padding:1px">Costo</th>
                <th align="center" style="padding:1px">Iva</th>
                <th align="center" style="padding:1px">Total</th>
                <th align="center" style="padding:1px">Pagado</th>
                 <th align="center" style="padding:1px">Faltante</th>
                <th align="center" style="padding:1px">Entrega</th>
                <th align="center" style="padding:1px">Estado</th>
                 <th></th>
             </thead>
             @if(count($ventas) > 0)
             <tbody>
                @foreach ($ventas as $venta)
                @foreach($deudas as $deuda)
                @if($venta->id==$deuda->id_venta)
                <tr>
                  
                    <td align="center" class="table-text"><div>{{$venta->id}}</div></td>
    @if($deuda->meses==0)<td align="center" class="table-text"><div>al contado</div></td>
    @else <td align="center" class="table-text"><div>{{$deuda->meses}}</div></td>
    @endif
                    <td align="center" class="table-text"><div>{{$venta->fecha}}</div></td>
                     <td align="center" class="table-text"><div>{{$venta->hora}}</div></td>
                    <td align="center" class="table-text"><div>{{$venta->importe}}</div></td>
                    <td align="center" class="table-text"><div>{{$venta->iva}}</div></td>
                    <td align="center" class="table-text"><div>{{$venta->total}}</div></td>
                    <td align="center" class="table-text"><div>{{$deuda->abono}}</div></td>
 <?php $restante=$deuda->deuda_actual-$deuda->abono ?>
                    <td align="center" class="table-text"><div>{{$restante}}</div></td>
  @if($venta->entrega==0)<td align="center" class="table-text"><div>preparación</div></td>
  @elseif($venta->entrega==1)<td align="center" class="table-text"><div>en camino</div></td>
  @else            <td align="center" class="table-text"><div>entregado</div></td>  
  @endif
  @if($deuda->estado==2)<td align="center" class="table-text"><div>pagado</div></td>
  @else<td align="center" class="table-text"><div>pendiente</div></td>
  @endif
                       <td>
                        <button type="submit" class="btn btn-primary btn-sm" onclick="location.href='/abonar_tienda/{{$venta->id}}'" method="GET">Abonar
                        </button>
                </td>
              
            </tr>
            @endif
            @endforeach
            @endforeach
        </tbody>
    </table>
    @endif

 
        </div>
    </div>
    </div>
    </div>

<hr>
     
    @endsection
