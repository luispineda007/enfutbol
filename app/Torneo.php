<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $table = 'torneos';
    protected $fillable = ['nombre', 'usuario_id', 'max_equipos', 'max_jugadores', 'maxFecha_inscripcion', 'descripcion', 'url_logo', 'vlr_inscripcion', 'premiacion', 'premiados', 'estado', 'privacidad', 'municipio_id', 'tipo_cancha'];

    public function getEquipos_torneo()
    {
        return $this->hasMany('App\Equipos_torneo');
    }

    public function getFases()
    {
        return $this->hasMany('App\Fases_torneo');
    }
}
