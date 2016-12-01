<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = ['id_cancha', 'id_token','responsable','telefono', 'fecha', 'hora'];
    
    
    public function getToken(){

        return $this->belongsTo('App\Token','id_token');
        
    }


    public function getCancha(){

        return $this->belongsTo('App\Cancha','id_cancha');

    }

    public function getReservasXSitio($id_sitio){
        $reservas = \DB::table('sitios')
            ->where('sitios.id', '=', $id_sitio)->where('reservas.estado','=','A')
            ->join('canchas', 'sitios.id', '=', 'canchas.id_sitio')
            ->join('reservas', 'canchas.id', '=', 'reservas.id_cancha')
            ->select('reservas.id')
            ->get();
        return $reservas;
    }

    /**
     * @return array
     */
    public function getNumCanchasDispoXTipo($id_sitio,$tipo,$fecha,$hora){

        $disponibles = \DB::table('canchas')
            ->where ('canchas.id_sitio', '=', $id_sitio)->where ('canchas.tipo', '=', $tipo)->where ('reservas.fecha', '=', $fecha)->where ('reservas.hora', '=', explode(":",$hora )[0])->where ('reservas.estado', '!=', "I")
            ->join ('reservas', 'canchas.id', '=', 'reservas.id_cancha')
            ->select(\DB::raw('COUNT(reservas.id) AS disponibles'))
            ->first();
       // dd($id_sitio.",".$tipo.",".$fecha.",".$hora.")".$disponibles[0]->disponibles);
        return $disponibles;
    }


    /**
     * @return array
     */
    public function reservasXTokenSitio($id_token,$id_sitio){

        $reservas = \DB::table('reservas')
            ->where("reservas.id_token",'=',$id_token)->where("reservas.estado",'=',"A")->where("canchas.id_sitio",'=',$id_sitio)
            ->join ('canchas', 'reservas.id_cancha', '=', 'canchas.id')
            ->select("reservas.id")
            ->get();


        return $reservas;
    }


    /**
     * @return array
     */
    public function misReservasUser($user){

        $users = \DB::table('tokens')
            ->where("tokens.id_usuario",'=',$user)->where("tokens.estado",'=',"A")->where("reservas.estado",'=',"A")
            ->join('reservas', 'tokens.id', '=', 'reservas.id_token')
            ->join('canchas', 'reservas.id_cancha', '=', 'canchas.id')
            ->join('sitios', 'canchas.id_sitio', '=', 'sitios.id')
            ->select('sitios.id as id_sitio','sitios.nombre as sitio', 'reservas.id', 'reservas.fecha','reservas.hora', 'canchas.nombre', 'canchas.tipo', 'canchas.foto')
            ->get();
        
        return $users;
    }





}
