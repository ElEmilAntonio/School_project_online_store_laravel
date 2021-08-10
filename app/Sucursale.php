<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
	    protected $fillable=[
          'id',
          'calle_colonia',
        'cp',
          'ciudad',
        'estado',
        ];
            public $timestamps = false;

}
