@extends('layouts.appcliente')

@section('content')
<ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <tr>
              <td>
                 <div class="card">
                    <div class="card-header">{{ __('Datos Usuario') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('Editar_cliente_guardado')}}/{{$usuario->id}}" enctype="multipart/form-data">
                            @csrf
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <!--ID-->
                            <div class="form-group row" style="display: none;">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$usuario->id}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                             
                             <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombres') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$cliente->nombres}}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>

                            <div class="col-md-6">
                                <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{$cliente->apellidos}}" required autocomplete="apellidos" autofocus>

                                @error('apellidos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                      

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Edad') }}</label>

                            <div class="col-md-6">
                                <input id="edad" type="number" min="18" step="1" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{$cliente->edad}}" required autocomplete="edad" autofocus>

                                @error('edad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                          <div class="form-group row">
          <label for="Aplicaciones" class="col-md-4 col-form-label text-md-right">{{ __('Sexo:') }}</label>
          <div class="col-md-6">
            @if($cliente->Sexo==0)
            <input type="radio" id="sexo" name="sexo" value="0" checked>    Hombre     
           <input type="radio" id="sexo" name="sexo" value="1">    Mujer  
            @endif
            @if($cliente->Sexo==1)
            <input type="radio" id="sexo" name="sexo" value="0">    Hombre     
           <input type="radio" id="sexo" name="sexo" value="1" checked>    Mujer  
            @endif
           
           @error('Sexo')
           <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>           
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Calle y colonia') }}</label>

                            <div class="col-md-6">
                                <input id="calle" type="text" class="form-control @error('calle') is-invalid @enderror" name="calle" value="{{$domicilio->calle_colonia}}" required autocomplete="calle" autofocus>

                                @error('calle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('CP') }}</label>

                            <div class="col-md-6">
                                <input id="cp" type="number" class="form-control @error('cp') is-invalid @enderror" name="cp" value="{{$domicilio->cp}}" required autocomplete="cp" autofocus>

                                @error('cp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                            <div class="col-md-6">
                                <input id="ciudad" type="text" class="form-control @error('ciudad') is-invalid @enderror" name="ciudad" value="{{$domicilio->ciudad}}" required autocomplete="ciudad" autofocus>

                                @error('ciudad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <input id="estado" type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{$domicilio->estado}}" required autocomplete="estado" autofocus>

                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Salario (mensual Mx)') }}</label>

                            <div class="col-md-6">
                                <input id="salario" type="number" class="form-control @error('salario') is-invalid @enderror" name="salario" value="{{$cliente->salario}}" required autocomplete="salario">

                                @error('salario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                         
                          <div class="form-group row" style="display:none">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('tipo')}}</label>

                            <div class="col-md-6">
                                <input id="tipo" type="number" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="3" required autocomplete="tipo">

                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="foto" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                <input id="foto" type="file" class="form-control-file" name="foto"></input> 

                                @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-0 offset-md-4">

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Guardar Cambios') }}
                                    </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
