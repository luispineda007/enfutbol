<?php

namespace App\Http\Controllers;

use App\Galeria;
use App\Sitio;
use App\Cancha;
use App\Reserva;
use App\Horario;
use App\User;
use Carbon\Carbon;
use GeneaLabs\Phpgmaps\Phpgmaps;
use GeneaLabs\Phpgmaps\PhpgmapsServiceProvider;
use Illuminate\Http\Request;
use App\Municipio;
use App\Token;
use App\Departamento;
use App\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\Http\Requests;
use App\Http\Requests\userRequest;

use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{


    private $array_dias = ['Sunday' => "D", 'Monday' => "L", 'Tuesday' => "M", 'Wednesday' => "M", 'Thursday' => "J", 'Friday' => "V", 'Saturday' => "S"];


    /**
     * @return string
     */
    public function index()
    {

        $config = array();
        $arraySitios = array();
        $config['center'] = '4.1349015 , -73.62390519999997';
        $config['zoom'] = 'auto';

        \Gmaps::initialize($config);

        $sitios = Sitio::where("estado_pago", "A")->where("geolocalizacion", "!=", "")->get();


        foreach ($sitios as $sitio) {


            $arraySitio = array();
            $arraySitio["id_sitio"] = $sitio->id;
            $arraySitio["nombre"] = $sitio->nombre;
            $arraySitio["dispo"] = "";
            $arraySitio["ciudad"] = $sitio->getMunicipio->municipio;
            $arraySitio["portada"] = Galeria::select("foto")->where("id_sitio", $sitio->id)->first()->foto;
            $arraySitios[] = $arraySitio;


            $marker = array();
            $marker['position'] = $sitio->geolocalizacion;
            $marker['infowindow_content'] = '<h3 style="margin-bottom: 10px"> ' . $sitio->nombre . '</h3> Horario: Lunes a viernes 06:00 a 22:00 ';
            $marker['icon'] = 'dist/img/taggris1.png';
            \Gmaps::add_marker($marker);

        }//4.141921265452564,73.63386155986325    4.137330099981702,-73.61291857187501

        $data["sitios"] = $arraySitios;
        $data["map"] = \Gmaps::create_map();


        return view("home", $data);
    }

    public function registrarJugador()
    {
        $departamentos = Departamento::select('id', 'departamento')->get();
        $arrayDepartamento = array();
        foreach ($departamentos as $departamento) {
            $arrayDepartamento[$departamento->id] = $departamento->departamento;
        }
        return view('jugador.registro', compact('arrayDepartamento'));
    }

    public function addJugador(userRequest $request)
    {
        //dd($request->all());
        
        $user = new User($request->all());
        $user->password = bcrypt($request->contrasena);
        $user->rol = "jugador";
        $user->activado="N";
        $user->avatar = "avatar4.png";
        $user->save();
        
        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $request->_token, 'created_at' => Carbon::now()]
        );
        
        //MailController::ConfirmarRegistroU($request->all());
        MailController::activarCUser(["email"=>$user->email,"ruta"=>route("activarUser",$this->encriptar($user->email))]);
        return "exito";
    }

    /**
     * @return string
     */
    public function activarUser($email){

        $user = User::where("email",$this->desencriptar($email))->first();
        //dd($user);
        $data["titulo"]="Activación de Cuenta";
        if($user!=null){
            if($user->activado=="N"){
                $user->update(['activado' => "S"]);
                $persona = new Persona();
                $persona->user_id=$user->id;
                $persona->id_municipio="1113";
                $persona->save();

                //Auth::login($user);
                $data["tipo"]="success";
                $data["tmsj"]="Perfecto";
                $data["msj"]=$user->user.", tu cuenta fue activada satisfactoriamente. <strong>Inicia sesión</strong> y reserva las mejores canchas de la ciudad";
            }else{
                $data["tipo"]="warning";
                $data["tmsj"]="Umm";
                $data["msj"]=$user->user.", tu cuenta ya se encontraba activa. <strong>Inicia sesión</strong> y reserva las mejores canchas de la ciudad";

            }
            return view('jugador.activarUser', $data);
        }else{
            $data["tipo"]="danger";
            $data["tmsj"]="Ups";
            $data["msj"]="No es posible ";
            return view('jugador.activarUser', $data);
        }



    }
    
    
    
    public function encriptar($string){
        $key='enfutbol123*';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }

    public function desencriptar($cadena){
        $key='enfutbol123*';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $result = '';
        $string = base64_decode($cadena);
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }
    /**
     * @return string
     */
    public function buscar()
    {
        $arraySitios = array();
        $sitios = Sitio::where("estado_pago", "A")->get();
        //dd($sitios);
        foreach ($sitios as $sitio) {
            $arraySitio = array();
            $arraySitio["id_sitio"] = $sitio->id;
            $arraySitio["nombre"] = $sitio->nombre;
            $arraySitio["dispo"] = "";
            $arraySitio["ranking"] = rand(1, 5);
            $arraySitio["portada"] = Galeria::select("foto")->where("id_sitio", $sitio->id)->first()->foto;
            $arraySitios[] = $arraySitio;
        }


        $data["tipo"] = "";
        $data["fecha"] = "";
        $data["hora"] = "";
        $data["sitios"] = $arraySitios;


        //dd($data);

        return view('jugador.buscar', $data);
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCanchasBusqueda(Request $request)
    {


        $array_dias = ['Sunday' => "D", 'Monday' => "L", 'Tuesday' => "M", 'Wednesday' => "M", 'Thursday' => "J", 'Friday' => "V", 'Saturday' => "S"];
        $canchas = Cancha::select("id_sitio", \DB::raw('COUNT(id_sitio) AS canchas'))->where("tipo", $request->tipo)->groupBy('id_sitio')->get();


        // dd($canchas);

        $arraySitios = array();

        foreach ($canchas as $cancha) {
            // dd($cancha);
            if ($cancha->getSitio->estado_pago == "A") {

                if ($cancha->getSitio->getHorario != null) {

                    $arraySitio = array();

                    if ($array_dias[date('l', strtotime($request->fecha))] == "D" || $this->esFestivo($request->fecha)) {
                        //festivo
                        if ($cancha->getSitio->getHorario->festivo == "") {
                            continue;
                        }
                        if (!$this->validarHoraDentroRango($cancha->getSitio->getHorario->festivo, $request->hora)) {
                            continue;
                        }
                    } elseif ($array_dias[date('l', strtotime($request->fecha))] == "S") {
                        //sabado
                        if ($cancha->getSitio->getHorario->sabado == "") {
                            continue;
                        }
                        if (!$this->validarHoraDentroRango($cancha->getSitio->getHorario->sabado, $request->hora)) {
                            continue;
                        }
                    } else {
                        //entre semana
                        if ($cancha->getSitio->getHorario->semana == "") {
                            continue;
                        }
                        if (!$this->validarHoraDentroRango($cancha->getSitio->getHorario->semana, $request->hora)) {
                            continue;
                        }
                    }

                    $objDispoReservas = new Reserva();
                    $dispoReservas = $objDispoReservas->getNumCanchasDispoXTipo($cancha->id_sitio, $request->tipo, $request->fecha, $request->hora);
                    //$arraySitio["id"] = $cancha;

                    if ($cancha->canchas - $dispoReservas->disponibles == 0) {
                        continue;
                    }
                    $arraySitio["id_sitio"] = $cancha->id_sitio;
                    $arraySitio["nombre"] = $cancha->getSitio->nombre;
                    $arraySitio["dispo"] = ($cancha->canchas - $dispoReservas->disponibles);
                    $arraySitio["portada"] = Galeria::select("foto")->where("id_sitio", $cancha->id_sitio)->first()->foto;
                    $arraySitio["ranking"] = "";
                    $arraySitios[] = $arraySitio;
                }
            }
        }

        $data["sitios"] = $arraySitios;
        $data["tipo"] = $request->tipo;
        $data["fecha"] = $request->fecha;
        $data["hora"] = $request->hora;


        if ($request->ajax)
            return $data;
        else
            return view('jugador.buscar', $data);

    }

    /**
     * @param  String $horario
     * @param  String $hora
     *
     * validar si la hora ingresada esta en el rango de hora de funcionamineto del establecimineto
     * Si la hora esta en el fango la funcion retorna un TRUE de lo contrario un false
     *
     * @return boolean
     */
    public static function validarHoraDentroRango($horario, $hora)
    {

        $bandera = false;
        if ($horario != "") {
            $arrayHorario = explode("-", $horario);
            $horaInicio = intval($arrayHorario[0]);
            $horaFin = intval($arrayHorario[1]);
            $hora = intval($hora);

            if ($horaInicio < $horaFin) {
                if ($horaInicio <= $hora && $horaFin > $hora) {
                    $bandera = true;
                }
            } else {
                if (($horaInicio <= $hora && 23 >= $hora) || (0 <= $hora && $horaFin > $hora)) {
                    $bandera = true;
                }
            }
        }
        return $bandera;
    }

    /**
     *Funcion para determinar si un dia de una fecha es festivo pero solo los dias que ya estan en el array de festivos
     * @param  String $fecha
     * @return boolean bandera
     */
    public function esFestivo($fecha)
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
     * @return string
     */
    public function getCanchaXtipo(Request $request)
    {
        $tipo = $request->tipo;
        $date = Carbon::now();
        $id_sitio = $request->sitio;

        $canchas = Cancha::where("id_sitio", $id_sitio)->where("tipo", $tipo)->get();

        $data["canchas"] = $canchas;
        $data["horaActual"] = $date->hour;
        $data["hoy"] = $date->format('Y-m-d');

        //dd($canchas);

        return view('jugador.canchasXtipo', $data);
    }

    /**
     * disponibilidad metodo interno para obtener la descripcion
     * de una cancha y sus responsables en las reservas por horas
     * @param  int $idCancha
     * @param  string $fecha de la cancha
     * @return array con informacion de la cancha
     */
    public function disponibilidad(Request $request)
    {
        $data = array();
        $fechaHoy = Carbon::now();
        $cancha = Cancha::where("id", $request->id)->first();

        $horario = Horario::where("id_sitio", $cancha->id_sitio)->first();

        if ($request->fecha) {
            $fecha = explode("-", $request->fecha);
            $objFecha = Carbon::create($fecha[0], $fecha[1], $fecha[2], 0);
        } else {
            $objFecha = Carbon::now();

        }


        //dd($date);


        //$array_dias =['Sunday' => "D", 'Monday' => "L", 'Tuesday' => "M", 'Wednesday' => "M", 'Thursday' => "J", 'Friday' => "V", 'Saturday' => "S"];


        for ($j = 1; $j <= 3; $j++) {


            if ($fechaHoy->diffInDays($objFecha) >= 15)
                break;

            $date = $objFecha->format('Y-m-d');
            $dispo = array();

            if ($this->array_dias[date('l', strtotime($date))] == "D" || $this->esFestivo($date)) {
                $arrayHorario = explode("-", $horario->festivo);
            } elseif ($this->array_dias[date('l', strtotime($date))] == "S") {
                $arrayHorario = explode("-", $horario->sabado);
            } else {
                $arrayHorario = explode("-", $horario->semana);
            }

            $dispo["fecha"] = $date;
            $dispo["festivo"] = ($this->array_dias[date('l', strtotime($date))] == "D" || $this->esFestivo($date));


            if ($arrayHorario[0] == "") {
                $dispo["horario"] = "cerrado";
                $dispo["reservas"] = [];
            } else {
                $dispo["horario"] = "abierto";
                $horaInicio = intval($arrayHorario[0]);
                $horaFin = intval($arrayHorario[1]);

                $responsables = array();
                if ($horaInicio < $horaFin) {
                    for ($i = $horaInicio; $i < $horaFin; $i++) {
                        $responsables[strval($i)] = "";
                    }
                } else {
                    for ($i = $horaInicio; $i <= 23; $i++) {
                        $responsables[" " . strval($i)] = "";
                    }
                    for ($i = 0; $i < $horaFin; $i++) {
                        $responsables[" " . strval($i)] = "";
                    }
                }
                //dd($responsables);
                $reservas = Reserva::where("id_cancha", $request->id)->where("fecha", $date)->where('estado', "!=", "I")->get();

                foreach ($reservas as $reserva) {
                    //dd($reserva->getToken->getUsuario->getPersona->nombres);
                    $responsables[$reserva->hora] = "x";
                }


                $dispo["reservas"] = $responsables;
            }
            $data[($j - 1)] = $dispo;
            $objFecha->addDay();
        }

        return $data;

    }

    /**
     * @param  int $id_sitio
     * @return boolean
     */
    public static function getInfoToken($id_sitio)
    {
        $respuesta = "";
        $bandera = false;

        $token = Token::select("id", "tipo")->where("id_sitio", $id_sitio)->where("id_usuario", \Auth::user()->id)->where("estado", "A")->first();

        if ($token) {

            if ($token->tipo == "VIP") {
                $bandera = true;
            } else {
                $objReservas = new Reserva();
                $reserva = $objReservas->reservasXTokenSitio($token->id, $id_sitio);

                //dd($reserva);
                if (count($reserva) >= 1) {
                    $respuesta = "no puedes hacer más de una reserva";
                    $bandera = false;
                } else {
                    $bandera = true;
                }
            }

        } else {
            $respuesta = " no tienes un token para este sitio";
            $bandera = false;
        }

        $data["respuesta"] = $respuesta;
        $data["bandera"] = $bandera;

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function addNuevaReservaUsuario(Request $request)
    {


            $canchaSelec = Cancha::select("id_sitio")->where("id", $request->id_cancha)->first();

            if (!$this->getInfoToken($canchaSelec->id_sitio)["bandera"]) {
                $data["tipo"] = "normal";
                $data["estado"] = false;

                return $data;
            }
        DB::beginTransaction();
        try {
            $token = Token::select("id", "tipo")->where("id_sitio", $canchaSelec->id_sitio)->where("id_usuario", \Auth::user()->id)->where("estado", "A")->first();
            //dd($canchaSelec->id_sitio);


            $persona = \Auth::user()->getPersona;
            $reserva = new Reserva($request->all());
            $reserva->id_token = $token->id;
            $reserva->responsable = $persona->nombres;
            $reserva->telefono = $persona->telefono;
            $reserva->estado = "A";
            $reserva->save();

            if ($reserva->getCancha->id_padre == 0) {
                $canchas = Cancha::select("id")->where("id_padre", $reserva->getCancha->id)->get();
                foreach ($canchas as $cancha) {
                    $reservas = new Reserva($request->all());
                    $reservas->id_cancha = $cancha->id;
                    $reservas->responsable = $reserva->getCancha->nombre;
                    $reservas->id_token = $token->id;
                    $reservas->estado = "";
                    $reservas->save();
                }
            } else {
                $reser = Reserva::where("id_cancha", $reserva->getCancha->id_padre)->where("fecha", $request->input("fecha"))->where("hora", $request->input("hora"))->where("estado", "")->first();

                if ($reser == "" || $reser == null) {
                    $reservas = new Reserva($request->all());
                    $reservas->id_cancha = $reserva->getCancha->id_padre;
                    $reservas->responsable = $reserva->getCancha->nombre . " (Futbol " . $reserva->getCancha->tipo . ")";
                    $reservas->id_token = $token->id;
                    $reservas->estado = "";
                    $reservas->save();
                } else {

                    $reser->responsable = $reser->responsable . " y " . $reserva->getCancha->nombre;
                    $reser->save();
                }
            }

            $data["tipo"] = $token->tipo;
            $data["estado"] = true;
            DB::commit();
        }catch (\Exception $e){
            $data=["estado"=>false,"mensaje"=>"error en la transaccion, intentar nuevamente.".$e->getMessage()];
            DB::rollBack();
        }
        return $data;
    }

    /**
     * permite geolocalizar y mover el marcador.
     *
     *
     * @return array map
     */
    public function geoLocalizacionMover()
    {
        $config = array();
        $config['center'] = 'auto';
        $config['onclick'] = 'marker_0.setOptions({
                position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
            });';
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
        $marker['ondragend'] = '$("#getinfo").text( event.latLng.lat() + \' , \' + event.latLng.lng());';
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();


        return view("layouts.mapaGeoMarkerMove", compact("map"));

    }

    public function getMunicipios(Request $request)
    {

        $municipios = Municipio::select('id', 'municipio')->where('id_dpto', $request->input('id'))->get();
        $arrayMunicipio = array();

        foreach ($municipios as $municipio) {
            $arrayMunicipio[$municipio->id] = $municipio->municipio;
        }
        //dd($arrayMunicipio);

        return $arrayMunicipio;
    }

    public function loginModal(Request $request)
    {
        //dd(array('user' => $request->input("user"), 'password' => $request->input("password")));

        $user = User::where("user",$request->input("user"))->first();

        if($user!=null)
            if($user->activado=="N")
                return "Su cuanta no se encuentra activa por favor verificar el correo ".$user->email;

        if (\Auth::attempt(array('user' => $request->input("user"), 'password' => $request->input("password")))) {

            return "login exitoso";
        } else {
            return "login error";
        }

    }

    /**
     * @return string
     */
    public function completarFormulario(){
        
        $departamentos = Departamento::select('id', 'departamento')->whereNotIn('id', [33])->get();
        $arrayDepartamento = array();
        foreach ($departamentos as $departamento) {
            $arrayDepartamento[$departamento->id] = $departamento->departamento;
        }
        $data["arrayDepartamento"]=$arrayDepartamento;

       // dd(Auth::user()->getPersona->identificacion);
            if (Auth::user()->getPersona->identificacion == "")
                return view('jugador.completarRegistro',$data);
            else
                return $this->perfilUsuario();

    }

    /**
     * @return string
     */
    public function completarRegistro(Request $request){

        $persona = Auth::user()->getPersona;
        $persona->update($request->all());
        return "exito";

    }
    

    public function getSitio($id)
    {
        $sitio = Sitio::find($id);
        $date = Carbon::now();
        $fecha = $date->format('Y-m-d');

        if ($sitio != null) {
            if ($sitio->servicios != "")
                $sitio->servicios = explode(',', $sitio->servicios);
            $sitio->getGaleria;
            $sitio->getHorario;
            $sitio->getHorario->semana = AdministradorController::convertirHorario($sitio->getHorario->semana);
            $sitio->getHorario->sabado = AdministradorController::convertirHorario($sitio->getHorario->sabado);
            $sitio->getHorario->festivo = AdministradorController::convertirHorario($sitio->getHorario->festivo);

//            dd($sitio->getHorario);

            $sitio->getMunicipio;

            $tipos = Cancha::select('tipo')->where('id_sitio', $id)->groupBy('tipo')->get();

            $array_dias = ['Sunday' => "D", 'Monday' => "L", 'Tuesday' => "M", 'Wednesday' => "M", 'Thursday' => "J", 'Friday' => "V", 'Saturday' => "S"];

            if ($array_dias[date('l', strtotime($fecha))] == "D" || AdministradorController::esFestivo($fecha)) {
                $dia = "festivo";
            } elseif ($array_dias[date('l', strtotime($fecha))] == "S") {
                $dia = "sabado";
            } else {
                $dia = "semana";
            }
            $data['sitio'] = $sitio;
            $data['dia'] = $dia;
            $data['tipos'] = $tipos;
            $data['hora'] = $date->hour;
            $data['municipio'] = ucwords(strtolower($sitio->getMunicipio->municipio));

            if ($sitio->geolocalizacion != "") {
                $config = array();
                $config['center'] = $sitio->geolocalizacion;
                $config['zoom'] = 'auto';
                \Gmaps::initialize($config);

                $marker = array();
                $marker['position'] = $sitio->geolocalizacion;
//            $marker['ondragend'] = '$("#getinfo").text( event.latLng.lat() + \' , \' + event.latLng.lng());';
                $marker['infowindow_content'] = '<h3 style="margin-bottom: 10px"> ' . $sitio->nombre . '</h3>';
                $marker['icon'] = '../dist/img/taggris1.png';
                \Gmaps::add_marker($marker);

                $map = \Gmaps::create_map();
                $data['map'] = $map;
            }
//            dd(isset($map)?'existe':'NO');
            DB::select('CALL estado_pagos');
            DB::select('CALL estado_reservas_fecha');
            DB::select('CALL estado_reservas_hoy');

            return view('jugador.sitio', $data);
        } else
            return redirect()->back();

    }

    /**
     * @return string
     */
    public function perfilUsuario()
    {

        if (\Auth::user()->rol == "jugador") {

            $departamentos = Departamento::select('id', 'departamento')->get();

            $arrayDepartamento = array();

            foreach ($departamentos as $departamento) {
                $arrayDepartamento[$departamento->id] = $departamento->departamento;
            }

            $data["arrayDepartamento"] = $arrayDepartamento;
            $persona = \Auth::user()->getPersona;
            $data["persona"] = $persona;

            $municipio = Municipio::find($persona->id_municipio);
            $departaActual = $municipio->getDepartamento;

            $data["departamento"] = $departaActual->id;

            $municipios = Municipio::select('id', 'municipio')->where('id_dpto', $departaActual->id)->get();
            $arrayMunicipio = array();

            foreach ($municipios as $municipio) {
                $arrayMunicipio[$municipio->id] = $municipio->municipio;
            }
            //dd($arrayMunicipio);

            $data["arrayMunicipio"] = $arrayMunicipio;


            return view("jugador.perfil", $data);
        } else {
            return redirect('administrador');
        }

    }

    /**
     * @return string
     */
    public function validarPassword(Request $request)
    {

        $data["mensaje"] = "";

        if (\Hash::check($request->password, \Auth::user()->password)) {
            $data["bandera"] = true;
            return $data;
        } else {
            $data["mensaje"] = "la contraseña actual no coincide con nuestros registros";
            $data["bandera"] = false;
            return $data;
        }

    }

    /**
     * @return string
     */
    public function updateAvatarU(Request $request)
    {

        $portada = $request->file('avatar-1');

        $extension = explode(".", $portada->getClientOriginalName());
        $cantidad = count($extension) - 1;
        $extension = $extension[$cantidad];
        $nombre = time() . "PP." . $extension;
        //$sexo = \Auth::user()->getPersona->sexo;
        if (!($request->actual == "avatar2.png" || $request->actual == "avatar4.png"))
            unlink("dist/img/" . $request->actual);

        $portada->move("dist/img/", utf8_decode($nombre));

        $objUsuario = \Auth::user();
        $objUsuario->avatar = $nombre;
        $objUsuario->save();
//        dd("images/".$nombre);
        return json_encode(array('nueva' => $nombre));
    }

    /**
     * @return string
     */
    public function updateJugador(Request $request)
    {
        \Auth::user()->getPersona->update($request->all());

        return "exito";
    }

    /**
     * @return string
     */
    public function cambiarPassword(Request $request)
    {

        $data["mensaje"] = "";

        if (\Hash::check($request->passwordA, \Auth::user()->password)) {

            if ($request->password == $request->passwordC) {
                $user = User::find(\Auth::user()->id)->update(['password' => bcrypt($request->password)]);

                $data["mensaje"] = "la contraseña fue cambiada exitosamente.";
                $data["bandera"] = true;
                return $data;
            } else {
                $data["mensaje"] = "las Contraseñas no coinciden";
                $data["bandera"] = false;
                return $data;
            }

        } else {
            $data["mensaje"] = "la contraseña actual no coincide con nuestros registros";
            $data["bandera"] = false;
            return $data;
        }

    }


    /**
     * @return string
     */
    public function misReservas()
    {

        $resertvas = new Reserva();

        $data["reservas"] = $resertvas->misReservasUser(Auth::user()->id);

        //dd($resertvas->misReservasUser(Auth::user()->id));

        return view("jugador.misReservas", $data);
    }


    /**
     * @return string
     */
    public function cancelReservaUser(Request $request)
    {
        $date = Carbon::now();
        $reserva = Reserva::find($request->id);
        $dateReserva = Carbon::parse($reserva->fecha);
        $cancha = Cancha::where("id", $reserva->id_cancha)->first();
        $horario = Horario::where("id_sitio", $cancha->id_sitio)->first();
        $arrayHorario = array();

        if ($this->array_dias[date('l', strtotime($dateReserva))] == "D" || $this->esFestivo($dateReserva)) {
            $arrayHorario = explode("-", $horario->festivo);
        } elseif ($this->array_dias[date('l', strtotime($dateReserva))] == "S") {
            $arrayHorario = explode("-", $horario->sabado);
        } else {
            $arrayHorario = explode("-", $horario->semana);
        }

        $dateReserva->hour = $reserva->hora;

        if ($reserva->hora < $arrayHorario[0]) {
            $dateReserva->addDay();
        }

        if ($date->diffInHours($dateReserva) > 3) {
            if ($request->cancel){
                $ids = AdministradorController::infCancelarReserva($reserva->id_cancha, $reserva->fecha, $reserva->hora)["ids"];
                foreach ($ids as $id) {
                    $reserva = Reserva::find($id);
                    $reserva->estado = "I";
                    $reserva->save();
                }
            }
            
            $data["bandera"] = true;
            $data["mensaje"] = "se cancelo";
            
        } else{
            $data["bandera"] = false;
            $data["mensaje"] = "No x 4";
        }

        return $data;
    }



}
