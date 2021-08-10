<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Role_user;
use App\User;
use App\Categoria;
use App\Producto;
use App\Productoventa;
use App\Deuda;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts;
use Illuminate\View\Factory;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {
    $Categorias=Categoria::get();
    $ver=null;
    $Categoriaedit=null;
    return view('administrador.categorias',['categorias'=>$Categorias,'ver'=>$ver,'categoriaedit'=>$Categoriaedit]);
    }

     public function createcategoria(Request $request){
       $Validator = Validator::make($request->all(),[
        'nombre'=>['required','string','max:50']
        ]);
      if ($Validator->fails()){
        return redirect('/categorias')->withInput()->withErrors($Validator);
       }
       $Categoria=Categoria::create([
    'id'=>null,
    'nombre'=>$request->nombre,
 ]); 
        return redirect('/categorias');
     }

    public function editcategoria(Request $request,$id){
     $Categoriaedit=Categoria::where('id',$id)->first();
      $Categorias=Categoria::get();
       $ver=1;
     return view('administrador.categorias',['categorias'=>$Categorias,'ver'=>$ver,'categoriaedit'=>$Categoriaedit]);
    }

    public function updatecategoria(Request $request,$id){
       $Validator = Validator::make($request->all(),[
        'nombre'=>['required','string','max:50']
        ]);
       if ($Validator->fails()){
        return redirect('/categorias')->withInput()->withErrors($Validator);
       }
       $Categoria=Categoria::findOrFail($id);
       $Categoria->Nombre=$request->nombre;
       $Categoria->update();
       return redirect('/categorias');
    }

    public function destroycategoria(Request $request,$id){
     $categoria=Categoria::findOrFail($id)->delete();
     $Productos=Producto::where('id_categoria',$id)->get();
      $indefinido=12;
      foreach ($Productos as $producto) {
       $producto->id_categoria=$indefinido;
     $producto->update();
     }
    
    
  return redirect('/categorias');
    }  

    public function mainproducto(Request $request, $categoria){
      $checkcategoria=Categoria::where('nombre',$categoria)->first();
      if($checkcategoria!=null){
      $Productos=Producto::where('id_categoria',$checkcategoria->id)->where('estado',"0")->get();
      }else{
       if($categoria==="todo"){
         $Productos=Producto::where('estado',"0")->get();
      }else{ 
      return redirect('/productos/todo');
    }
      }
      /// Grafica de ventas de productos
 $lavacategoria = new Lavacharts;
    $reasons2 = $lavacategoria->DataTable();
    $reasons2->addStringColumn('Reasons')
            ->addNumberColumn('Percent');
    $categorias=Categoria::get();
     foreach ($categorias as $categoria) {
     $cantidadvendidos=0;
     $productosventa=Productoventa::get();
     foreach ($productosventa as $productoventa) {
      $producto=producto::where('id',$productoventa->id_producto)->first();
      if($producto->id_categoria==$categoria->id){
      $cantidadvendidos+=(int)$productoventa->cantidad;
      }
      } 
    $reasons2->addRow(array($categoria->nombre,(int)$cantidadvendidos));
    }
           
    $donutchart = $lavacategoria->DonutChart('IMDB2', $reasons2, [
                    'title' => 'GRAFICA VENTA POR CATEGORIA'
                ]);

      return view('administrador.productos',['productos'=>$Productos,'lavacategoria'=>$lavacategoria]);
     }

    

    public function agregarproducto(){
    $Categorias=Categoria::all();
    return view('administrador.agregarproducto',['categorias'=>$Categorias]);
    }

    public function createproducto(Request $request){
   $filename=null;
    $validator =Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:50'],
            'unidades'=>['required','string','max:100'],
            'id_categoria'=>['required'],
            'precio'=>['required','numeric','min:0'],
            'imagen'=>['required','file','mimes:jpeg,jpg,png,webp'],
            'descripcion'=>['required','string','max:255'],
        ]); 
        if($validator->fails()){
          return redirect('/agregar_producto')->withInput()->withErrors($validator);
        }
        if(File::exists($request->imagen)){
$path ='/images/';
$uploadedFile =$request->imagen;
$filename = time().$request->nombre.$uploadedFile->getClientOriginalName();
Storage::disk('local')->putFileAs($path,$uploadedFile,$filename);
}
     $Producto=Producto::create([
      'id'=>null,
     'nombre'=>$request->nombre,
     'unidades'=>$request->unidades,
     'id_categoria'=>$request->id_categoria,
     'precio'=>$request->precio,
     'imagen'=>$filename,
     'descripcion'=>$request->descripcion,
      'estado'=>"0",
     ]);
     return redirect('/productos/todo');
    }

    public function editproducto(Request $request,$id){
    $Producto=Producto::findOrFail($id);
    $Categorias=Categoria::get();
    return view('administrador.editarproducto',['producto'=>$Producto,'categorias'=>$Categorias]);
    }

    public function updateproducto(Request $request,$id){
     $filename=null;
     $verificadorproducto=Producto::findOrFail($id);
    $validator =Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:50'],
            'unidades'=>['required','string','max:100'],
            'id_categoria'=>['required'],
            'precio'=>['required','numeric','min:0'],
            'imagen'=>['file','mimes:jpeg,jpg,png,webp'],
            'descripcion'=>['required','string','max:255'],
        ]); 
        if($validator->fails()){
          return redirect('/editar_producto/'.$id)->withInput()->withErrors($validator);
        }
    $Producto=Producto::findOrFail($id);
    $Producto->nombre=$request->nombre;
    $Producto->unidades=$request->unidades;
    $Producto->id_categoria=$request->id_categoria;
    $Producto->precio=$request->precio;
        if(File::exists($request->imagen)){
          $path ='/images';
$file=$path.'/'.$verificadorproducto->imagen;
$this->eliminararchivo($file);
$uploadedFile =$request->imagen;
$filename = time().$request->nombre.$uploadedFile->getClientOriginalName();
Storage::disk('local')->putFileAs($path,$uploadedFile,$filename);
$Producto->imagen=$filename;
    }
    $Producto->descripcion=$request->descripcion;
    $Producto->update();
    return redirect('/productos/todo');
  }

    public function destroyproducto(Request $request,$id){
     $producto=Producto::findOrFail($id);
     $producto->estado="1";
     $producto->update();
     return redirect('/productos/todo');
    }

      public function eliminararchivo($file){
return File::delete($file);
}

public function pdfproductos(){

$Producto=Producto::where('estado',"0")->get();
$Categorias=Categoria::get();
        $pdf = \PDF::loadView('pdfproducto',['productos'=>$Producto,'categorias'=>$Categorias]);
      return  $pdf->download('productos.pdf');

 
}

}
