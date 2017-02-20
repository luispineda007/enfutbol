<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudPago extends Model
{
    protected $table = 'solicitud_pagos';

    protected $fillable = ['plan'];

}
