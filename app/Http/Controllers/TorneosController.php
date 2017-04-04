<?php

namespace App\Http\Controllers;

use App\Codigos_torneo;
use App\Departamento;
use App\Equipo;
use App\Equipos_torneo;
use App\Escudo;
use App\Fases_torneo;
use App\Integrante;
use App\Jugador;
use App\Persona;
use App\PesonasExterna;
use App\Plantilla;
use App\SolicitudPago;
use App\Torneo;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;
use spec\PhpSpec\CodeGenerator\Generator\NewFileNotifyingGeneratorSpec;

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

        if(Auth::guest()){
            return view('torneos.servicioTorneo');
        }else{
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
//                        dd($data);
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
     * Permite al administrador del torneo acepatr la solicitud de inscripcion de un equipo a uno de sus torneos
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

    /**
     * Permite al administrador del torneo rechazar la solicitud de inscripcion de un equipo a uno de sus torneos
     *
     * @return array
     */
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

    /**
     * Permite al administrador del torneo realizar modificaciones sobre un equipo participante en uno de sus torneos
     *
     * @return array
     */
    public function adminEquipo($id){
        $equipoTorneo = Equipos_torneo::find($id);
        if($equipoTorneo != null){
            $data['equipo'] = $equipoTorneo->getEquipo;
            $data['torneo'] = $equipoTorneo->getTorneo;
            $usuario = Auth::user();
            if($data['torneo']->usuario_id == $usuario->id || $data['equipo']->capitan_id == $usuario->id){
                $data['genero'] = ($data['torneo']->genero == 'M')?'Masculino':'Femenino';

                $arrayDepartamento = array();
                $departamentos = Departamento::select('id', 'departamento')->get();
                foreach ($departamentos as $departamento) {
                    $arrayDepartamento[$departamento->id] = $departamento->departamento;
                }
                $data["arrayDepartamento"] = $arrayDepartamento;

                if($usuario->rol == 'jugador')
                    return view('torneos.miEquipo', $data);
                else
                    return view('torneos.editEquipo', $data);
            }
            else
                return redirect()->back();
        }
        else
            return redirect()->back();
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

    public function adminPlantillas()
    {
        $user = Auth::user();

        $data['plantillas'] = $user->getPlantillas;

//        dd($data);

        return view('torneos.plantillas', $data);
    }


        /**
         * .
         *
         * @return array
         */
        public function nuevaPlantilla (Request $request){
            $data= array();
            $totalPlantillas = Auth::user()->getPlantillas->count();
            if($totalPlantillas<5){
                $plantilla = new Plantilla($request->all());
                $plantilla->usuario_id= Auth::user()->id;
                $plantilla->save();
                $data["bandera"]= true;
                $data["mensaje"]="exito";
                $data["nombre"]= (strlen($plantilla->nombre) <= 10)?$plantilla->nombre:substr($plantilla->nombre, 0, 10).'...';
                $data["genero"]= $plantilla->genero;
                $data["id"]=$plantilla->id;
                $data["totalPlantillas"] = $totalPlantillas;
            }

            return $data;
        }

    public function getPlantilla(Request $request)
    {
        $plantilla = Plantilla::find($request->plantilla);
        if($plantilla != null && $plantilla->usuario_id==\Auth::user()->id){
            $data['plantilla'] = $plantilla;
            return response()->json(view('torneos.editPlantilla', $data)->render());
        }
        else{
            return 'error';
        }
    }

    public function addJugadorPlanilla(Request $request)
    {
        $usuario = User::find($request->usuario_id);
        $plantilla = Plantilla::find($request->plantilla);
        if($usuario != null && $plantilla!= null && $plantilla->usuario_id==\Auth::user()->id){
            $añadir = true;
            foreach($plantilla->getJugadores as $jugador){
                if($jugador->usuario_id == $usuario->id){
                    $añadir = false;
                    break;
                }
            }
            if($añadir){
                DB::beginTransaction();
                try{
                    $integrante = new Integrante();
                    $integrante->usuario_id = $usuario->id;
                    $integrante->plantilla_id = $plantilla->id;
                    $integrante->save();
                    DB::commit();
                    $integrante->getUsuario->getPersona;
                    return ['estado' => true, 'mensaje' => $integrante];
                }
                catch(\Exception $e){
                    DB::rollBack();
                    return ['estado' => false,'mensaje' => "Lo sentimos, ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else{
                return ['estado' => false,'mensaje' => "El usuario seleccionado ya existe en esta plantilla, por favor ingresa uno diferente."];
            }
        }
        else{
            return ['estado' => false,'mensaje' => "No tienes permisos para completar esta acción."];
        }
    }

    public function delJugadorPlanilla(Request $request)
    {
        $participante = Integrante::find($request->jugador);
        $plantilla = Plantilla::find($request->plantilla);
        if($participante != null && $plantilla != null && $plantilla->usuario_id==\Auth::user()->id && $participante->plantilla_id==$plantilla->id){
            DB::beginTransaction();
            try{
                $participante->delete();
                DB::commit();
                return ['estado' => true];
            }
            catch(\Exception $e){
                DB::rollBack();
                return ['estado' => false,'mensaje' => "Lo sentimos, ha ocurrido el siguiente error: " . $e->getMessage()];
            }
        }
        else{
            return ['estado' => false,'mensaje' => "No tienes permisos para completar esta acción."];
        }
    }

        /**
         * funcion encargada de lanzar la vista para buscar los torneos en el sistema.
         *
         * @return array
         */
        public function buscarTorneos(Request $request){
            $data = array();
            $data["mistorneos"]=[];
            if(!Auth::guest()){
                $jugador = new Jugador();
                $torneos = $jugador->getMisTorneos(Auth::user()->getPersona->identificacion);
                $arrayMisTorneos = array();

                foreach ($torneos as $torneo){
                    $objTorneo = Torneo::find($torneo->id);
                    $objTorneo->municipio=$objTorneo->getMunicipio->municipio;
                    $arrayMisTorneos[] = $objTorneo;
                }
                $data["mistorneos"]=$arrayMisTorneos;
            }
            if($request->nombre!=null)
                $nombre = $request->nombre;
            else
                $nombre = "";
            if($request->estado!=null)
                $estado = $request->estado;
            else
                $estado = "A";

                $torneos = Torneo::where("nombre", "like","%" . $nombre. "%")->where("estado",$estado)->paginate(8);

            //dd($request->estado);

            $data["torneos"] = $torneos;

            if($request->ajax()){
                return response()->json(view('torneos.torneos', $data)->render());
            }
            return view('torneos.buscar', $data);
        }
    /**
     * funcion encargada de mostrar los detalles de los torneos
     *
     * @return array
     */
    public function detalleTorneo($torneo){
        $torneo = Torneo::find($torneo);
        $torneos = Torneo::where("estado","A")->paginate(4);
        $data = array();

        if($torneo){
            $data["torneo"] = $torneo;
            $data["torneos"] = $torneos;
            if(!Auth::guest()) {
                $jugador = new Jugador();
                $data["participo"] = $jugador->participaEnTorneo($torneo->id, Auth::user()->getPersona->identificacion);
                $usuario = new User();
                $data['capitan'] = $usuario->capitanEnTorneo($torneo->id, Auth::user()->id);
            }
            return view('torneos.detalleTorneo',$data);
        }else{
            return redirect()->back();
        }


    }

    /**
     * funcion para landar la vista para inscribir un equipo a un torneo.
     *
     * @return array
     */
    public function inscribeTuEquipo (Request $request){
//        dd($request->torneo);
        if($request->torneo){
            $data["torneo"]=$torneo = Torneo::find($request->torneo);
        }else{
            $data["torneo"]=[];
        }
        $data["planillas"] = Plantilla::where("usuario_id",Auth::user()->id)->get();

        $arrayDepartamento = array();
        $departamentos = Departamento::select('id', 'departamento')->get();

        foreach ($departamentos as $departamento) {
            $arrayDepartamento[$departamento->id] = $departamento->departamento;
        }

        $data["arrayDepartamento"] = $arrayDepartamento;

       // dd($data);
        return view('torneos.inscribeTuEquipo', $data);
    }


    /**
     * Funcion encargada de permitir aañadir personas externas al sistema
     *
     * @return array
     */
    public function addPersonaExterna(Request $request){
        DB::beginTransaction();
        try {
            $personaExterna = new PesonasExterna($request->all());
            $personaExterna->save();
            DB::commit();
            if($request->addEquipo == 'SI') {
                $jugador = $this->addJugadorEquipo($request);
                return ['estado' => $jugador['estado'], 'mensaje' => $jugador['mensaje']];
            }
            else{
                return ['estado' => true];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
        }
    }

    /**
     * funcion encargada de validar la existencia de personas en el sistema como usuario registrado o persona externa.
     *
     * @return array
     */
    public function exisPersona(Request $request){
        $persona = Persona::where("identificacion",$request->identificacion)->first();
        if(!$persona){
            $persona = PesonasExterna::where("identificacion",$request->identificacion)->first();
        }

        if($persona){
            $torneo = Torneo::find($request->torneo);
            if($torneo->genero == $persona->sexo){
                $jugador = new Jugador();
                $equipoJugador = $jugador->participaEnTorneo($request->torneo, $persona->identificacion);
                if($equipoJugador != null){
                    $data['bandera'] = false;
                    $data['mensaje'] = $equipoJugador;
                }
                else{
                    $data["bandera"]=true;
                }
//                $data["nombres"]= $persona->nombres;
            }
            else{
                $data["bandera"] = false;
                $data['mensaje'] = 'No sexo';
                $data['sexo'] = ($torneo->genero == 'M')?'Masculino':'Femenino';
            }
            $data["nombres"]= $persona->nombres;
        }
        else{
            $data["bandera"] = false;
            $data['mensaje'] = 'No encontrado';
        }
        return $data;
    }

    public function addEquipoTorneo(Request $request)
    {
        $torneo = Torneo::find($request->torneo_id);
        if($torneo!=null && $torneo->usuario_id == \Auth::user()->id) {

            $usuario = new User();
            $capitan = $usuario->capitanEnTorneo($torneo->id, $request->capitan);
//            dd($capitan);

            if($capitan == null){
                DB::beginTransaction();
                try{
                    $equipo = new Equipo();
                    $equipo->nombre = $request->equipo;
                    $equipo->genero = $torneo->genero;
                    $equipo->capitan_id = $request->capitan;
                    $equipo->escudo_id = 1;
                    $equipo->save();

                    $equipoTorneo = new Equipos_torneo();
                    $equipoTorneo->torneo_id = $torneo->id;
                    $equipoTorneo->equipo_id = $equipo->id;
                    $equipoTorneo->estado = 'A';
                    $equipoTorneo->save();

                    DB::commit();
                    $equipoTorneo->getEquipo->getEscudo;
                    return ['estado' => true, 'mensaje'=>$equipoTorneo];
                }
                catch(\Exception $e){
                    DB::rollBack();
                    return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else{
                return ['estado' => false, 'mensaje' => "La persona seleccionada no puede ser capitan, pues ya participa en este torneo."];
            }

        }
        else{
            return ['estado' => false, 'mensaje' => "No tienes permisos para realizar esta acción!"];
        }
    }

    public function generarCodigo(Request $request)
    {
        $torneo = Torneo::find($request->torneo_id);
        if($torneo!=null && $torneo->usuario_id == \Auth::user()->id) {

            $usuario = User::find($request->capitan);
            $capitan = $usuario->capitanEnTorneo($torneo->id, $request->capitan);

            $tieneCodigo = true;
            foreach($torneo->getCodigosTorneo as $codigo){
                if($codigo->usuario_id == $request->capitan){
                    $tieneCodigo = false;
                    break;
                }
            }

            if($capitan == null && $tieneCodigo){
                DB::beginTransaction();
                try{
                    $codigo = new Codigos_torneo();
                    $codigo->torneo_id = $torneo->id;
                    $codigo->codigo = $request->codigo;
                    $codigo->estado = 'A';
                    $codigo->usuario_id = $request->capitan;
                    $codigo->save();
                    DB::commit();

                    MailController::enviarCodigo(["email"=>$usuario->email,"torneo"=>$torneo->nombre, "ruta"=>route("detalleTorneo",$torneo->id), "codigo"=>$request->codigo]);
                    return ['estado' => true];
                }
                catch(\Exception $e){
                    DB::rollBack();
                    return ['estado' => false,'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else{
                return ['estado' => false, 'mensaje' => "No se puede invitar a esta persona como capitan de un equipo, pues ya participa en este torneo o ya tiene un codigo asignado."];
            }

        }
        else{
            return ['estado' => false, 'mensaje' => "No tienes permisos para realizar esta acción!"];
        }
    }

    /**
     * Retorna los escudos que aun no estan en uso en el torneo.
     *
     * @return array
     */
    public function getEscudosDisponibles(Request $request)
    {
        $torneo = Torneo::find($request->torneo_id);
        if($torneo != null){
            $arrayUsados = $this->getEscudosEnUso($torneo);
                $disponibles = DB::table('escudos')
                    ->whereNotIn('id', $arrayUsados)
                    ->get();
            return ['estado' => true, 'mensaje' => $disponibles];
        }
        else{
            return ['estado' => false, 'mensaje' => "Torneo no valido! Intentalo de nuevo"];
        }
    }


    public function getEscudosEnUso($torneo)
    {
        $arrayUsados = array();
        foreach($torneo->getEquipos_torneo as $inscrito){
            if($inscrito->estado == 'A'){
                array_push($arrayUsados, $inscrito->getEquipo->escudo_id);
            }
        }
        return $arrayUsados;
    }

    public function actualizarEscudo(Request $request)
    {
        $equipo = Equipo::find($request->equipo);
        $escudo = Escudo::find($request->escudo);
        if($equipo != null && $escudo != null){
            if($equipo->capitan_id == \Auth::user()->id || $equipo->getEquipoTorneo->getTorneo->usuario_id == \Auth::user()->id) {
                $escudosUsados = $this->getEscudosEnUso($equipo->getEquipoTorneo->getTorneo);
                $cambiar = true;
                foreach ($escudosUsados as $usado) {
                    if ($usado == $request->escudo) {
                        $cambiar = false;
                        break;
                    }
                }
                if ($cambiar){
                    DB::beginTransaction();
                    try {
                        $equipo->escudo_id = $request->escudo;
                        $equipo->save();
                        DB::commit();
                        return ['estado' => true, 'mensaje' => $escudo->url];
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                    }
                }
                else
                    return ['estado' => false, 'mensaje' => "El escudo seleccionado ya esta en uso por otro equipo, por favor selecciona uno diferente."];
            }
            else
                return ['estado' => false, 'mensaje' => "No tienes suficientes permisos para realizar esta accion!"];
        }
        else
            return ['estado' => false, 'mensaje' => "No tienes suficientes permisos para realizar esta accion!"];
    }

    public function UpdateEquipo(Request $request)
    {
        $torneo = Torneo::find($request->torneo);
        if($torneo!=null && $torneo->usuario_id == \Auth::user()->id) {
            $equipo = Equipo::find($request->equipo);
            if($equipo!=null && $equipo->getEquipoTorneo->getTorneo->id==$torneo->id){
                DB::beginTransaction();
                try {
                    $equipo->nombre = $request->nombre;
                    $equipo->save();
                    DB::commit();
                    return ['estado' => true];
                } catch (\Exception $e) {
                    DB::rollBack();
                    return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                }
            }
            else
                return ['estado' => false, 'mensaje' => "No tienes suficientes permisos sobre este equipo para realizar esta accion!"];
        }
        else
            return ['estado' => false, 'mensaje' => "No tienes suficientes permisos para realizar esta accion!"];

    }

    public function addJugadorEquipo(Request $request)
    {
        $equipo = Equipo::find($request->equipo);
        if($equipo != null){
            if($equipo->capitan_id==\Auth::user()->id || $equipo->getEquipoTorneo->getTorneo->usuario_id==\Auth::user()->id){
                DB::beginTransaction();
                $respuesta = $this->insertJugador($request->identificacion, $equipo->id);
                if($respuesta['estado'])
                    DB::commit();
                else
                    DB::rollBack();
                return ['estado' => $respuesta['estado'], 'mensaje' => $respuesta['mensaje']];
            }
            else
                return ['estado' => false, 'mensaje' => "No tienes suficientes permisos para realizar esta accion!"];
        }
        else
            return ['estado' => false, 'mensaje' => "Ha ocurrido un error interno, por favor intentalo mas tarde"];
    }

    public function insertJugador($identificacion, $equipo_id)
    {
        try {
            $jugador = new Jugador();
            $jugador->identificacion = $identificacion;
            $jugador->equipo_id = $equipo_id;
            $jugador->posicion = ' ';
            $jugador->save();
            return ['estado' => true, 'mensaje' => $jugador];
        } catch (\Exception $e) {
            return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
        }
    }

    public function borrarJugadores(Request $request)
    {
//        dd($request->all());
        $equipo = Equipo::find($request->equipo);
        if($equipo != null){
            if($equipo->capitan_id==\Auth::user()->id || $equipo->getEquipoTorneo->getTorneo->usuario_id==\Auth::user()->id){
                $eliminados = array();
                foreach($request->jugadores as $llave=>$jugador){
                    DB::beginTransaction();
                    try {
                        Jugador::find($jugador)->delete();
                        DB::commit();
                        array_push($eliminados, $jugador);
                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
                }

                if(count($request->jugadores)==count($eliminados)){
                    return ['estado' => true, 'mensaje' => 'Completo'];
                }
                else{
                    return ['estado' => true, 'mensaje' => "Incompleta", 'eliminados' => $eliminados];
                }
            }
            else
                return ['estado' => false, 'mensaje' => "No tienes suficientes permisos para realizar esta accion!"];
        }
        else
            return ['estado' => false, 'mensaje' => "Ha ocurrido un error interno, por favor intentalo mas tarde"];
    }

    public function inscribirEquipo(Request $request)
    {
        $codigo = Codigos_torneo::where('codigo', $request->codigo)
                                ->where('torneo_id', $request->torneo)
                                ->where('usuario_id', \Auth::user()->id)
                                ->get();
        if(count($codigo) != 0 && $codigo[0]->estado == 'A'){
            $torneo = Torneo::find($request->torneo);

            $ObjUsuario = new User();
            $capitan = $ObjUsuario->capitanEnTorneo($torneo->id, $request->capitan);

            $objJugador = new Jugador();
            $jugador = $objJugador->participaEnTorneo($torneo->id, Auth::user()->getPersona->identificacion);

            if($jugador == null){
                if($capitan == null){
                    $escudo = Escudo::find($request->escudo);
                    if($escudo!= null){
                        $disponible = true;
                        $escudosUsados = $this->getEscudosEnUso($torneo);
                        foreach($escudosUsados as $usado){
                            if($usado == $escudo->id){
                                $disponible = false;
                                break;
                            }
                        }
                        if($disponible){
                            DB::beginTransaction();
                            try {
                                $equipo = new Equipo();
                                $equipo->nombre = $request->nombreEquipo;
                                $equipo->genero = $torneo->genero;
                                $equipo->capitan_id = \Auth::user()->id;
                                $equipo->escudo_id = $escudo->id;
                                $equipo->save();

                                $insertados = true;
                                foreach (explode(",", $request->jugadores) as $jugador) {
                                    $respuesta = $this->insertJugador($jugador, $equipo->id);
                                    if(!$respuesta['estado'])
                                        $insertados = false;
                                }

                                $equipo_torneo = new Equipos_torneo();
                                $equipo_torneo->torneo_id = $torneo->id;
                                $equipo_torneo->equipo_id = $equipo->id;
                                $equipo_torneo->estado = 'A';
                                $equipo_torneo->save();

                                $codigo[0]->estado = 'I';
                                $codigo[0]->save();
                                DB::commit();

                                if($insertados)
                                    return ['estado' => true, 'mensaje' => $equipo_torneo, 'jugadores' => 'completos'];
                                else
                                    return ['estado' => true, 'mensaje' => $equipo_torneo, 'jugadores' => 'faltaron'];
                            } catch (\Exception $e) {
                                DB::rollBack();
                                return ['estado' => false, 'mensaje' => "Ha ocurrido el siguiente error: " . $e->getMessage()];
                            }
                        }
                        else
                            return ['estado' => false, 'mensaje' => "El escudo seleccionado no esta disponible, por favor selecciona otra e intentalo de nuevo."];
                    }
                    else
                        return ['estado' => false, 'mensaje' => "Escudo no valido, por favor intentalo de nuevo."];
                }
                else
                    return ['estado' => false, 'mensaje' => "No puedes inscribir el equipo actual, pues ya eres propietario del equipo $jugador->nombre de este torneo."];
            }
            else
                return ['estado' => false, 'mensaje' => "No puedes inscribir este equipo, pues ya participas como jugador del equipo $jugador->nombre en este torneo."];
        }
        else
            return ['estado' => false, 'mensaje' => "El codigo que usas para inscribirte al torneo no es valido, por favor cambialo e intentalo de nuevo."];

    }
}

