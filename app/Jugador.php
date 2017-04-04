<?php

namespace App;

use Faker\Provider\fr_CH\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jugador extends Model
{
    protected $table = "jugadors";

    public function getMisTorneos($identificacion){
        $torneos = DB::table('torneos')
            ->select( 'torneos.id', 'torneos.nombre','torneos.url_logo')
            ->join('equipos_torneos', 'equipos_torneos.torneo_id', '=', 'torneos.id')
            ->join('equipos', 'equipos.id', '=', 'equipos_torneos.equipo_id')
            ->join('jugadors', 'jugadors.equipo_id', '=', 'equipos.id')
            ->where('torneos.estado', '<>', "T")
            ->where('equipos_torneos.estado', '<>', "P")
            ->where('jugadors.identificacion', '=', $identificacion)
            ->get();
        return $torneos;
    }

    public function participaEnTorneo( $torneo_id , $identificacion ){

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

    public function getUsuarioJugador($id)
    {
        $persona = Persona::where('identificacion', '=', $id)->get();
        if(count($persona) == 0) {
            $persona = PesonasExterna::where('identificacion', '=', $id)->get();
        }

        return $persona;
    }
}
