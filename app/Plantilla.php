<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    protected $table = "plantillas";

    protected $fillable = ['nombre', 'genero'];


    public function getJugadores()
    {
        return $this->hasMany('App\Integrante');
    }
}
