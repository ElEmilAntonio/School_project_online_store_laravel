<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carritocliente extends Model
{
	    protected $fillable=[
          'id',
          'id_usuario',
          'total',
        'iva',
        ];
            public $timestamps = false;

}
