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
    <div class="container">
        <div class="row justify-content-left">
         
           <div class="panel panel-default">
        <div class="panel-heading">
          Carrito
        </div>
        <div class="panel-body">
             @if(count($productocarritos) > 0)
             <?php $vervacio++; ?>
             @endif
             @if($vervacio>0)
            <table class="table table-striped ">
                <thead>
                 <th align="center" style="padding:1px">Imagen</th>
                 <th align="center" style="padding:1px">Nombre</th>
                 <th align="center" style="padding:1px">Cantidad</th>
                 <th align="center" style="padding:1px">Precio</th>
                  <th align="center" style="padding:1px">Total</th>
                 <th></th>
             </thead>
             @if(count($productocarritos) > 0)
             <?php $vervacio++; ?>
             <tbody>
                @foreach ($productocarritos as $productocarrito)
                  <?php $seguidorinterno=1; ?>
                @foreach($productos as $producto)
                @if($seguidorinterno==$seguidorexterno)
                <tr>
                    <td><div> <img type="image" src="/images/{{$producto->imagen}}" alt="Foto de perfil"  style="height:120px;width:120px;">   </div></td> 
                   <td align="center" class="table-text"><div>{{ $producto->nombre}}</div></td>
                   <td align="center" class="table-text"><div>{{ $productocarrito->cantidad}}</div></td>
                   <td align="center" class="table-text"><div>$ {{ $producto->precio}}</div></td>
                    <td align="center" class="table-text"><div>$ {{ $productocarrito->costo}}</div></td>
                       <td>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/eliminar_producto_carrito/{{$productocarrito->id}}'" method="GET">
                            <i class="fa fa-btn fa-trash"></i> Eliminar del carrito
                        </button>
                </td>
              
            </tr>
            @endif
             <?php $seguidorinterno++; ?>
            @endforeach
            <?php $seguidorexterno++; ?>
            @endforeach
        </tbody>
    </table>
    @endif
    @endif
        <?php 
        $costototal=$carrito->total+$carrito->iva;
         ?>
         @if($vervacio>0)
         @if($sicliente==1)
         <p><H3>COSTO: $ {{$carrito->total}} + IVA:$ {{$carrito->iva}} TOTAL: $ {{$costototal}}</H3></p>
         <?php $presupuesto=$cliente->salario*10 ?>
         <p><H4>HOLA {{$cliente->nombres}} su presupuesto es de {{$presupuesto}} y tiene un acumulado de compra de ${{$total}}</H4></p>
         <?php $restodecompra=$presupuesto-$total ?>
          <p><H4>con un presupuesto actual de compra de: ${{$restodecompra}}</H4></p>
          @if(($restodecompra-$costototal)>0)
          <?php
            $restantefinal=$restodecompra-$costototal
           ?>
           <p><H4>con la compra actual su presupuesto seria de :${{$restantefinal}}</H4></p>
            <button type="submit" class="btn btn-danger" onclick="location.href='/vaciar_carrito'" method="GET">
                            <i class="fa fa-btn fa-trash"></i> Vaciar Carrito
                        </button>
                         <button type="submit" class="btn btn-primary" onclick="location.href='/compra_online'" method="GET">Comprar
                        </button>
                          <button type="submit" class="btn btn-primary" onclick="location.href='/pdf_carrito'" method="GET">
                            <i class="fa fa-btn fa-file"></i> Generar PDF
                        </button>
          @else
          <p><H4>Lo sentimos con el carrito de compra superaria su presupuesto para hacer compras en la tienda</H4></p>
            <button type="submit" class="btn btn-danger" onclick="location.href='/vaciar_carrito'" method="GET">
                            <i class="fa fa-btn fa-trash"></i> Vaciar Carrito
                        </button>
                        
          @endif
     
         @endif
           @if($sicliente==0)
         <p><H3>COSTO: $ {{$carrito->total}} + IVA:$ {{$carrito->iva}} TOTAL: $ {{$costototal}}</H3></p>
       <button class="btn btn-danger" onclick="location.href='/vaciar_carrito'" method="GET">
                            <i class="fa fa-btn fa-trash"></i> Vaciar Carrito
                        </button>
                         <button type="submit" class="btn btn-primary" onclick="location.href='/compra'" method="GET">Comprar
                        </button>

                         <button type="submit" class="btn btn-primary" onclick="location.href='/pdf_carrito'" method="GET">
                            <i class="fa fa-btn fa-file"></i> Generar PDF
                        </button>
         @endif
       
        @endif
           @if($vervacio==0)
           <p><H2>NO HAS ESCOGIDO NINGUN PRODUCTO VE Y ESCOGE ALGO</H2></p>
           @endif
        </div>
    </div>



    @endsection
