<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
	    protected $fillable=[
          'id',
          'importe',
          'iva',
        'total',
          'fecha',
        'hora',
        'entrega',
        ];
            public $timestamps = false;

}