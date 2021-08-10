@extends('layouts.appadministrador')

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
<div id="chart-divcategorias">

      </div>
        {!! $lavacategoria->render('DonutChart', 'IMDB2', 'chart-divcategorias') !!}
<div class="container">
     <button type="submit" class="btn btn-primary" onclick="location.href='/agregar_producto'" method="GET">
                        <i class="fa fa-btn fa-box"></i> Agregar Producto
                    </button>
     <button type="submit" class="btn btn-primary" onclick="location.href='/pdf_productos'" method="GET">
                        <i class="fa fa-btn fa-box"></i> Generar pdf
                    </button>
                    <br>
    <div class="row justify-content-left">
     
       <div class="panel panel-default">
    <div class="panel-heading">
      Productos
    </div>
    <div class="panel-body">
        <table class="table table-striped ">
            <thead>
             <th align="center" style="padding:1px">Imagen</th>
             <th align="center" style="padding:1px">Nombre</th>
             <th align="center" style="padding:1px">Cantidad</th>
             <th align="center" style="padding:1px">Precio</th>
             <th></th>
             <th></th>

         </thead>
         @if (count($productos) > 0)
         <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td><div> <img type="image" src="/images/{{$producto->imagen}}" alt="Foto de perfil"  style="height:120px;width:120px;">   </div></td> 
               <td align="center" class="table-text"><div>{{ $producto->nombre}}</div></td>
               <td align="center" class="table-text"><div>{{ $producto->unidades}}</div></td>
               <td align="center" class="table-text"><div>{{ $producto->precio}}</div></td>
                   <td>
                    <button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/eliminar_producto/{{$producto->id}}'" method="GET">
                        <i class="fa fa-btn fa-trash"></i> Descontinuar
                    </button>
            </td>
            <td>
                    <button type="submit" class="btn btn-primary btn-sm" onclick="location.href='/editar_producto/{{$producto->id}}'" method="POST">
                        <i class="fa fa-btn fa-pencil"></i> Editar
                    </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
 
    </div>
</div>



@endsection
