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
use App\Producto;
use App\Categoria;
use App\Comentario;
use App\Carritocliente;
use App\Tiendacarrito;
use App\Ventacliente;
use App\Deuda;

class TiendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

public function main(Request $request, $categoria){
 $checkcategoria=Categoria::where('nombre',$categoria)->first();
      if($checkcategoria!=null){
      $Productos=Producto::where('id_categoria',$checkcategoria->id)->where('estado',"0")->get();
      }else{
       if($categoria==="todo"){
         $Productos=Producto::where('estado',"0")->get();
      }else{ 
      return redirect('/tienda/todo');
    }
      }
      
      return view('tienda',['productos'=>$Productos]);
}

public function verproducto(Request $request,$id){
 $Producto=Producto::findOrFail($id);
 $Categoria=Categoria::findOrFail($Producto->id_categoria);
 $Comentarios=Comentario::where('id_producto',$id)->get();
 return view('producto',['producto'=>$Producto,'comentarios'=>$Comentarios,]);
}

public function createcomentario(Request $request,$id){
$filename=null;
$id_usuario=Auth::User()->id;
$Producto=Producto::findOrFail($id);
$Validator = Validator::make($request->all(),[
        'comentario'=>['required','string','max:255'],
         'imagen'=>['file','mimes:jpeg,jpg,png,webp'],
        ]);
$path='/comentarios/';
$textodiv1='<div> <img type="image" src="/images/';
$textodiv2='" alt="Foto de comentario"  style="height:120px;width:120px;"></div>';
 if ($Validator->fails()){
        return redirect('/descripcion_producto/'.$id)->withInput()->withErrors($Validator);
       }
$comentariocompleto="";
if(File::exists($request->imagen)){
$pathimagen ='/images/';
$uploadedFile =$request->imagen;
$filename = time().'comentario'.$id_usuario.$uploadedFile->getClientOriginalName();
Storage::disk('local')->putFileAs($pathimagen,$uploadedFile,$filename);
$comentariocompleto=$textodiv1.$filename.$textodiv2." ".$request->comentario;
}else{
$comentariocompleto=$request->comentario;  
}
$filename = time().$id_usuario.$Producto->id."comentario.txt";
Storage::disk('local')->put($path.$filename,$comentariocompleto);
$comentario=Comentario::create([
'id'=>null,
'id_producto'=>$id,
'id_usuario'=>$id_usuario,
'comentario'=>$filename,
]);
return redirect('/descripcion_producto/'.$id);
}

public function descargararchivo(Request $Request,$ArchivoComentario){
$path =base_path('public/comentarios/');
$NombreArchivo = $ArchivoComentario;
$file=$path.'/'.$NombreArchivo;
$headers = array('Content-Type: application/pdf',);
return Response::download($file,$NombreArchivo,$headers);
}

public function agregarcarrito(Request $request,$id){
$id_usuario=Auth::User()->id;
$Producto=Producto::findOrFail($id);
$Validator=Validator::make($request->all(),['unidades'=>['required','integer']]);
if ($Validator->fails()){
        return redirect('/descripcion_producto/'.$id)->withInput()->withErrors($Validator);
       }
$Carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
if($Carrito==null){
$Carroclientenuevo=Carritocliente::create([
'id'=>null,
'id_usuario'=>$id_usuario,
'total'=>"0",
'iva'=>"0"]);
}
$idcarrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$Carritotienda=Tiendacarrito::create([
'id'=>null,
'id_carrito'=>$idcarrito->id,
'id_producto'=>$Producto->id,
'cantidad'=>$request->unidades,
'costo'=>$request->unidades*$Producto->precio,
]);
$total=0;
$carritoid=Carritocliente::where('id_usuario',$id_usuario)->first();
$totalproductos=Tiendacarrito::where('id_carrito',$carritoid->id)->get();
foreach ($totalproductos as $producto) {
$total+=$producto->costo;
}
$totaliva=$total*0.16;
$totalcarrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$totalcarrito->total=$total;
$totalcarrito->iva=$totaliva;
$totalcarrito->update();

return redirect('/tienda/todo');
}

public function vercarrito(){
$total=0;
$cliente=null;
$Productospush=collect();
$id_usuario=Auth::User()->id;
$cliente=Cliente::where('id_usuario',$id_usuario)->first();
if($cliente!=null){
$ventacliente=Ventacliente::where('id_cliente',$cliente->id)->get();
if($ventacliente!=null){
foreach ($ventacliente as $venta) {
$deuda=Deuda::where('id_venta',$venta->id_venta)->first();
if((int)$deuda->estado==0){
$total+=$deuda->deuda_actual;
}
}
}
}

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
return view('carrito',['carrito'=>$carrito,'productocarritos'=>$Productocarritos,'productos'=>$Lista_productos,'cliente'=>$cliente,'total'=>$total]);

}
public function destroyproductocarrito(Request $request,$id){
$id_usuario=Auth::User()->id;
$productocarrito=Tiendacarrito::findOrFail($id)->delete();
$total=0;
$carritoid=Carritocliente::where('id_usuario',$id_usuario)->first();
$totalproductos=Tiendacarrito::where('id_carrito',$carritoid->id)->get();
foreach ($totalproductos as $producto) {
$total+=$producto->costo;
}
$totaliva=$total*0.16;
$totalcarrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$totalcarrito->total=$total;
$totalcarrito->iva=$totaliva;
$totalcarrito->update();
return redirect('/carrito');

}

public function vaciarcarrito(){
$id_usuario=Auth::User()->id;
$carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$productos=Tiendacarrito::where('id_carrito',$carrito->id)->delete();
$carrito=Carritocliente::where('id_usuario',$id_usuario)->delete();
return redirect('/carrito');
}


public function pdfcarrito(){
  $Productospush=collect();
$id_usuario=Auth::User()->id;
$carritocheck=Carritocliente::where('id_usuario',$id_usuario)->first();
  $carrito=Carritocliente::where('id_usuario',$id_usuario)->first();
$Productocarritos=Tiendacarrito::where('id_carrito',$carrito->id)->get();
foreach ($Productocarritos as $productocarrito) {
$Producto=Producto::findOrFail($productocarrito->id_producto);
$Productospush->push($Producto);
}
$Productos=$Productospush->values();
$Lista_productos=$Productos->all();

        $pdf = \PDF::loadView('pruebaparapdf',['carrito'=>$carrito,'productocarritos'=>$Productocarritos,'productos'=>$Lista_productos]);
  
      return  $pdf->download('Carritodecompra.pdf');

 }


}
