<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventacliente extends Model
{
	    protected $fillable=[
          'id',
          'id_cliente',
        'id_venta',
        ];
            public $timestamps = false;

}