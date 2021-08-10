
<!DOCTYPE html>
<html>

<head>
	<style>
table, th{
  border: 1px solid black;
}
</style>
  <title>Ventas de la muebleria</title>
</head>
<body>

<h1 align="center">ventas de la muebleriaRS</h1>
 @if($tipo==="1")<h2 >Todos</h2>
    @elseif($tipo==="2")<h2 >Pagados</h2>
    @else  <h2 >Pendientes</h2>
    @endif
            <table >
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
             </thead>
             @if(count($ventas) > 0)
             <tbody>
               <tr><td></td></tr>
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
                     
            </tr>
            @endif
            @endforeach
            @endforeach
        </tbody>
    </table>

    @endif
     
</body>
</html>