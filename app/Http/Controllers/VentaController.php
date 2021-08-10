<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use redirect;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Role_user;
use App\User;
use App\Cliente;
use App\Domiciliocliente;
use App\Domicilio;
use App\Producto;
use App\Categoria;
use App\Comentario;
use App\Carritocliente;
use App\Tiendacarrito;
use App\Sucursale;
use App\Venta;
use App\Productoventa;
use App\Deuda;
use App\Ventacliente;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts;
use Illuminate\View\Factory;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


public function vercarrito(){
$Productospush=collect();
$Sucursales=Sucursale::get();
$id_usuario=Auth::User()->id;
$carritocheck=Carritocliente::where('id_usuario',$id_usuario)->first();
if($carritocheck==null){
$Carroclientenuevo=Carritocliente::create([
'id'=>null,
'id_usuario'=>$id_usuario,
'total'=>"0",
'iva'=>"0"]);  
}
$carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$Productocarritos=Tiendacarrito::where('id_carrito',$carrito->id)->get();
foreach ($Productocarritos as $productocarrito) {
$Producto=Producto::findOrFail($productocarrito->id_producto);
$Productospush->push($Producto);
}
$Productos=$Productospush->values();
$Lista_productos=$Productos->all();
return view('compra',['carrito'=>$carrito,'productocarritos'=>$Productocarritos,'productos'=>$Lista_productos,'sucursales'=>$Sucursales]);

}

public function abonartienda(Request $request,$id){
$venta=Venta::findOrFail($id);
$deuda=Deuda::where('id_venta',$venta->id)->first();
$productosventa=Productoventa::where('id_venta',$venta->id)->get();
$productos=Producto::get();
return view('abono',['venta'=>$venta,'deuda'=>$deuda,'productosventa'=>$productosventa,'productos'=>$productos]);

}

public function abonarcliente(Request $request,$id){
$venta=Venta::findOrFail($id);
$deuda=Deuda::where('id_venta',$venta->id)->first();
$productosventa=Productoventa::where('id_venta',$venta->id)->get();
$productos=Producto::get();
return view('cliente.abonocliente',['venta'=>$venta,'deuda'=>$deuda,'productosventa'=>$productosventa,'productos'=>$productos]);
}
public function pagarabonotienda(Request $request,$id){
$venta=Venta::findOrFail($id);
$validator=Validator::make($request->all(),[
'meses'=>['integer']]);
$deuda=Deuda::where('id_venta',$venta->id)->first();
$abono=round($deuda->deuda_actual/$deuda->meses)*$request->meses;
$abonoaregistrar=(int)$deuda->abono+(int)$abono;
$mesestotales=(int)$deuda->meses_pagados+(int)$request->meses;
if(((int)$deuda->meses-(int)$mesestotales)<=0){
$deudasaldada=Deuda::where('id_venta',$venta->id)->first();
$deudasaldada->meses_pagados=$deuda->meses;
$deudasaldada->abono=$deuda->deuda_actual;
$deudasaldada->estado="2";
$deudasaldada->update();
}else{
$deudaspendiente=Deuda::where('id_venta',$venta->id)->first();
$deudaspendiente->meses_pagados=$mesestotales;
$deudaspendiente->abono=$abonoaregistrar;
$deudaspendiente->estado="0";
$deudaspendiente->update();
}
return redirect('/gestion_pagos');
}

public function pagarabonocliente(Request $request,$id){
$venta=Venta::findOrFail($id);
$validator=Validator::make($request->all(),[
'meses'=>['integer']]);
$deuda=Deuda::where('id_venta',$venta->id)->first();
$abono=round($deuda->deuda_actual/$deuda->meses)*$request->meses;
$abonoaregistrar=(int)$deuda->abono+(int)$abono;
$mesestotales=(int)$deuda->meses_pagados+(int)$request->meses;
if(((int)$deuda->meses-(int)$mesestotales)<=0){
$deudasaldada=Deuda::where('id_venta',$venta->id)->first();
$deudasaldada->meses_pagados=$deuda->meses;
$deudasaldada->abono=$deuda->deuda_actual;
$deudasaldada->estado="2";
$deudasaldada->update();
}else{
$deudaspendiente=Deuda::where('id_venta',$venta->id)->first();
$deudaspendiente->meses_pagados=$mesestotales;
$deudaspendiente->abono=$abonoaregistrar;
$deudaspendiente->estado="0";
$deudaspendiente->update();
}
return redirect('/pagos_cliente');
}

public function vaciarcarrito(){
$id_usuario=Auth::User()->id;
$carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$productos=Tiendacarrito::where('id_carrito',$carrito->id)->delete();
$carrito=Carritocliente::where('id_usuario',$id_usuario)->delete();
return redirect('/carrito');
}

public function createventa(Request $request){
$validator=Validator::make($request->all(),[
'sucursal'=>['max:3'],
'calle'=>['string','max:50'],
'cp'=>['string','max:6'],
'ciudad'=>['string','max:50'],
'estado'=>['string','max:50'],
]); 
 if ($validator->fails()){
        return redirect('/compra')->withInput()->withErrors($validator);
       }
$entrega=0;
$fecha=date('Y-m-d');
$hora=date('H:i');
$id_usuario=Auth::User()->id;
$carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$validarsucursal=$request->sucursal;
$calle=$request->calle;
$cp=$request->cp;
$ciudad=$request->ciudad;
$estado=$request->estado;
if($validarsucursal!=null){
$entrega=2;
}
//Venta
$venta=Venta::create([
'id'=>null,
'importe'=>$carrito->total,
'iva'=>$carrito->iva,
'total'=>$carrito->total+$carrito->iva,
'fecha'=>$fecha,
'hora'=>$hora,
'entrega'=>$entrega,
]);
$absoluto=$carrito->total+$carrito->iva;
$id_venta =Venta::where('importe',$carrito->total)->first();

//Domicilio
if($validarsucursal!=null){
$sucursal=Sucursale::findOrFail($validarsucursal)->first();
$calle=$sucursal->calle_colonia;
$cp=$sucursal->cp;
$ciudad=$sucursal->ciudad;
$estado=$sucursal->estado;
}
$nuevodomicilio=Domicilio::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'calle_colonia'=>$calle,
'cp'=>$cp,
'ciudad'=>$ciudad,
'estado'=>$estado,
]);
//Productos venta
$productoscarrito=Tiendacarrito::where('id_carrito',$carrito->id)->get();
if($productoscarrito!=null){
foreach ($productoscarrito as $Producto) {
$productoventa=Productoventa::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'id_producto'=>$Producto->id_producto,
'cantidad'=>$Producto->cantidad,
'total'=>$Producto->costo,
]);
}
$cantidadproducto=Producto::findOrFail($Producto->id_producto);
$cantidadproducto->unidades=$cantidadproducto->unidades-$Producto->cantidad;
$cantidadproducto->update();
}
$productoscarrito=Tiendacarrito::where('id_carrito',$carrito->id)->delete();

//Deuda
$Deuda=Deuda::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'meses'=>"0",
'meses_pagados'=>"0",
'abono'=>$carrito->total+$carrito->iva,
'deuda_actual'=>$carrito->total+$carrito->iva,
'estado'=>"2",
]);
$carritoeliminar=Carritocliente::where('id_usuario',$id_usuario)->delete();
return redirect('/tienda/todos');
}

public function createventacliente(Request $request){
$validator=Validator::make($request->all(),[
'mensualidad'=>['required'],
'calle'=>['required','string','max:50'],
'cp'=>['required','string','max:6'],
'ciudad'=>['required','string','max:50'],
'estado'=>['required','string','max:50'],
]); 
 if ($validator->fails()){
        return redirect('/compra')->withInput()->withErrors($validator);
       }
$fecha=date('Y-m-d');
$hora=date('H:i');
$id_usuario=Auth::User()->id;
$cliente=Cliente::where('id_usuario',$id_usuario)->first();
$carrito=Carritocliente::where('id_usuario',$id_usuario)->first();

//Venta
$venta=Venta::create([
'id'=>null,
'importe'=>$carrito->total,
'iva'=>$carrito->iva,
'total'=>$carrito->total+$carrito->iva,
'fecha'=>$fecha,
'hora'=>$hora,
'entrega'=>"0",
]);
$absoluto=$carrito->total+$carrito->iva;
$id_venta =Venta::where('importe',$carrito->total)->first();
$ventacliente=Ventacliente::create([
'id'=>null,
'id_cliente'=>$cliente->id,
'id_venta'=>$id_venta->id,
]);
//Domicilio
$nuevodomicilio=Domicilio::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'calle_colonia'=>$request->calle,
'cp'=>$request->cp,
'ciudad'=>$request->ciudad,
'estado'=>$request->estado,
]);
//Productos venta
$productoscarrito=Tiendacarrito::where('id_carrito',$carrito->id)->get();
if($productoscarrito!=null){
foreach ($productoscarrito as $Producto) {
$productoventa=Productoventa::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'id_producto'=>$Producto->id_producto,
'cantidad'=>$Producto->cantidad,
'total'=>$Producto->costo,
]);
$cantidadproducto=Producto::findOrFail($Producto->id_producto);
$cantidadproducto->unidades=$cantidadproducto->unidades-$Producto->cantidad;
$cantidadproducto->update();
}}
$productoscarrito=Tiendacarrito::where('id_carrito',$carrito->id)->delete();

//Deuda
if((int)$request->mensualidad==0){
$Deuda=Deuda::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'meses'=>"0",
'meses_pagados'=>"0",
'abono'=>$carrito->total+$carrito->iva,
'deuda_actual'=>$carrito->total+$carrito->iva,
'estado'=>"2",
]);
}else{
$Deuda=Deuda::create([
'id'=>null,
'id_venta'=>$id_venta->id,
'meses'=>$request->mensualidad,
'meses_pagados'=>"0",
'abono'=>"0",
'deuda_actual'=>$carrito->total+$carrito->iva,
'estado'=>"0",
]);	
}

$carritoeliminar=Carritocliente::where('id_usuario',$id_usuario)->delete();
return redirect('/tienda/todos');
}



public function vercarritocliente(){
$Productospush=collect();
$id_usuario=Auth::User()->id;
$cliente=Cliente::where('id_usuario',$id_usuario)->first();
$Domiciliocliente=Domiciliocliente::where('id_cliente',$cliente->id)->first();
$carritocheck=Carritocliente::where('id_usuario',$id_usuario)->first();
if($carritocheck==null){
$Carroclientenuevo=Carritocliente::create([
'id'=>null,
'id_usuario'=>$id_usuario,
'total'=>"0",
'iva'=>"0"]);  
}
$carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$Productocarritos=Tiendacarrito::where('id_carrito',$carrito->id)->get();
foreach ($Productocarritos as $productocarrito) {
$Producto=Producto::findOrFail($productocarrito->id_producto);
$Productospush->push($Producto);
}

$Productos=$Productospush->values();
$Lista_productos=$Productos->all();
return view('cliente.compraonline',['carrito'=>$carrito,'productocarritos'=>$Productocarritos,'productos'=>$Lista_productos,'domiciliocliente'=>$Domiciliocliente]);

}
 public function pagos(){
   $Ventaclientes=Ventacliente::get();
  $ventas=Venta::get();
  $Deudas=Deuda::where('estado',"0")->get();
  return view('gestionpagos',['ventas'=>$ventas,'deudas'=>$Deudas]);
 }

public function pagoscliente(){
  $id_usuario=Auth::User()->id;
$cliente=Cliente::where('id_usuario',$id_usuario)->first();
$Deudas=Deuda::where('estado',"0")->get();
$Ventasclientepush=collect();
$Ventascliente=Ventacliente::where('id_cliente',$cliente->id)->get();
foreach ($Ventascliente as $ventacliente) {
$ventanormal=Venta::findOrFail($ventacliente->id_venta);
$Ventasclientepush->push($ventanormal);
}
$ventasclientenormal=$Ventasclientepush->values();
$ventas=$ventasclientenormal->all();
return view('cliente.gestionpagoscliente',['ventas'=>$ventas,'deudas'=>$Deudas]);
}

 public function gestionventas(Request $request,$tipo){
  $Ventaclientes=Ventacliente::get();
  $ventas=Venta::get();
  $Deudas=null;
  if($tipo==="0"){
  $Deudas=Deuda::where('estado',"0")->get();
  }else if($tipo==="2"){
  $Deudas=Deuda::where('estado',"2")->get();
  }else{
  	 $Deudas=Deuda::get();
  }
////// Grafica de ventas
    $lava = new Lavacharts;
    $reasons = $lava->DataTable();
    $Pagados = Deuda::where('estado','2')->count();
    $Pendientes = Deuda::where('estado','0')->count();
    $reasons->addStringColumn('Reasons')
            ->addNumberColumn('Percent')
            ->addRow(array('Pagados',(int)$Pagados))
            ->addRow(array('Pendientes',(int)$Pendientes));
    $donutchart = $lava->DonutChart('IMDB', $reasons, [
                    'title' => 'GRAFICA VENTAS'
                ]);

 /////vista 
  return view('gestionventas',['ventas'=>$ventas,'deudas'=>$Deudas,'tipo'=>$tipo,'lava'=> $lava]);
 }
 
 public function pdfventas(Request $request,$tipo){
 	$Ventaclientes=Ventacliente::get();
  $ventas=Venta::get();
  $Deudas=null;
  if($tipo==="0"){
  $Deudas=Deuda::where('estado',"0")->get();
  }else if($tipo==="2"){
  $Deudas=Deuda::where('estado',"2")->get();
  }else{
  	 $Deudas=Deuda::get();
  }
    $pdf = \PDF::loadView('pdfventas',['ventas'=>$ventas,'deudas'=>$Deudas,'tipo'=>$tipo]);
      return  $pdf->download('ventas.pdf');
 }

 public function detalleventa(Request $request,$id){
 $venta=Venta::findOrFail($id);
 $ventacliente=Ventacliente::where('id_venta',$id)->first();
 $deuda=Deuda::where('id_venta',$id)->first();
 $productosventa=Productoventa::where('id_venta',$id)->get();
 $productos=Producto::get();
 $cliente=null;
 $domicilio=Domicilio::where('id_venta',$id)->first();
 if($ventacliente!=null){
 $cliente=Cliente::findOrFail($ventacliente->id_cliente);
 }
  $pdf = \PDF::loadView('pdfmortizacion',['venta'=>$venta,'deuda'=>$deuda,'cliente'=>$cliente,'productosventa'=>$productosventa,'productos'=>$productos,'domicilio'=>$domicilio]);
      return  $pdf->download('tablademortizacion.pdf');
 }

public function mainenvios(Request $request,$tipo){
$envios=null;
$domicilios=Domicilio::get();
if((int)$tipo>=3){
$envios=Venta::get();
}else{
$envios=Venta::where('entrega',$tipo)->get();  
}
return view('gestionenvios',['envios'=>$envios,'domicilios'=>$domicilios,'tipo'=>$tipo]);
}

public function updateenvio(Request $request,$id,$estado){
 $envio=Venta::findOrFail($id);
 $envio->entrega=$estado;
 $envio->update();
 return redirect('/gestion_envios/3'); 
}

}