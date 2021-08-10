<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
	    protected $fillable=[
          'id',
          'nombre',
          'unidades',
        'id_categoria',
          'precio',
        'imagen',
        'descripcion',
        'estado',
        ];
            public $timestamps = false;

}
