<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    public function getEscudo()
    {
        return $this->belongsTo('App\Escudo', 'escudo_id');
    }

    public function getCapitan()
    {
        return $this->belongsTo('App\User', 'capitan_id');
    }
}
