
<!DOCTYPE html>
<html>

<head>
	<style>
table, th{
  border: 1px solid black;
}
</style>
  <title>Clientes de la muebleria</title>
</head>
<body>

<h1 align="center">Clientes de la muebleriaRS</h1>
          <div class="panel-body">
            <table>
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
               <tr><td></td></tr>
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
</body>
</html>