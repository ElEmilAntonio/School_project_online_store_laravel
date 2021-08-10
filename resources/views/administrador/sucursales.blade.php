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

<div class="container">
     <button type="submit" class="btn btn-primary" onclick="location.href='/agregar_sucursal'" method="GET">
                        <i class="fa fa-btn fa-person"></i> Agregar Sucursal
                    </button>
                    <br>
    <div class="row justify-content-left">
     
       <div class="panel panel-default">
    <div class="panel-heading">
      Sucursales
    </div>
    <div class="panel-body">
        <table class="table table-striped ">
            <thead>
             <th style="padding:1px">Calle y colonia</th>
             <th style="padding:1px">C.P.</th>
             <th style="padding:1px">Ciudad</th>
            <th style="padding:1px">Estado</th>
            <th style="padding:1px"></th>
             <th style="padding:1px"></th>
         </thead>
         @if (count($sucursales) > 0)
         <tbody>
            @foreach ($sucursales as $sucursal)
            <tr>
                <td class="table-text" style="padding:1px"><div>{{ $sucursal->calle_colonia}}</div></td>
                <td class="table-text" style="padding:1px"><div>{{ $sucursal->cp}}</div></td>
                 <td class="table-text" style="padding:1px"><div>{{ $sucursal->ciudad}}</div></td>
                  <td class="table-text" style="padding:1px"><div>{{ $sucursal->estado}}</div></td>
            <td style="padding:1px">
                    <button type="submit" class="btn btn-primary btn-sm" onclick="location.href='/editar_sucursal/{{$sucursal->id}}'" method="POST">
                        <i class="fa fa-btn fa-pencil"></i> Editar
                    </button>
            </td>
            <td style="padding:1px">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/eliminar_sucursal/{{$sucursal->id}}'" method="GET">
                        <i class="fa fa-btn fa-trash"></i> Eliminar
                    </button>
              
            </td>
        </tr>
        @endforeach
    </tbody>
@endif
</table>

 
    </div>
</div>



@endsection
