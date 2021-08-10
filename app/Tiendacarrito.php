<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiendacarrito extends Model
{
	    protected $fillable=[
          'id',
          'id_carrito',
          'id_producto',
        'cantidad',
        'costo',
        ];
            public $timestamps = false;

}
