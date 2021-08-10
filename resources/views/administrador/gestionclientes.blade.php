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
 <div id="chart-div">
    
</div>

    <div class="container">
         <H1>LISTA DE CLIENTES</H1>
        <div class="row justify-content-left">
           <div class="panel panel-default">
               <button type="submit" class="btn btn-primary" onclick="location.href='/pdf_cliente'" method="GET">
                        <i class="fa fa-btn fa-box"></i> Generar pdf  clientes
                    </button>
        <div class="panel-heading">
          Ventas
        </div>
        <div class="panel-body">
            <table class="table table-striped ">
                <thead>
                <th align="center" style="padding:1px">id</th>
                 <th align="center" style="padding:1px">Nombre</th>
                <th align="center" style="padding:1px">Apellidos</th>
                <th align="center" style="padding:1px">Rfc</th>
                <th align="center" style="padding:1px">Presupuesto</th>
                <th align="center" style="padding:1px">deuda</th>
                <th align="center" style="padding:1px">Presupuesto disponible</th>
             </thead>
             @if(count($clientes) > 0)
             <tbody>
                @foreach ($clientes as $cliente)
               <?php $deudatotal=0 ?> 
                @foreach($ventasclientes as $ventacliente)
                @if($cliente->id==$ventacliente->id_cliente)
                @foreach($deudas as $deuda)
                @if($ventacliente->id_venta==$deuda->id_venta)
                    <?php $deudatotal+=$deuda->deuda_actual ?> 
            @endif
            @endforeach
            @endif
            @endforeach
                       <tr>
                  
                    <td align="center" class="table-text"><div>{{$cliente->id}}</div></td>
                    <td align="center" class="table-text"><div>{{$cliente->nombres}}</div></td>
                     <td align="center" class="table-text"><div>{{$cliente->apellidos}}</div></td>
                    <td align="center" class="table-text"><div>{{$cliente->rfc}}</div></td>
                    <?php $presupuesto=($cliente->salario)*10;
                          $presupuestotal=$presupuesto-$deudatotal;
                     ?>
                    <td align="center" class="table-text"><div>{{$presupuesto}}</div></td>
                    <td align="center" class="table-text"><div>{{$deudatotal}}</div></td>
                    <td align="center" class="table-text"><div>{{$presupuestotal}}</div></td>
            </tr>
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
