<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Fases_torneo;
use App\SolicitudPago;
use App\Torneo;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $data["dias"]=$hoy->diffInDays($fecha_vence);
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
        $data['municipio'] = $usuario->getPersona->getMunicipio->id;
        $data['departamento'] = $usuario->getPersona->getMunicipio->getDepartamento->id;

        $departamentos= Departamento::select('id','departamento')->get();
        $arrayDepartamento = array();
        foreach ($departamentos as $departamento){
            $arrayDepartamento[$departamento->id]= $departamento->departamento;
        }
        $data['arrayDepartamento'] = $arrayDepartamento;
//        dd($data);
        return view('torneos.nuevo', $data);
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
        DB::beginTransaction();
        try{
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
            $torneo->premiacion = 'Campeon: ' . $request->campeon . ',SubCampeon: ' . $request->subcampeon;
            $torneo->premiados = '1,2';

            if(isset($request->p3)){
                $torneo->premiacion =  $torneo->premiacion . ',3er lugar: ' . $request->p3;
                $torneo->premiados = $torneo->premiados . ',3';
            }
            if(isset($request->p4)){
                $torneo->premiacion =  $torneo->premiacion . ',4to lugar: ' . $request->p4;
                $torneo->premiados = $torneo->premiados . ',4';
            }
            if(isset($request->p5)){
                $torneo->premiacion =  $torneo->premiacion . ',5to lugar: ' . $request->p5;
                $torneo->premiados = $torneo->premiados . ',5';
            }

            $torneo->save();
//            dd($torneo);

            $fase1 = new Fases_torneo();
            $fase1->torneo_id = $torneo->id;
            $fase1->numero_fase = '1';
            $fase1->nombre_fase = $request->nombreF1;
            $fase1->tipo_juego = $request->tipoF1;
            $fase1->save();

            if(isset($fase2)){
                $fase2 = new Fases_torneo();
                $fase2->torneo_id = $torneo->id;
                $fase2->numero_fase = '2';
                $fase2->nombre_fase = $request->nombreF2;
                $fase2->tipo_juego = $request->tipoF2;
                $fase2->save();
            }
            DB::commit();
            return ['estado' => true, 'mensaje' => $torneo->id];
        }catch(\Exception $e){
            DB::rollBack();
            return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
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
        $torneo = Torneo::find($id);
        if($torneo != null && $torneo->usuario_id == \Auth::user()->id){
            if($torneo->privacidad == 'A' && $torneo->estado = "A"){
                foreach($torneo->getSolicitudes as $solicitud) {
                    $solicitud->getEquipo;
                    $solicitud->getCapitan;
                }

            }
            foreach ($torneo->getEquipos_torneo as $equipo)
                $equipo->getEquipo;
            $data['torneo'] = $torneo;
//            dd($data);
            return view('torneos.torneo', $data);
        }
        else{
            return redirect()->back();
        }
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
        if($torneo->usuario_id == \Auth::user()->id) {
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


    public function solicidarPago(Request $request)
    {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
