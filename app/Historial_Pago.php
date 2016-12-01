<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial_Pago extends Model
{
    protected $table = 'historial_pagos';

    protected $fillable = ['id_sitio', 'fecha_inicio', 'fecha_fin','valor'];
}
