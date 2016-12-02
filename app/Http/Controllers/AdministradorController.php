<?php

namespace App\Http\Controllers;

use App\Galeria;
use App\Cancha;
use App\Horario;
use App\Municipio;
use App\Persona;
use App\Reserva;
use App\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Sitio;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\HttpFoundation\File\File;

header("Content-Type: text/html;charset=utf-8");

class AdministradorController extends Controller
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sitio = \Auth::user()->getSitio;
        $sitio->info_adicional = html_entity_decode($sitio->info_adicional, ENT_COMPAT);
        $fotos = Galeria::where('id_sitio', $sitio->id)->get();
        $portada = array();
        $galeria = array();
        foreach ($fotos as $foto) {
            if ($foto->tipo == "portada")
                array_push($portada, $foto);
            else
                array_push($galeria, $foto);
        }
        $horario = Horario::where('id_sitio', $sitio->id)->first();
        $horario->semana = $this->convertirHorario($horario->semana);
        $horario->sabado = $this->convertirHorario($horario->sabado);
        $horario->festivo = $this->convertirHorario($horario->festivo);

        /*        if ($sitio->geolocalizacion == "") {
                    $config = array();
                    $config['center'] = 'auto';
                    $config['onclick'] = 'marker_0.setOptions({
                        position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
                    });
                    $("#getinfo").text( event.latLng.lat() + \',\' + event.latLng.lng());';
                    $config['onboundschanged'] = 'if (!centreGot) {
                    var mapCentre = map.getCenter();
                    marker_0.setOptions({
                        position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
                    });
                    }
                    centreGot = true;';
                    \Gmaps::initialize($config);

                    // set up the marker ready for positioning   AIzaSyDfAkQfWbTfV2wDE06kaR1UlynH34WrPNs
                    // once we know the users location
                    $marker = array();
                    $marker['draggable'] = true;
                    $marker['ondragend'] = '$("#getinfo").text( event.latLng.lat() + \',\' + event.latLng.lng());';
                    \Gmaps::add_marker($marker);
                    $map = \Gmaps::create_map();
                }
                else
                {
                    //dd("dsd");
                    $config = array();
                    $config['center'] = $sitio->geolocalizacion;
                    $config['onclick'] = 'marker_0.setOptions({
                        position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
                    });
                    $("#getinfo").text( event.latLng.lat() + \',\' + event.latLng.lng());';
                    $config['zoom'] = 'auto';

                    \Gmaps::initialize($config);

                    // set up the marker ready for positioning   AIzaSyDfAkQfWbTfV2wDE06kaR1UlynH34WrPNs
                    // once we know the users location
                    $marker = array();
                    $marker['draggable'] = true;
                    $marker['position'] = $sitio->geolocalizacion;
                    $marker['ondragend'] = '$("#getinfo").text( event.latLng.lat() + \',\' + event.latLng.lng());';
                    \Gmaps::add_marker($marker);
                    $map = \Gmaps::create_map();
                }*/

        $municipio = Municipio::find($sitio->id_municipio);

//dd($municipio);
        return view('administrador.index', compact("sitio", "portada", "galeria", "horario", "municipio"));
    }

    public static function convertirHorario($horario)
    {
        if ($horario != "") {
            $arrayHoras = explode('-', $horario);
            $horario = $arrayHoras[0] . "h - " . $arrayHoras[1] . "h";
        }
        return $horario;
    }

    public function editarDescripcion(Request $request)
    {
        $sitio = Sitio::find($request->input('id'));
        $sitio->info_adicional = ($request->input('infoAdicional'));
        $sitio->save();
        return $sitio->info_adicional;
    }

    public function deleteImage(Request $request)
    {
        $affectedRows = Galeria::where('id', $request->input('id'))->delete();
//        Galeria::destroy($request->input('id'));
        if ($affectedRows > 0) {
            unlink('images/' . utf8_decode($request->input('ruta')));
            return "exito";
        } else {
            return "error";
        }
    }

    public function editHorarios()
    {
        $id_sitio = \Auth::user()->getSitio->id;
        $objReservas = new Reserva();
        $reservas = $objReservas->getReservasXSitio($id_sitio);
        $cantidad = count($reservas);
        if ($cantidad == 0) {
            $horario = Horario::where('id_sitio', $id_sitio)->first();
            return view("administrador/modalHorarios", compact("horario"));
        } else {
            return view("administrador/errorHorario", compact("cantidad"));
        }
    }

    public function updateHorario(Request $request)
    {
        $id_sitio = \Auth::user()->getSitio->id;
        $horario = Horario::where('id_sitio', $id_sitio)->first();

        if ($request->c1)
            $horario->semana = "";
        else if ($request->input('11') && $request->input('12'))
            $horario->semana = explode(':', $request->input('11'))[0] . "-" . explode(':', $request->input('12'))[0];

        if ($request->c2)
            $horario->sabado = "";
        else if ($request->input('21') && $request->input('22'))
            $horario->sabado = explode(':', $request->input('21'))[0] . "-" . explode(':', $request->input('22'))[0];

        if ($request->c3)
            $horario->festivo = "";
        else if ($request->input('31') && $request->input('32'))
            $horario->festivo = explode(':', $request->input('31'))[0] . "-" . explode(':', $request->input('32'))[0];

        $horario->save();

        return array('semana' => $this->convertirHorario($horario->semana), 'sabado' => $this->convertirHorario($horario->sabado), 'festivo' => $this->convertirHorario($horario->festivo));
    }

    public function subirImagen(Request $request)
    {
        $fotos = $request->file('inputGalery');

        if ($fotos != null) {
            $fotos = $fotos[0];
            $sitio = str_replace(' ', '', $request->sitio);

            $extension = explode(".", $fotos->getClientOriginalName());
            $cantidad = count($extension) - 1;
            $extension = $extension[$cantidad];
            $nombre = $sitio . time() . $request->file_id . "." . $extension;

            $fotos->move('images', utf8_decode($nombre));

            $galeria = new Galeria();
            $galeria->id_sitio = $request->id;
            $galeria->foto = $nombre;
            $galeria->save();

            return json_encode(array('ruta' => $nombre, 'id' => $galeria->id));
        } else
            return json_encode(array('error' => 'Archivo no permitido'));
    }

    public function updateProfilePic(Request $request)
    {
        $portada = $request->file('avatar-1');
        $avatar = $portada;
        $sitio = str_replace(' ', '', $request->sitio);

        $extension = explode(".", $portada->getClientOriginalName());
        $cantidad = count($extension) - 1;
        $extension = $extension[$cantidad];
        $nombre = $sitio . time() . "PP." . $extension;

        if ($request->actual != "DefaultProfile.jpg") {
            unlink('images/' . utf8_decode($request->actual));
        }
        $portada->move('images', utf8_decode($nombre));


        $objGaleria = Galeria::find($request->id);
        $objGaleria->foto = $nombre;
        $objGaleria->save();

        \Auth::user()->update(["avatar" => $nombre]);
//        dd("images/".$nombre);
        return json_encode(array('nueva' => $nombre));
    }

    public function updateUbicacion(Request $request)
    {
//        dd($request->all());
        $sitio = \Auth::user()->getSitio;
        $sitio->geolocalizacion = $request->posicion;
        $sitio->direccion = $request->direccion;
        $sitio->save();
        return "exito";
    }

    public function getTotalGaleria(Request $request)
    {
        $totalGaleria = Galeria::where('id_sitio', $request->id)->count();
        return $totalGaleria;

    }

    /**
     * esta funcion esta encargada de lanzar la vista para la parte de administracion de canchas
     *
     * @return vista y array (array de canchas)
     */
    public function adminCanchas()
    {
        $canchas = \Auth::user()->getSitio->getCanchas;
        $arrayCanchas = array();


        foreach ($canchas as $cancha) {
            $arrayPadre = array();
            if ($cancha->id_padre == 0) {

                $arrayPadre["padre"] = $this->arrayInfo($cancha);
                $arraryHijo = array();
                foreach ($canchas as $canchahija) {
                    if ($canchahija->id_padre == $cancha->id) {
                        $arraryHijo[] = $this->arrayInfo($canchahija);
                    }
                }
                $arrayPadre["hijo"] = $arraryHijo;
                $arrayCanchas[] = $arrayPadre;
            }
        }
        //dd($arrayCanchas);

        $data["arrayCanchas"] = $arrayCanchas;


        return view('administrador.canchas', $data);
    }

    /**
     * esta funcion cumple con la funcion de crear la estructura necesaria para la informacion de unba cancha
     *
     * @param \Cancha $cancha
     *
     * @return array
     */
    protected function arrayInfo($cancha)
    {
        $arrayInfo = array();
        $arrayInfo["id"] = $cancha->id;
        $arrayInfo["id_sitio"] = $cancha->id_sitio;
        $arrayInfo["nombre"] = $cancha->nombre;
        $arrayInfo["tipo"] = $cancha->tipo;
        $arrayInfo["foto"] = $cancha->foto;
        $arrayInfo["precio_base"] = $cancha->precio_base;
        $arrayInfo["precio_nocturno"] = $cancha->precio_nocturno;
        $arrayInfo["precio_festivo"] = $cancha->precio_festivo;
        $arrayInfo["descripcion"] = $cancha->descripcion;

        return $arrayInfo;

    }

    /**
     * esta funcion es la encargada de actualizar la informacion de una cancha como (nombre, precios, describion)
     *
     * @param  \Illuminate\Http\Request $request
     * @return array $resultado
     */
    public function addInfoCanchas(Request $request)
    {
        //dd($request->all());
        $cancha = Cancha::find($request->id);

        $cancha->nombre = $request->input('nombre');
        $cancha->precio_base = str_replace(".", "", $request->precio_base);
        $cancha->precio_nocturno = str_replace(".", "", $request->precio_nocturno);
        $cancha->precio_festivo = str_replace(".", "", $request->precio_festivo);
        $cancha->descripcion = $request->descripcion;

        $cancha->save();

        $resultado["estado"] = true;
        $resultado["mensaje"] = "no hay";

        return $resultado;
    }

    /**
     * @return string
     */
    public function updateImagenCancha(Request $request)
    {
        $portada = $request->file('avatar-1');

        $extension = explode(".", $portada->getClientOriginalName());
        $cantidad = count($extension) - 1;
        $extension = $extension[$cantidad];
        $nombre = time() . "PP." . $extension;

        if ($request->actual != "DefaultCancha.jpg")
            unlink("images/" . $request->actual);
        $portada->move('images', utf8_decode($nombre));

        $objCancha = Cancha::find($request->id);
        $objCancha->foto = $nombre;
        $objCancha->save();
//        dd("images/".$nombre);
        return json_encode(array('nueva' => $nombre, 'id' => $request->id));
    }

    /**
     * esa funcion tiene como tarea retornar la vista de disponibilidades de las canchas
     *
     * @return vista
     */
    public function disponibilidades()
    {
        $date = Carbon::now();

        $canchas = \Auth::user()->getSitio->getCanchas;
        //dd($date->format('Y-m-d'));

        $arrayCanchas = array();
        $infoCancha = array();

        foreach ($canchas as $cancha) {
            $infoCancha[] = $cancha->descripcion;
            $arrayCanchas[$cancha->id] = [$cancha->nombre, "Futbol " . $cancha->tipo, $cancha->foto];
        }

//dd($this->disponibilidad(key($arrayCanchas),$date->format('Y-m-d') ));
        $reservas = $this->disponibilidad(key($arrayCanchas), $date->format('Y-m-d'));


        $data["arrayCanchas"] = $arrayCanchas;
        $data["hoy"] = $date->format('Y-m-d');
        $data["horaActual"] = $date->hour;
        $data["descripcion"] = $reservas["descripcion"];
        $data["responsables"] = $reservas["responsables"];
        $data["horario"] = $reservas["horario"];

//        dd($data);
        //$this->d

        return view("administrador.disponibilidad", $data);
    }

    /**
     * @return Guard
     */
    public function planilla()
    {
        $date = Carbon::now();
        $data["hoy"] = $date->format('Y-m-d');
        $info = $this->getDispCanchas($date->format('Y-m-d'));
        $data["estadoSitio"] = $info['estadoSitio'];
        $data["arrayCanchas"] = $info['arrayCanchas'];
        $data["horarios"] = $info['horarios'];
//        dd($data);
        return view("administrador.planillaHorarios", $data);
    }

    public function getPlanillas(Request $request)
    {
        $info = $this->getDispCanchas($request->fecha);
        $data["estadoSitio"] = $info['estadoSitio'];
        $data["arrayCanchas"] = $info['arrayCanchas'];
        $data["horarios"] = $info['horarios'];
        return $data;

    }

    public function getDispCanchas($fecha)
    {
        $arrayHorario = $this->obtenerDiaHorario($fecha);
        $data["estadoSitio"] = ($arrayHorario[0] == "") ? "cerrado" : "abierto";

        $arrayCanchas = array();
        $canchas = \Auth::user()->getSitio->getCanchas;
        foreach ($canchas as $cancha) {
            $arrayCanchas[$cancha->id] = [$cancha->nombre . "<br>Futbol " . $cancha->tipo . "", $this->disponibilidad($cancha->id, $fecha)];
        }
        $data["arrayCanchas"] = $arrayCanchas;
        $arrayHorario = array();
        foreach (array_values($arrayCanchas)[0][1]['responsables'] as $hora => $responsable) {
            $arrayHorario[$hora] = "";
        }
        $data["horarios"] = $arrayHorario;

        return $data;
    }

    /**
     * disponibilidad metodo interno para obtener la descripcion
     * de una cancha y sus responsables en las reservas por horas
     * @param  int $idCancha
     * @param  string $fecha de la cancha
     * @return array con informacion de la cancha
     */
    protected function disponibilidad($idCancha, $fecha)
    {
        $cancha = Cancha::select("descripcion")->where("id", $idCancha)->first();
        $data["descripcion"] = $cancha->descripcion;
        $arrayHorario = $this->obtenerDiaHorario($fecha);
        if ($arrayHorario[0] == "") {
            $data["horario"] = "cerrado";
            $data["responsables"] = [];
        } else {
            $data["horario"] = "abrido";
            $horaInicio = intval($arrayHorario[0]);
            $horaFin = intval($arrayHorario[1]);

            $responsables = array();
            if ($horaInicio < $horaFin) {
                for ($i = $horaInicio; $i < $horaFin; $i++) {
                    $responsables[strval($i)] = [];
                }
            } else {
                for ($i = $horaInicio; $i <= 23; $i++) {
                    $responsables[" " . strval($i)] = [];
                }
                for ($i = 0; $i < $horaFin; $i++) {
                    $responsables[" " . strval($i)] = [];
                }
            }
            $reservas = Reserva::where("id_cancha", $idCancha)->where("fecha", $fecha)->where('estado', "!=", "I")->get();
            foreach ($reservas as $reserva) {
                //dd($reserva->getToken->getUsuario->getPersona->nombres);
                $responsables[$reserva->hora] = [$reserva->id_token, $reserva->responsable, $reserva->id];
            }
            $data["responsables"] = $responsables;
        }
        return $data;

    }

    public function obtenerDiaHorario($fecha)
    {
        $horario = Horario::where("id_sitio", \Auth::user()->getSitio->id)->first();
        $array_dias = ['Sunday' => "D", 'Monday' => "L", 'Tuesday' => "M", 'Wednesday' => "M", 'Thursday' => "J", 'Friday' => "V", 'Saturday' => "S"];

        if ($array_dias[date('l', strtotime($fecha))] == "D" || $this->esFestivo($fecha)) {
            $arrayHorario = explode("-", $horario->festivo);
        } elseif ($array_dias[date('l', strtotime($fecha))] == "S") {
            $arrayHorario = explode("-", $horario->sabado);
        } else {
            $arrayHorario = explode("-", $horario->semana);
        }
        return $arrayHorario;
    }

    /**
     *Funcion para determinar si un dia de una fecha es festivo pero solo los dias que ya estan en el array de festivos
     * @param  String $fecha
     * @return boolean bandera
     */
    public static function esFestivo($fecha)
    {

        $bandera = false;

        $arrayfestivos = array("2016-10-17", "2016-11-7", "2016-11-14", "2016-12-8");

        foreach ($arrayfestivos as $arrayfestivo) {
            if ($arrayfestivo == $fecha) {
                $bandera = true;
            }
        }

        return $bandera;
    }

    /**
     *funcion encargada de retornar las reservas realizadas a una cancha en una fecha especifica
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function getDisponibilidad(Request $request)
    {
        $reservas = $this->disponibilidad($request->input("id_cancha"), $request->input("fecha"));

        return $reservas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addNuevaReserva(Request $request)
    {
        $reserva = new Reserva($request->all());
        $reserva->id_token = \Auth::user()->getToken->id;
        $reserva->estado = "A";
        $reserva->save();

        if ($reserva->getCancha->id_padre == 0) {
            $canchas = Cancha::select("id")->where("id_padre", $reserva->getCancha->id)->get();
            foreach ($canchas as $cancha) {
                $reservas = new Reserva($request->all());
                $reservas->id_cancha = $cancha->id;
                $reservas->responsable = $reserva->getCancha->nombre;
                $reservas->id_token = \Auth::user()->getToken->id;
                $reservas->estado = "";
                $reservas->save();
            }
        } else {
            $reser = Reserva::where("id_cancha", $reserva->getCancha->id_padre)->where("fecha", $request->input("fecha"))->where("hora", $request->input("hora"))->first();

            if ($reser == "" || $reser == null) {
                $reservas = new Reserva($request->all());
                $reservas->id_cancha = $reserva->getCancha->id_padre;
                $reservas->responsable = $reserva->getCancha->nombre . " (Futbol " . $reserva->getCancha->tipo . ")";
                $reservas->id_token = \Auth::user()->getToken->id;
                $reservas->estado = "";
                $reservas->save();
            } else {

                $reser->responsable = $reser->responsable . " y " . $reserva->getCancha->nombre;
                $reser->save();
            }
        }
        return "exito";
    }


    /**
     * @return string
     */
    public function infoCancelarReserva(Request $request)
    {
        return $this->infCancelarReserva($request->cancha, $request->fecha, $request->hora);
    }


    /**
     * esta funcion se encarga de retornar la informacion del estado de la reserva de la cancha para poder
     * quitar la reverva de todas las canchas afectadas por esta reserva
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public static function infCancelarReserva($id_cancha, $fecha, $hora)
    {

        $respuesta = array();
        $reservas = Reserva::where("id_cancha", $id_cancha)->where("fecha", $fecha)->where("hora", $hora)->get();


        foreach ($reservas as $reserva) {
            if ($reserva->estado == "A") {
                $respuesta["ids"][] = $reserva->id;
                $respuesta["responsable"][] = $reserva->responsable;

                $respuesta["mensaje"][] = AdministradorController::notificarOllamar($reserva);

                if ($reserva->getCancha->id_padre == 0) {
                    $canchasHijas = Cancha::where("id_padre", $reserva->id_cancha)->get();
                    foreach ($canchasHijas as $canchaHija) {
                        $reserva = Reserva::where("id_cancha", $canchaHija->id)->where("fecha", $fecha)->where("hora", $hora)->where("estado", "")->first();
                        $respuesta["ids"][] = $reserva->id;
                    }
                } else {
                    $canchaActual = Cancha::select("id_padre")->where("id", $reserva->id_cancha)->first();
                    $canchaHermana = Cancha::where("id_padre", $canchaActual->id_padre)->whereNotIn('id', [$reserva->id_cancha])->first();

                    $reservaHermana = Reserva::where("id_cancha", $canchaHermana->id)->where("fecha", $fecha)->where("hora", $hora)->where("estado", "A")->first();

                    if ($reservaHermana == null) {
                        $reserva = Reserva::where("id_cancha", $canchaActual->id_padre)->where("fecha", $fecha)->where("hora", $hora)->where("estado", "")->first();
                        $respuesta["ids"][] = $reserva->id;
                    }
                    //$respuesta["nose"]= $reservaHermana;
                }

            } elseif ($reserva->estado == "") {
                //$respuesta["ids"][]=$reserva->id;

                if ($reserva->getCancha->id_padre == 0) {

                    $canchasHijas = Cancha::where("id_padre", $reserva->id_cancha)->get();
                    $respuesta["ids"][] = $reserva->id;
                    foreach ($canchasHijas as $canchaHija) {

                        $reserva = Reserva::where("id_cancha", $canchaHija->id)->where("fecha", $fecha)->where("hora", $hora)->where("estado", "A")->first();

                        if ($reserva == null) {
                            continue;
                        }
                        $respuesta["responsable"][] = $reserva->responsable;
                        $respuesta["ids"][] = $reserva->id;
                        $respuesta["mensaje"][] = AdministradorController::notificarOllamar($reserva);
                    }
                } else {

                    $canchaActual = Cancha::select("id_padre")->where("id", $reserva->id_cancha)->first();

                    $canchasHijas = Cancha::where("id_padre", $canchaActual->id_padre)->get();

                    $reserva = Reserva::where("id_cancha", $canchaActual->id_padre)->where("fecha", $fecha)->where("hora", $hora)->where("estado", "A")->first();
                    $respuesta["ids"][] = $reserva->id;
                    $respuesta["responsable"][] = $reserva->responsable;

                    $respuesta["mensaje"][] = AdministradorController::notificarOllamar($reserva);

                    foreach ($canchasHijas as $canchaHija) {
                        $reserva = Reserva::where("id_cancha", $canchaHija->id)->where("fecha", $fecha)->where("hora", $hora)->where("estado", "")->first();
                        $respuesta["ids"][] = $reserva->id;
                    }

                }

            }
        }

        return $respuesta;
    }

    /**
     * @return Guard
     */
    public static function notificarOllamar($reserva)
    {

        if (\Auth::user()->getToken->id == $reserva->id_token) {
            return "No se puede notificar al responsable de esta reserva Favor llamar al " . $reserva->telefono;
        } else {
            return "El Usuario recibira un correo con la CANCELACION de la reserva";
        }

    }

    /**
     * @return string
     */
    public function cancelarReserva(Request $request)
    {
        DB::beginTransaction();
        try {
            $idtoken = 0;
            foreach ($request->ids as $id) {

                $reserva = Reserva::find($id);
                $reserva->estado = "I";
                $reserva->save();

                if ($idtoken != $reserva->id_token) {
                    $idtoken = $reserva->id_token;

                    $token = Token::find($idtoken);

                    $user = $token->getUsuario;

                    $data["cancha"] = $reserva->getCancha->nombre;
                    $data["tipo"] = $reserva->getCancha->tipo;
                    $data["sitio"]= $reserva->getCancha->getSitio->nombre;
                    $data["email"] = $user->email;
                    $data["user"] = $user->user;
                    $data["fecha"] = $reserva->fecha;;
                    $data["hora"] = $reserva->hora;
                    $data["nombres"] = $token->getUsuario->getPersona->nombres;

                    MailController::cancelarReserva($data);
                }

            }
            DB::commit();

            $respuesta["estado"] = true;

            return $respuesta;
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * esta funcion se encarga de actualizar el estado de un TOKEN asignado
     *
     * @param  \Illuminate\Http\Request $request
     * @return String
     */
    public function retirarToken(Request $request)
    {

        $token = Token::find($request->input("id_token"));
        $token->estado = "I";
        $token->motivo = $request->input("motivos");
        $token->save();

        return "eliminado";
    }

    /**
     *
     * esta funcion lanza la vista para administrar los TOKENS
     *
     * @return vista
     */
    public function adminTokens()
    {

//dd(\Auth::user()->id);

        $tokens = Token::where("id_sitio", \Auth::user()->getSitio->id)
            ->where("estado", "A")
            ->whereNotIn('id_usuario', [\Auth::user()->id])
            ->paginate(10);

        return view("administrador.adminTokens", compact("tokens"));
    }

    /**
     * funcion para buscar un Usuario bien sea por usuario o por numero de documento
     *
     * @param  \Illuminate\Http\Request $request
     * @return \User $usuario
     */
    public function buscarAddToken(Request $request)
    {
        $usuarios = User::where("user", $request->input("user"))->first();


        //dd(count($usuarios));
        if (count($usuarios) > 0) {
            $data["bandera"] = true;
            $data["id"] = $usuarios->id;
            $data["nombre"] = $usuarios->getPersona->nombres;
            //$usuarios=$usuarios->id;
        } else {
            $persona = Persona::where("identificacion", $request->input("user"))->first();
            //dd($persona);
            if ($persona != null) {
                $data["bandera"] = true;
                $data["id"] = $persona->getUsuario->id;
                $data["nombre"] = $persona->nombres;
                //$usuarios= $persona->getUsuario->id;
            } else {
                $data["bandera"] = false;
                $usuarios = "noexiste";
            }
        }

        return $data;
    }

    /**
     * funcion encargada de crear un registro para asignar un token con su estado "A" de activo
     *
     * @param  \Illuminate\Http\Request $request
     * @return array $infoToken
     */
    public function addToken(Request $request)
    {
        $date = Carbon::now();

        //dd(\Auth::user()->getSitio->id);

        $token = new Token($request->all());
        $token->fecha = $date->format('Y-m-d');
        $token->id_sitio = \Auth::user()->getSitio->id;
        $token->estado = "A";

        $token->save();

        $infoToken = array();
        $infoToken["id"] = $token->id;
        $infoToken["nombre"] = $token->getUsuario->getPersona->nombres;
        $infoToken["fecha"] = $token->fecha;
        $infoToken["tipo"] = $token->tipo;
        $infoToken["id_user"] = $token->getUsuario->id;


        return $infoToken;

    }

    /**
     * esta funcion busca los tokens perdidos por el usuariio en un sitio determinado
     *
     * @param  int $id
     * @return \Token $token
     */
    public function infoToken($id)
    {

        $token = Token::select("motivo", "fecha")->where("id_sitio", \Auth::user()->getSitio->id)
            ->where("estado", "I")
            ->where('id_usuario', $id)
            ->get();

        return $token;
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request $request
     * @return array $arrayUsuarios
     */
    public function autoCompleUsuarios(Request $request)
    {
        $usuarios = User::where("user", "like", "%" . $request->input("nombre") . "%")->where('rol', 'jugador')->get();

        $arrayUsuarios = array();
        foreach ($usuarios as $usuario) {
            $arrayUsuarios[] = $usuario->user;
        }
        return $arrayUsuarios;
    }

    public function updateServicio(Request $request)
    {
        $sitio = \Auth::user()->getSitio;
        if ($request->accion == "agregar")
            if ($sitio->servicios != "")
                $sitio->servicios = $sitio->servicios . ',' . $request->servicio;
            else
                $sitio->servicios = $sitio->servicios . $request->servicio;
        else {

            $arrayServicios = explode(',', $sitio->servicios);
            $sitio->servicios = "";
            foreach ($arrayServicios as $servicio) {
                if ($servicio != $request->servicio) {
                    if ($sitio->servicios != "")
                        $sitio->servicios = $sitio->servicios . ',' . $servicio;
                    else
                        $sitio->servicios = $sitio->servicios . $servicio;
                }

            }
        }
//        dd($sitio->servicios);
        $sitio->save();
        return ("exito");
    }

    public function updateRedes(Request $request)
    {
        $sitio = \Auth::user()->getSitio;
        $sitio->facebook = $request->facebook;
        $sitio->twitter = $request->twitter;
        $sitio->save();
        return "exito";
    }

}
