<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
	    protected $fillable=[
          'id',
          'id_venta',
          'calle_colonia',
        'cp',
          'ciudad',
        'estado',
        ];
            public $timestamps = false;

}
