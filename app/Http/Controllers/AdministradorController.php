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
use App\Venta;
use App\Productoventa;
use App\Deuda;
use App\Ventacliente;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts;
use Illuminate\View\Factory;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mainadministrador()
    {
    $id=Auth::User()->id;
    $Usuario=User::findOrFail($id);

    $lava = new Lavacharts; // See note below for Laravel

$sales = $lava->DataTable();

$sales->addDateColumn('Date')
      ->addNumberColumn('Orders');

foreach (range(4,7) as $month) {
        $ventas=0;
    for ($a=0; $a <31; $a++) {
        $ventas=Venta::where('fecha','2020-'.$month."-".$a)->count();
       
        $sales->addRow(["2020-${month}-${a}",$ventas]);
    }
}

$lava->CalendarChart('Sales', $sales, [
    'title' => 'Ventas por dia',
    'unusedMonthOutlineColor' => [
        'stroke'        => '#ECECEC',
        'strokeOpacity' => 0.75,
        'strokeWidth'   => 1
    ],
    'dayOfWeekLabel' => [
        'color'    => '#4f5b0d',
        'fontSize' => 16,
        'italic'   => true
    ],
    'noDataPattern' => [
        'color' => '#DDD',
        'backgroundColor' => '#11FFFF'
    ],
    'colorAxis' => [
        'values' => [0,15],
        'colors' => ['gray', 'red']
    ]
]);


    return view('administrador.administrador',['lava'=>$lava]);
    }

}
