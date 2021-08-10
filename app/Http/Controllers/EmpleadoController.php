<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\UploadRequest;
use redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\RegistersUsers;
use Response;
use App\Role_user;
use App\User;
use App\Sucursale;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mainempleado()
    {
    $id=Auth::User()->id;
    $Usuario=User::findOrFail($id);
    return view('empleado.empleado');
    }

    public function mainadministrador(){
    $rol=2;
    $Usuariopush=collect();
    $Empleados=Role_user::Where('role_id',$rol)->get();
     foreach ($Empleados as $empleado ) {
      $Usuario=User::findOrFail($empleado->user_id);
      $Usuariopush->push($Usuario);
}
$Usuarios=$Usuariopush->values();
$Lista_empleados=$Usuarios->all();
    return view('administrador.empleados',['empleados'=>$Lista_empleados]);
    }

    public function ircreateempleado(){
     return view('auth.registrarempleado');   
    }
 
 public function createempleado(Request $request){
    $Validator = Validator::make($request->all(),[
        'name'=>['required','string','max:50'],
         'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    if($validator->fails()){
            return redirect('/empleados_administrador')->withInput()->withErrors($validator);
        }
     $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
     $userid = User::select('id')->where('email',$request->email)->value('id');
       $Role_user = Role_user::create(['role_id'=>2,'user_id'=>$userid]);
     return redirect('/empleados_administrador');
    }

    public function destroyempleado(Request $request,$id){
    $empleado=User::findOrFail($id)->delete();
    $rol=Role_user::where('user_id',$id)->delete();
    return redirect('/empleados_administrador');
    }
    
    public function mainsucursales(){
     $Sucursales=Sucursale::all();
     return view('administrador.sucursales',['sucursales'=>$Sucursales]);
    }
    
    public function agregarsucursal(){
      return view('administrador.agregarsucursal');  
    }
    public function createsucursal(Request $request){
     $validator = Validator::make($request->all(),[
         'calle'=>['required','string','max:50'],
            'cp'=>['required','string','max:6'],
            'ciudad'=>['required','string','max:50'],
            'estado'=>['required','string','max:50'],
        ]);
     if($validator->fails()){
            return redirect('/sucursales')->withInput()->withErrors($validator);
        }
    $Sucursal=Sucursale::create([
      'id'=>null,
      'calle_colonia'=>$request->calle,
      'cp'=>$request->cp,
       'ciudad'=>$request->ciudad,
       'estado'=>$request->estado]);
    return redirect('/sucursales');
    }

    public function destroysucursal(Request $request, $id){
     $Sucursal=Sucursale::findOrFail($id)->delete();
     return redirect('/sucursales');
    }

    public function editsucursal(Request $request, $id){
     $Sucursal=Sucursale::findOrFail($id);
     return view('administrador.editarsucursal',['sucursal'=>$Sucursal]);
    }

    public function updatesucursal(Request $request,$id){
      $validator = Validator::make($request->all(),[
         'calle'=>['required','string','max:50'],
            'cp'=>['required','string','max:6'],
            'ciudad'=>['required','string','max:50'],
            'estado'=>['required','string','max:50'],
        ]);
     if($validator->fails()){
            return redirect('/editarsucursal/'.$id)->withInput()->withErrors($validator);
        }  
        $Sucursal=Sucursale::findOrFail($id);
        $Sucursal->calle_colonia=$request->calle;
        $Sucursal->cp=$request->cp;
        $Sucursal->ciudad=$request->ciudad;
        $Sucursal->estado=$request->estado;
        $Sucursal->update();
        return redirect('/sucursales');
    }
}
