<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $table = 'torneos';
    protected $fillable = ['nombre', 'usuario_id', 'sitio_id','lugar', 'max_equipos', 'max_jugadores', 'maxFecha_inscripcion', 'descripcion', 'url_logo', 'vlr_inscripcion', 'premiacion', 'premiados', 'estado', 'privacidad', 'municipio_id', 'tipo_cancha'];

    public function getEquipos_torneo()
    {
        return $this->hasMany('App\Equipos_torneo');
    }

    public function getFases()
    {
        return $this->hasMany('App\Fases_torneo');
    }

    public function getMunicipio()
    {
        return $this->belongsTo('App\Municipio','municipio_id');
    }

    public function getSitio()
    {
        return $this->belongsTo('App\Sitio','sitio_id');
    }

    public function getUsuario()
    {
        return $this->belongsTo('App\User','usuario_id');
    }

    public function getCodigosTorneo()
    {
        return $this->hasMany('App\Codigos_torneo');
    }


}
