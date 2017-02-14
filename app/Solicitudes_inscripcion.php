<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudes_inscripcion extends Model
{
    public function getEquipo()
    {
        return $this->belongsTo('App\Equipo', 'equipo_id');
    }
    public function getCapitan()
    {
        return $this->belongsTo('App\User', 'capitan_id');
    }
}
