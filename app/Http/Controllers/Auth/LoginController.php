<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Cliente;
class LoginController extends Controller{
    use AuthenticatesUsers;
protected function authenticated(Request $request, $user){
     $user= Auth::user()->roles->pluck('name');
if ( $user->contains('cliente') ) {
      $id=Auth::User()->id;
        $Usuario=User::findOrFail($id);
    return redirect()->route('cliente');
}elseif ( $user->contains('empleado') ) {
    return redirect()->route('empleado');
}elseif ($user->contains('administrador')){
    return redirect()->route('administrador');
}
}

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
}
