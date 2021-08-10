<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () { 
if(Auth::check()){return redirect('/redirigir');}else{return view('welcome');}});
Auth::routes();

Route::get('/Bienvenida', function () {    return view('Bienvenida');});

Route::get('/redirigir','HomeController@redirigir')->name('redirigir');

Route::get('/registro_empleado','Auth\RegisterController@formulario_empleado')->name('registrarempleado');

Route::group(['middleware'=>['auth']], function(){
//rutas administrador
Route::group(['middleware'=>['administrador']],function(){
Route::get('/administrador', 'AdministradorController@mainadministrador')->name('administrador');
Route::get('/permission-denied','DemoController@permissiondenied')->name('nopermission'
);
//gestion categorias
Route::get('/categorias','ProductoController@main')->name('categorias');
Route::get('/categorias/{id}','ProductoController@editcategoria')->name('categorias/{id}');
Route::post('/editar_categoria/{id}','ProductoController@updatecategoria')->name('editar_categoria/{id}');
Route::post('/Guardar_Categoria','ProductoController@createcategoria')->name('Guardar_Categoria');
Route::get('/eliminar_categoria/{id}','ProductoController@destroycategoria')->name('eliminar_categoria/{id}');
//gestion empleados
Route::get('/empleados_administrador','EmpleadoController@mainadministrador')->name('empleados_administrador');
Route::get('/agregar_empleado','EmpleadoController@ircreateempleado')->name('agregar_empleado');
Route::post('/createempleado','EmpleadoController@createempleado')->name('createempleado');
Route::get('/eliminar_empleado/{id}','EmpleadoController@destroyempleado')->name('eliminar_empleado/{id}');
//gestion sucursal
Route::get('/sucursales','EmpleadoController@mainsucursales')->name('sucursales');
Route::get('/agregar_sucursal','EmpleadoController@agregarsucursal')->name('agregar_sucursal');
Route::post('/guardar_sucursal','EmpleadoController@createsucursal')->name('guardar_sucursal');
Route::get('/editar_sucursal/{id}','EmpleadoController@editsucursal')->name('editar_sucursal/{id}');
Route::post('/actualizar_sucursal/{id}','EmpleadoController@updatesucursal')->name('actualizar_sucursal/{id}');
Route::get('/eliminar_sucursal/{id}','EmpleadoController@destroysucursal')->name('eliminar_sucursal/{id}');
//gestion productos
Route::get('/productos/{categoria}','ProductoController@mainproducto')->name('productos/{categoria}');
Route::get('/agregar_producto','ProductoController@agregarproducto')->name('agregar_producto');
Route::post('/guardar_producto','ProductoController@createproducto')->name('guardar_producto');
Route::get('/editar_producto/{id}','ProductoController@editproducto')->name('editar_producto/{id}');
Route::post('/actualizar_producto/{id}','ProductoController@updateproducto')->name('actualizar_sproducto{id}');
Route::get('/eliminar_producto/{id}','ProductoController@destroyproducto')->name('eliminar_producto/{id}');
Route::get('/pdf_productos','ProductoController@pdfproductos')->name('pdf_productoss');
Route::get('/gestion_clientes','ClienteController@gestionclientes')->name('gestion_clientes');
Route::get('/pdf_cliente','ClienteController@pdfclientes')->name('pdf_cliente');

});



//rutas empleado
Route::group(['middleware'=>['empleado']],function(){
Route::get('/empleado', 'EmpleadoController@mainempleado')->name('empleado');
Route::get('/permission-denied','DemoController@permissiondenied')->name('nopermission'
);

});


//rutas cliente
Route::group(['middleware'=>['cliente']],function(){
Route::get('/inicio_cliente', 'ClienteController@maincliente')->name('cliente');
Route::get('/permission-denied','DemoController@permissiondenied')->name('nopermission'
);
Route::get('/Editar_cliente','ClienteController@edit')->name('editar_cliente');
Route::post('/Editar_cliente_guardado/{id}','ClienteController@update')
->name('editar_cliente_guardado/{id}');
Route::get('/compra_online','VentaController@vercarritocliente')->name('compra_online');
Route::post('/completar_venta_cliente','VentaController@createventacliente')->name('completar_venta_cliente');
Route::get('/envios_cliente','ClienteController@envioscliente')->name('envios_cliente');
Route::get('/compras_cliente','ClienteController@comprascliente')->name('compras_cliente');
Route::get('/detalle_venta_cliente/{id}','VentaController@detalleventa')->name('detalle_venta_cliente/{id}');
Route::get('/update_envio_cliente/{id}/{estado}','ClienteController@updateenvio')->name('update_envio/{id}/{estado}');
Route::get('/pagos_cliente','VentaController@pagoscliente')->name('pagos_cliente');
Route::get('/abonar/{id}','VentaController@abonarcliente')->name('abonar/{id}');
Route::post('/pagar_abono_cliente/{id}','VentaController@pagarabonocliente')->name('pagar_abono_cliente/{id}');
});

Route::get('/tienda/{categoria}','TiendaController@main')->name('tienda/{categoria}');
Route::get('/descripcion_producto/{id}','TiendaController@verproducto')->name('descripcion_producto/{id}');
Route::post('/comentar_producto/{id}','TiendaController@createcomentario')->name('comentar_producto/{id}');
Route::post('/agregar_carrito/{id}','TiendaController@agregarcarrito')->name('agregar_carrito/{id}');
Route::get('/descargar_archivo/{ArchivoComentario}','TiendaController@descargararchivo')->name('descargar_archivo/{ArchivoComentario}');
Route::get('/carrito','TiendaController@vercarrito')->name('carrito');
Route::get('/pdf_carrito','TiendaController@pdfcarrito')->name('pdf_carrito');
Route::get('/eliminar_producto_carrito/{id}','TiendaController@destroyproductocarrito')->name('eliminar_producto_carrito/{id}');
Route::get('/vaciar_carrito','TiendaController@vaciarcarrito')->name('vaciar_carrito');
Route::get('/compra','VentaController@vercarrito')->name('/compra');
Route::post('/completar_venta','VentaController@createventa')->name('completar_venta');
Route::get('/gestion_venta/{tipo}','VentaController@gestionventas')->name('gestion_venta/{tipo}');
Route::get('/pdf_venta/{tipo}','VentaController@pdfventas')->name('pdf_venta/{tipo}');
Route::get('/detalle_venta/{id}','VentaController@detalleventa')->name('detalle_venta/{id}');
Route::get('/gestion_envios/{tipo}','VentaController@mainenvios')->name('gestion_envios/{tipo}');
Route::get('/update_envio/{id}/{estado}','VentaController@updateenvio')->name('update_envio/{id}/{estado}');
Route::get('/gestion_pagos','VentaController@pagos')->name('gestion_pagos');
Route::get('/abonar_tienda/{id}','VentaController@abonartienda')->name('abonar_tienda/{id}');
Route::post('/pagar_abono/{id}','VentaController@pagarabonotienda')->name('pagar_abono/{id}');

Route::get('firebase','FirebaseController@index');
});