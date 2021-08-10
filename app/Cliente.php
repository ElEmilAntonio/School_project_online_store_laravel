<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	    protected $fillable=[
          'id',
          'id_usuario',
          'rfc',
        'nombres',
          'apellidos',
        'edad',
        'salario',
        'sexo',
        'foto'
        ];
            public $timestamps = false;

}
