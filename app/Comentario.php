<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
	    protected $fillable=[
          'id',
          'id_producto',
          'id_usuario',
        'comentario',
        ];
            public $timestamps = false;

}
