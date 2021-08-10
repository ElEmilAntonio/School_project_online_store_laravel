<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productoventa extends Model
{
	    protected $fillable=[
          'id',
          'id_venta',
          'id_producto',
        'cantidad',
          'total',
         ];
            public $timestamps = false;

}