<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domiciliocliente extends Model
{
	    protected $fillable=[
         'id',
          'id_cliente',
          'calle_colonia',
        'cp',
          'ciudad',
        'estado',
        ];
            public $timestamps = false;

}
