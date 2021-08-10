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
         
        <div class="row justify-content-left">
           <div class="panel panel-default">
            
        <div class="panel-heading">
          Compras
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
             @if(count($ventascliente) > 0)
             <tbody>
                @foreach ($ventascliente as $ventacliente)
                @foreach ($ventas as $venta)
                @if($ventacliente->id_venta==$venta->id)
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
                        <button type="submit" class="btn btn-primary btn-sm" onclick="location.href='/detalle_venta_cliente/{{$venta->id}}'" method="GET">
                          Tabla mortizacion pdf
                        </button>
                </td>
              
            </tr>
            @endif
            @endforeach
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
