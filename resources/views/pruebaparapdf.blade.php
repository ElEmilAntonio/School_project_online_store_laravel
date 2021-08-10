
<!DOCTYPE html>
<html>

<head>
	<style>
table, th{
  border: 1px solid black;
}
</style>
  <title>Carrito de compra</title>
</head>
<body>
<h1 align="center">MUEBLERIA RS </h1>
<h2 align="center">Que tu casa sea tan comoda como tus sueños</h2>
  <h3>Carrito de compra</h3>
<?php  $seguidorexterno=1;?>
            <table>
                <thead>
                
                 <th align="center" style="padding:1px">Nombre</th>
                 <th align="center" style="padding:1px">Cantidad</th>
                 <th align="center" style="padding:1px">Precio</th>
                  <th align="center" style="padding:1px">Total</th>
             </thead>
             @if(count($productocarritos) > 0)
             <tbody>
                 <tr><td></td></tr>
                @foreach ($productocarritos as $productocarrito)
                  <?php $seguidorinterno=1;
                         
                   ?>
                @foreach($productos as $producto)
                @if($seguidorinterno==$seguidorexterno)
                <tr>
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
        </tbody>
    </table>
    @endif
     <?php 
        $costototal=$carrito->total+$carrito->iva;
         ?>
   <H3>COSTO: $ {{$carrito->total}} + IVA:$ {{$carrito->iva}} TOTAL: $ {{$costototal}}</H3>
   <p></p>
   <p>CONDICIONES GENERALES DE LA Muebleria Rs

A continuación se describen los términos y condiciones de compra que aplican a la adquisición de productos de la Muebleria Rs
Si deseas información sobre los productos que comercializamos y sus precios, nuestro sitio web https://muebleriaonliners.000webhostapp.com/ está disponible las 24 horas del día.

Todos los precios mostrados en nuestro sitio web se encuentran en pesos mexicanos y están sujetos a cambios sin previo aviso.

Las imágenes son ilustrativas y pueden variar o cambiar sin previo aviso.

La disponibilidad mostrada en cada uno de los productos se encuentra al día.

La lista de productos mostrados en el sitio web está sujeta a cambios sin previo aviso.

La tienda no acepta devoluciones ni cambios.

</p>
</body>
</html>