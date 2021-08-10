
<!DOCTYPE html>
<html>

<head>
	<style>
table, th{
  border: 1px solid black;
}
</style>
  <title>Productos de la muebleria</title>
</head>
<body>

<h2 align="center">Conteo de productos</h2>
            <table>
                <thead>
                   <th align="center" style="padding:1px">id</th>
                 <th align="center" style="padding:1px">Nombre</th>
                 <th align="center" style="padding:1px">Cantidad</th>
                   <th align="center" style="padding:1px">Categoria</th>
                 <th align="center" style="padding:1px">Precio</th>
             </thead>
             @if(count($productos) > 0)
             <tbody>
                 <tr><td></td></tr>
                @foreach ($productos as $producto)
                @foreach($categorias as $categoria)
                @if($producto->id_categoria==$categoria->id)
                <tr>
                       <td align="center" class="table-text"><div>{{ $producto->id}}</div></td>
                   <td align="center" class="table-text"><div>{{ $producto->nombre}}</div></td>
                   <td align="center" class="table-text"><div>{{ $producto->unidades}}</div></td>
                   <td align="center" class="table-text"><div>$ {{ $categoria->nombre}}</div></td>
                   <td align="center" class="table-text"><div>$ {{ $producto->precio}}</div></td>

            </tr>
            @endif
            @endforeach
            @endforeach
        </tbody>
    </table>
    @endif
     
</body>
</html>