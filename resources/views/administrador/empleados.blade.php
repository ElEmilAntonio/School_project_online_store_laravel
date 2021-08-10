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
     <button type="submit" class="btn btn-primary" onclick="location.href='/agregar_empleado'" method="GET">
                        <i class="fa fa-btn fa-person"></i> Agregar Empleado
                    </button>
    <div class="row justify-content-left">
     
       <div class="panel panel-default">
    <div class="panel-heading">
      Empleados
    </div>
    <div class="panel-body">
        <table class="table table-striped ">
            <thead>
             <th style="padding:1px">Nombre</th>
             <th style="padding:1px">Correo</th>
             <th style="padding:1px"></th>
         </thead>
         @if (count($empleados) > 0)
         <tbody>
            @foreach ($empleados as $empleado)
            <tr>
                <td class="table-text" style="padding:1px"><div>{{ $empleado->name}}</div></td>
                <td class="table-text" style="padding:1px"><div>{{ $empleado->email}}</div></td>
            <td style="padding:1px">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/eliminar_empleado/{{$empleado->id}}'" method="GET">
                        <i class="fa fa-btn fa-trash"></i> Eliminar
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
