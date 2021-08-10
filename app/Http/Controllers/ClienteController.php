<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Role_user;
use App\User;
use App\Cliente;
use App\Domiciliocliente;
use App\Venta;
use App\Productoventa;
use App\Deuda;
use App\Ventacliente;
use App\Domicilio;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function maincliente()
    {
    $id=Auth::User()->id;
    $Usuario=User::findOrFail($id);
    $Cliente=Cliente::where('id_usuario',$id)->first();
    return view('cliente.cliente',['cliente'=>$Cliente]);
    }

    public function edit(){
    $id=Auth::User()->id;
    $Usuario=User::findOrFail($id);
    $Cliente=Cliente::where('id_usuario',$id)->first();
    $Domicilio=Domiciliocliente::where('id_cliente',$Cliente->id)->first();
    return view('cliente.EditarCliente',['usuario'=>$Usuario,'cliente'=>$Cliente,'domicilio'=>$Domicilio]);
    }

    public function update(Request $request,$id){
    $verificadorcliente=Cliente::where('id_usuario',$id)->first();
    $validator =Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'apellidos'=>['required','string','max:100'],
            'edad'=>['required','integer','min:18','max:130'],
            'salario'=>['required','integer','min:0'],
            'sexo'=>['required','in:0,1'],
            'foto'=>['required','file','mimes:jpeg,jpg,png,webp'],
            'tipo'=>['required','integer'],
            'calle'=>['required','string','max:50'],
            'cp'=>['required','string','max:6'],
            'ciudad'=>['required','string','max:50'],
            'estado'=>['required','string','max:50'],
        ]); 
        if($validator->fails()){
        	return redirect('/Editar_cliente')->withInput()->withErrors($validator);
        }
        $Usuario=User::findOrFail($id);
        $Usuario->name=$request->name;
        $Usuario->update();
             
        if(File::exists($foto=$request->foto)){
              $pathborrar =base_path('public/images');
$file=$pathborrar.'/'.$verificadorcliente->Foto;
$this->eliminararchivo($file);
         $path ='/images/';
         $uploadedFile = $request->foto;
         $filename = time().$request->name.$uploadedFile->getClientOriginalName();
         Storage::disk('local')->putFileAs($path,$uploadedFile,$filename);
          }
        $Cliente=Cliente::where('id_usuario',$id)->first();
        $Cliente->Nombres=$request->name;
        $Cliente->Apellidos=$request->apellidos;
        $Cliente->Edad=$request->edad;
        $Cliente->Salario=$request->salario;
        $Cliente->Sexo=$request->sexo;
        $Cliente->Foto=$filename;
        $Cliente->update();
        $Domicilio=Domiciliocliente::where('id_cliente',$verificadorcliente->id)->first();
        $Domicilio->Calle_colonia=$request->calle;
        $Domicilio->Cp=$request->cp;
        $Domicilio->Ciudad=$request->ciudad;
        $Domicilio->Estado=$request->estado;
        $Domicilio->update();
        return redirect('inicio_cliente');
    }

    public function eliminararchivo($file){
return File::delete($file);
}
    public function gestionclientes(){
    $clientes=Cliente::get();
    $ventasclientes=Ventacliente::get();
    $deudasclientes=Deuda::where('estado',"0")->get();
    return view('administrador.gestionclientes',['clientes'=>$clientes,'ventasclientes'=>$ventasclientes,'deudas'=>$deudasclientes]);   
    }

  public function pdfclientes(){
  $clientes=Cliente::get();
    $ventasclientes=Ventacliente::get();
    $deudasclientes=Deuda::where('estado',"0")->get();
  $pdf = \PDF::loadView('pdfclientes',['clientes'=>$clientes,'ventasclientes'=>$ventasclientes,'deudas'=>$deudasclientes]);
      return  $pdf->download('clientes.pdf');
 }
 public function envioscliente(){
  $id=Auth::User()->id;
  $cliente=Cliente::where('id_usuario',$id)->first();
  $ventascliente=Ventacliente::where('id_cliente',$cliente->id)->get();
$domicilios=Domicilio::get();
$envios=Venta::get();  
return view('cliente.envioscliente',['ventascliente'=>$ventascliente,'envios'=>$envios,'domicilios'=>$domicilios]);
 }

 public function updateenvio(Request $request,$id,$estado){
 $envio=Venta::findOrFail($id);
 $envio->entrega=$estado;
 $envio->update();
 return redirect('/envios_cliente'); 
}

public function comprascliente(){
     $id=Auth::User()->id;
  $cliente=Cliente::where('id_usuario',$id)->first();
  $ventascliente=Ventacliente::where('id_cliente',$cliente->id)->get();
  $ventas=Venta::get();
     $deudas=Deuda::get();
     return view('cliente.comprascliente',['ventascliente'=>$ventascliente,'ventas'=>$ventas,'deudas'=>$deudas]);
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
  $pdf = \PDF::loadView('cliente.pdfmortizacioncliente',['venta'=>$venta,'deuda'=>$deuda,'cliente'=>$cliente,'productosventa'=>$productosventa,'productos'=>$productos,'domicilio'=>$domicilio]);
      return  $pdf->download('tablademortizacion.pdf');
}
}
