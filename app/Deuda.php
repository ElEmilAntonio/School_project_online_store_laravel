<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
	    protected $fillable=[
          'id',
          'id_venta',
        'meses',
        'meses_pagados',
          'abono',
        'deuda_actual',
        'estado',
        ];
            public $timestamps = false;

}