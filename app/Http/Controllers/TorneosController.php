<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Equipos_torneo;
use App\Fases_torneo;
use App\SolicitudPago;
use App\Torneo;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TorneosController extends Controller
{
    /**
     * Devuelve la vista principal de torneos de un usuaio.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hoy = Carbon::today();
        $user = Auth::user();
        if($user->getPagoServiTorneo){

            if($user->getPagoServiTorneo->estado=="X"){
                $torneos = $user->getTorneos;
                foreach ($torneos as $torneo){
                    $torneo->getEquipos;
                }

                $data['torneos'] = $torneos;
            }else{
                $data['torneos'] = [];
            }
            $data["servicio"]= $user->getPagoServiTorneo;
            $fecha_vence= Carbon::parse($user->getPagoServiTorneo->fecha_fin);
            $data["dias"]=$hoy->diffInDays($fecha_vence, false);
//            $data["hoy"]=$hoy;
//            $data["vence"]=$fecha_vence;
//            dd($data);
            return view('torneos.index', $data);
        }else{
            return view('torneos.servicioTorneo');
        }

    }

    /**
     * SDevuelve la vista para crear un nuevo torneo.
     *
     * @return \Illuminate\Http\Response
     */
    public function torneoNuevo()
    {
        $usuario = Auth::user();
        if($usuario->getPagoServiTorneo) {
            if ($usuario->getPagoServiTorneo->estado == "X") {
                $data['municipio'] = $usuario->getPersona->getMunicipio->id;
                $data['departamento'] = $usuario->getPersona->getMunicipio->getDepartamento->id;

                $departamentos= Departamento::select('id','departamento')->get();
                $arrayDepartamento = array();
                foreach ($departamentos as $departamento){
                    $arrayDepartamento[$departamento->id]= $departamento->departamento;
                }
                $data['arrayDepartamento'] = $arrayDepartamento;
                return view('torneos.nuevo', $data);
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return view('torneos.servicioTorneo');
        }


    }

    /**
     * Inserta un nuevo torneo y sus fases asociadas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function insertTorneo(Request $request)
    {
        $usuario = \Auth::user();
        if ($usuario->getPagoServiTorneo) {
            if ($usuario->getPagoServiTorneo->estado == "X") {
                DB::beginTransaction();
                try {
                    $fotos = $request->file('url_logo');
                    $extension = explode(".", $fotos->getClientOriginalName());
                    $cantidad = count($extension) - 1;
                    $extension = $extension[$cantidad];
                    $nombre = time() . $request->file_id . "." . $extension;
                    $fotos->move('images/torneos', utf8_decode($nombre));

                    $torneo = new Torneo($request->all());
                    $torneo->usuario_id = $usuario->id;
                    $torneo->url_logo = utf8_decode($nombre);
                    $torneo->estado = 'A';
                    $torneo->premiacion = 'Campeon: ' . $request->campeon . ',SubCampeon: ' . $request->subcampeon . ', 3er Lugar: ' . $request->p3;
                    $torneo->genero = $request->genero;

                    $torneo->save();
                    DB::commit();
                    return ['estado' => true, 'mensaje' => $torneo->id];
                } catch (\Exception $e) {
                    DB::rollBack();
                    return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            } else {
                return ['estado' => false, 'mensaje' => "Tu suscripcion a Torneos ha caducado, contactanos para renovarla."];
            }
        } else {
            return ['estado' => false, 'mensaje' => "Adquiere una suscripcion a torneos para continuar esta operacion."];
        }

    }

    /**
     * Elimina un torneo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function deleteTorneo(Request $request)
    {
        DB::beginTransaction();
        try{
            $torneo = Torneo::find($request->id);
            unlink('images/torneos/' . $torneo->url_logo);
            $torneo->delete();
            DB::commit();
            return "exito";
        }
        catch(\Exception $e){
            DB::rollBack();
            return json_encode(array('error' => "Ha ocurrido el siguiente error: " . $e->getMessage()));
        }
    }

    /**
     * Si tiene permiso, retorna la vista para administrar un torneo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminTorneo($id)
    {
        $usuario = \Auth::user();
        if ($usuario->getPagoServiTorneo) {
            if ($usuario->getPagoServiTorneo->estado == "X") {

                $torneo = Torneo::find($id);
                if($torneo != null && $torneo->usuario_id == \Auth::user()->id){
                    if($torneo->estado == "A"){
                        foreach ($torneo->getEquipos_torneo as $equipo){
                            if($equipo->estado == 'P' || $equipo->estado == 'R'){
                                $data['solicitudes'] = true;
                                break;
                            }
                        }

                        $data['torneo'] = $torneo;

                        return view('torneos.torneo', $data);
                    }
                    else{
                        return redirect()->route('adminFases', $torneo->id);
                    }
                }
                else{
                    return redirect()->back();
                }

            }
            else{
                return view('torneos.index');
            }
        }
        else{
            return view('torneos.servicioTorneo');
        }
    }


    public function adminFases($torneo_id){

        $fase = Fases_torneo::where("estado","C")->where("torneo_id",$torneo_id)->first();

        if($fase){
            return view('torneos.configurarFase');
        }else{

        }

        return "la fase es".$torneo_id;
    }


    /**
     * Actualiza la informacion de un torneo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function updateTorneo(Request $request)
    {
//        dd($request->url_logo);
        $torneo = Torneo::find($request->torneo_id);
        if($torneo!=null && $torneo->usuario_id == \Auth::user()->id) {
            DB::beginTransaction();
            try{
                $torneo->nombre = $request->nombre;
                $torneo->descripcion = $request->descripcion;
                $mensaje = 'exito';
                if(isset($request->url_logo)){
                    $foto = $request->file('url_logo');
                    $extension = explode(".", $foto->getClientOriginalName());
                    $cantidad = count($extension) - 1;
                    $extension = $extension[$cantidad];
                    $nombre = time() . $request->file_id . "." . $extension;
                    $anterior =  $torneo->url_logo;

                    $foto->move('images/torneos', utf8_decode($nombre));
                    $torneo->url_logo = utf8_decode($nombre);
                    unlink('images/torneos/' . $anterior);
                    $mensaje=$nombre;
                }
                $torneo->save();
                DB::commit();
                return ['estado' => true, 'mensaje'=>$mensaje];
            }
            catch(\Exception $e){
                DB::rollBack();
                return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
            }
        }
        else{
            return ['estado' => false,'mensaje' => "No tiene acceso para realizar esta accion!"];

        }
    }


    public function solicidarPago(Request $request){
        $date = Carbon::now();

        $solicitudPago = SolicitudPago::where("user_id",Auth::user()->id)->get();

        if($solicitudPago->count()==0){
            $solicitud = new SolicitudPago($request->all());
            $solicitud->user_id=Auth::user()->id;
            $solicitud->servicio="torneo";
            $solicitud->fecha= $date->format('Y-m-d');
            $solicitud->estado="P";
            $solicitud->save();
            $data["bandera"]=true;
        }else{
            $bandera = true;

            foreach ($solicitudPago as $item){
                if($item->estado=="P"){
                    $bandera=false;
                }
            }

            if($bandera){
                $solicitud = new SolicitudPago($request->all());
                $solicitud->user_id=Auth::user()->id;
                $solicitud->servicio="torneo";
                $solicitud->fecha= $date->format('Y-m-d');
                $solicitud->estado="P";
                $solicitud->save();
                $data["bandera"]=true;
            }else{
                $data["bandera"]=false;
                $data["mensaje"]="Alcualmente existe una solicitud pendiente, espera una respuesta por parte del equipo de enFutbol.co";

            }
        }
        return $data;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return array
     */
    public function aceptarSolicitud(Request $request){
        $solicitud = Equipos_torneo::find($request->solicitud);
        if($solicitud != null){
            if($solicitud->torneo_id == $request->torneo){
                DB::beginTransaction();
                try{
                    $solicitud->estado = 'A';
                    $solicitud->save();
                    DB::commit();
                    $solicitud->getEquipo->getEscudo;
                    return ['estado' => true, 'mensaje'=>$solicitud];
                }
                catch(\Exception $e){
                    DB::rollBack();
                    return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else{
                return ['estado' => false, 'mensaje' => "No tienes permiso para realizar esta accion!"];
            }
        }
        else{
            return ['estado' => false, 'mensaje' => "No es posible realizar esta accaion!"];
        }
    }

    public function rechazarSolicitud(Request $request){
        $solicitud = Equipos_torneo::find($request->solicitud);
        if($solicitud != null){
            if($solicitud->torneo_id == $request->torneo){
                DB::beginTransaction();
                try{
                    $solicitud->estado = 'R';
                    $solicitud->save();
                    DB::commit();
                    $solicitud->getEquipo->getCapitan->getPersona;
                    return ['estado' => true, 'mensaje'=>$solicitud];
                }
                catch(\Exception $e){
                    DB::rollBack();
                    return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else{
                return ['estado' => false, 'mensaje' => "No tienes permiso para realizar esta acción!"];
            }
        }
        else{
            return ['estado' => false, 'mensaje' => "No tienes permiso para realizar esta acción!"];
        }
    }

    public function adminEquipo($id){
        $equipoTorneo = Equipos_torneo::find($id);
        if($equipoTorneo != null){
            $equipoTorneo->getEquipo;
            $data['equipo'] = $equipoTorneo;
            return view('torneos.editEquipo', $data);
        }
        else{
            return redirect()->back();
        }
    }

    public function iniciarTorneo(Request $request)
    {
        $torneo = Torneo::find($request->torneo);
        if($torneo!=null && $torneo->usuario_id == \Auth::user()->id) {
            $fase = $this->insertFase($torneo->id, '');
            if ($fase['estado']){
                DB::beginTransaction();
                try{
                    $torneo->estado = 'C';
                    $torneo->save();
                    DB::commit();
                    return ['estado' => true];
                }
                catch(\Exception $e){
                    DB::rollBack();
                    return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else{
                return ['estado' => false,'mensaje' => $fase['mensaje']];
            }
        }
        else{
            return ['estado' => false,'mensaje' => "No tiene permisos para realizar esta accion!"];

        }
        //actualizar torneo estado a C
        //crear fase con consecutivo 1
    }

    public function insertFase($torneo_id, $consecutivo)
    {
        DB::beginTransaction();
        try{
            $fase = new Fases_torneo();
            $fase->torneo_id = $torneo_id;
            if($consecutivo != '')
                $fase->numero_fase = $consecutivo+1;
            else
                $fase->numero_fase = '1';
            $fase->nombre_fase = ' ';
            $fase->tipo_juego = 'TvT';
            $fase->estado = 'C';
            $fase->save();
            DB::commit();
            return ['estado' => true];
        }
        catch(\Exception $e){
            DB::rollBack();
            return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
        }
    }
}
