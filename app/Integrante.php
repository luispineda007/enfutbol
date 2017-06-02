<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Integrante extends Model
{
    public function getUsuario()
    {
        return $this->belongsTo('App\User', 'usuario_id');
    }

    static public function participaEnTorneo( $torneo_id , $identificacion ){

        $torneos = DB::table('torneos')
            ->select( 'equipos.id', 'equipos.nombre')
            ->join('equipos_torneos', 'equipos_torneos.torneo_id', '=', 'torneos.id')
            ->join('equipos', 'equipos.id', '=', 'equipos_torneos.equipo_id')
            ->join('jugadors', 'jugadors.equipo_id', '=', 'equipos.id')
            ->where('torneos.estado', '<>', "T")
            ->where('equipos_torneos.estado', '<>', "P")
            ->where('jugadors.identificacion', '=', $identificacion)
            ->where('torneos.id', '=', $torneo_id)
            ->first();
        return $torneos;
    }
}
