
<!DOCTYPE html>
<html>

<head>
	<style>
table, th{
  border: 1px solid black;
}
</style>
  <title>Venta de le fecha {{$venta->fecha}}</title>
</head>
<body>

<h1 align="center">Tabla de mortización</h1>
<h1 align="center">Venta de le fecha {{$venta->fecha}}</h1>
@if($cliente!=null)
<h2>Datos del cliente</h2>
<table >
                <thead>
    
                 <th align="center" style="padding:1px">Nombres</th>
                  <th align="center" style="padding:1px">Apellidos</th>
                <th align="center" style="padding:1px">Rfc</th>
              
             </thead>
                          <tbody>
               <tr><td></td></tr>
               <tr>
                    <td align="center" class="table-text"><div>{{$cliente->nombres}}</div></td>
                     <td align="center" class="table-text"><div>{{$cliente->apellidos}}</div></td>
                    <td align="center" class="table-text"><div>{{$cliente->rfc}}</div></td>
            </tr>
        </tbody>
    </table>     
@else
<h2> Compra en tienda</h2>
@endif
            <table >
                <thead>
    
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
             <tbody>
               <tr><td></td></tr>
                <tr>
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
        </tbody>
    </table>   
<h2>Carrito de compra</h2>
<?php  $seguidorexterno=1;?>
            <table>
                <thead>
                
                 <th align="center" style="padding:1px">Nombre</th>
                 <th align="center" style="padding:1px">Cantidad</th>
                 <th align="center" style="padding:1px">Precio</th>
                  <th align="center" style="padding:1px">Total</th>
             </thead>
             @if(count($productosventa) > 0)
             <tbody>
                 <tr><td></td></tr>
                @foreach ($productosventa as $productoventa)
                  <?php $seguidorinterno=1;
                         
                   ?>
                @foreach($productos as $producto)
                @if($productoventa->id_producto==$producto->id)
                <tr>
                   <td align="center" class="table-text"><div>{{ $producto->nombre}}</div></td>
                   <td align="center" class="table-text"><div>{{ $productoventa->cantidad}}</div></td>
                   <td align="center" class="table-text"><div>$ {{ $producto->precio}}</div></td>
                    <td align="center" class="table-text"><div>$ {{ $productoventa->total}}</div></td>
             
            </tr>
            @endif
             <?php $seguidorinterno++; ?>
            @endforeach
            <?php $seguidorexterno++; ?>
            @endforeach
            @endif
        </tbody>
    </table>  
<h2>datos de envio</h2>
 <table>
                <thead>
                 <th align="center" style="padding:1px">Estado</th>
                 <th align="center" style="padding:1px">Ciudad</th>
                 <th align="center" style="padding:1px">Cp</th>
             </thead>
             <tbody>  <tr><td></td></tr>
                <tr>
                   <td align="center" class="table-text"><div>{{$domicilio->estado}}</div></td>
                   <td align="center" class="table-text"><div>{{$domicilio->ciudad}}</div></td>
                   <td align="center" class="table-text"><div>{{$domicilio->cp}}</div></td>
            </tr>
            </tbody>
            <p>Calle y colonia:{{$domicilio->calle_colonia}}</p>
</body>
</html>