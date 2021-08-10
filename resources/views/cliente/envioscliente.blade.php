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
          Envios
        </div>
        <div class="panel-body">
            <table class="table table-striped ">
                <thead>
                 <th align="center" style="padding:1px">id_venta</th>
                <th align="center" style="padding:1px">Estado</th>
                <th align="center" style="padding:1px">Ciudad</th>
                <th align="center" style="padding:1px">Cp</th>
                <th align="center" style="padding:1px">Calle y colonia</th>
                <th align="center" style="padding:1px">Entrega</th>
                 <th align="center" style="padding:1px">Opciones</th>
             </thead>
             @if(count($ventascliente) > 0)
             <tbody>
                @foreach ($ventascliente as $ventacliente)

                @foreach ($envios as $envio)
                @if($ventacliente->id_venta==$envio->id)
                @foreach($domicilios as $domicilio)
                @if($envio->id==$domicilio->id_venta)
     
                <tr>
                  
                    <td align="center" class="table-text"><div>{{$envio->id}}</div></td>
                    <td align="center" class="table-text"><div>{{$domicilio->estado}}</div></td>
                     <td align="center" class="table-text"><div>{{$domicilio->ciudad}}</div></td>
                      <td align="center" class="table-text"><div>{{$domicilio->cp}}</div></td>
                       <td align="center" class="table-text"><div>{{$domicilio->calle_colonia}}</div></td>

  @if($envio->entrega==0)<td align="center" class="table-text"><div>en preparación</div></td>
  @elseif($envio->entrega==1)<td align="center" class="table-text"><div>en camino</div></td>
  @else            <td align="center" class="table-text"><div>entregado</div></td>  
  @endif                     
                       <td>
                         @if($envio->entrega!=3)
    <button type="submit" class="btn btn-success btn-sm" onclick="location.href='/update_envio_cliente/{{$envio->id}}/3'" method="GET">Marcar como entregado
                        </button>
                        @endif
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
    @endsection
