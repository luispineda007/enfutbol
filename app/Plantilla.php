<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    public function getJugadores()
    {
        return $this->hasMany('App\Integrante');
    }
}
