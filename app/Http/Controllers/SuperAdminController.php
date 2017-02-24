<?php

namespace App\Http\Controllers;

use App\Cancha;
use App\Galeria;
use App\Historial_Pago;
use App\Horario;
use App\PagosSitios;
use App\PagosTorneo;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\sitioRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sitio;
use App\Persona;
use App\User;
Use App\Departamento;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;


class SuperAdminController extends Controller
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
    public function index(){
        //$user = new User();
        //$user = User::find($this->auth->user()->id);
        //dd($user->getPersona->nombres);

/*        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        dd($date);*/

        return view('superAdmin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registrarSitio(){

        $config = array();
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';

        \Gmaps::initialize($config);

        // Colocar el marcador
        // Una vez se conozca la posición del usuario
        $marker = array();
        $marker['position'] = '37.429, -122.1519';
        $marker['infowindow_content'] = '1 - Hello World!';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
        \Gmaps::add_marker($marker);
        $map = \Gmaps::create_map();


        $departamentos= Departamento::select('id','departamento')->get();

        $arrayDepartamento = array();

        foreach ($departamentos as $departamento){
            $arrayDepartamento[$departamento->id]= $departamento->departamento;
        }

        //dd($arrayDepartamento);
       return view('superAdmin.registro',compact('arrayDepartamento','map'));
    }

    public function addSitio(sitioRequest $request){

        $totalCanchas= $request->input("totalcanchas");

        $user = new User($request->all());
        $user->avatar= "DefaultProfile.jpg";
        $user->password= \Hash::make($request->identificacion);
        $user->rol= "admin";
        $user->activado= "S";
        $user->save();

        $persona = new Persona($request->all());
        $persona->user_id=$user->id;
        $persona->save();

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $request->_token,'created_at'=> Carbon::now()]
        );
        $date = Carbon::now();

        $sitio = new Sitio($request->all());
        $sitio->id_usuario=$user->id;
        $sitio->fecha_registro=$date->format('Y-m-d');

        if($request->input("fecha_fin")){
            $sitio->estado_pago="A";
        }else{
            $sitio->estado_pago="I";
        }
        $sitio->save();

        $token = new Token();
        $token->id_sitio = $sitio->id;
        $token->id_usuario = $user->id;
        $token->tipo = "VIP";
        $token->fecha = $sitio->fecha_registro;
        $token->estado = 'A';
        $token->save();

        $galeria = new Galeria();
        $galeria->id_sitio = $sitio->id;
        $galeria->foto = "DefaultProfile.jpg";
        $galeria->tipo = "portada";
        $galeria->save();

        $horario = new Horario();
        $horario->id_sitio = $sitio->id;
        $horario->semana = "";
        $horario->sabado = "";
        $horario->festivo = "";
        $horario->save();

        if($request->input("fecha_fin")){
            $pago = new PagosSitios($request->all());
            $pago->id_sitio=$sitio->id;
            $pago->save();
        }

        for($i=1;$i<=$totalCanchas;$i++){
            $canchapadre= new Cancha();
            $canchapadre->id_sitio=$sitio->id;
            $canchapadre->tipo=$request->input("cancha".$i);
            $canchapadre->save();

            if($request->input("Check".$i)){
                $cancha1= new Cancha();
                $cancha1->id_sitio=$sitio->id;
                $cancha1->id_padre=$canchapadre->id;
                $cancha1->tipo=$request->input("cancha".$i."1");
                $cancha1->save();
                $cancha2= new Cancha();
                $cancha2->id_sitio=$sitio->id;
                $cancha2->id_padre=$canchapadre->id;
                $cancha2->tipo=$request->input("cancha".$i."2");
                $cancha2->save();
            }

        }
        return "exito";
    }


    /**
     * @return Array de sitios
     */
    public function sitiosRegistrados()
    {
        $sitios = Sitio::all();

        return view('superAdmin.sitiosRegistrados',compact('sitios'));
    }


    /**
     * @return string
     */
    public function modalHistorialPagos($id){
        //el id es el del sitio
        $data["id"]=$id;
        $data["pagos"] = Historial_Pago::where('id_sitio',$id)->get();
        $data["fechaInicio"]=$this->determinarFechaInicio($id);

        //dd($data);

        return view("superAdmin.ModalHistoriasPagos",$data);
    }

    /**
     * @return string
     */
    public function modalDetallesSitio($id){

        $data["sitio"]= Sitio::find($id);

        //dd($data["sitio"]);
        return view("superAdmin.ModalDetallesSitio",$data);
        
    }

    /**
     * @return string
     */
    public function modalEditarCanchas($id){

        $sitio= Sitio::find($id);
        $data["sitio"]= $sitio;

        $arrayCanchas= array();

        foreach ($sitio->getCanchas as $cancha){
            $arrayCancha=array();
            $arrayCancha["id"]=$cancha->id;
            $arrayCancha["tipo"]=$cancha->tipo;

            if($cancha->id_padre==0){
                $arrayCancha["hijas"]=[];
                $arrayCanchas[$cancha->id] =$arrayCancha;
            }else{
                array_push( $arrayCanchas[$cancha->id_padre] ["hijas"] ,$arrayCancha);
            }
        }

        //dd($arrayCanchas);
        $data["arrayCanchas"]= $arrayCanchas;

        return view("superAdmin.ModalEditarCanchas",$data);
    }

    /**
     * @return string
     */
    public function addCancha(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->id_padre == 0) {
                $cancha = new Cancha($request->all());
                $cancha->save();
                $data=["estado"=>true,"mensaje"=>"exito"];
            } else {
                $arrayHijas = array();
                for($i=0;$i<2;$i++){
                    $cancha = new Cancha($request->all());
                    $cancha->id_padre = $request->id_padre;
                    $cancha->save();
                    $arrayHijas[]=$cancha->id;
                }
                $data=["estado"=>true,"mensaje"=>"exito","hijas"=>$arrayHijas];
            }
            DB::commit();
            return $data;
        }catch (\Exception $e){
            DB::rollBack();
        }
    }

    /**
     * @return string
     */
    public function removeCancha(Request $request){

        if($request->id_padre==0){
            Cancha::where("id_padre",$request->id)->delete();
            Cancha::find($request->id)->delete();
            return "eliminada";
        }
        else{
            Cancha::where("id_padre",$request->id_padre)->delete();
            return "eliminar solo las hijas";
        }

    }

    /**
     * @return string
     */
    public function cambiarTipoCancha(Request $request)
    {
        $cancha = Cancha::find($request->id);
        $cancha->tipo=$request->tipo;
        $cancha->save();
        return $request->all();
    }



    /**
     * funcion para determinar la fecha de inicio de un pago
     * @param int $id_sitio
     * @return string
     */
    public function determinarFechaInicio($id_sitio)
    {
        $date = Carbon::now();
        $fechaPago= PagosSitios::where('id_sitio',$id_sitio)->first()->fecha_fin;
        $datePago= Carbon::parse($fechaPago);

        if($date->diffInDays($datePago,false)<=0){
            return $date->format('Y-m-d');
        }else{
            return $datePago->format('Y-m-d');
        }
    }

    /**
     * @return string
     */
    public function addPago(Request $request)
    {
        $date = Carbon::parse($this->determinarFechaInicio($request->id));

        $pago = PagosSitios::where("id_sitio",$request->id)->first();
        //dd(Sitio::find($pago->id_sitio)->id_usuario);
        $historialPago = new Historial_Pago();
        $historialPago->id_sitio=$pago->id_sitio;
        $historialPago->fecha_inicio = $pago->fecha_inicio;
        $historialPago->fecha_fin = $pago->fecha_fin;
        $historialPago->valor = $pago->valor;
        $historialPago->save();

        $pago->fecha_inicio= $date->format('Y-m-d');
        if(intval($request->meses)>0){
            $pago->fecha_fin = $date->addMonths(intval($request->meses))->format('Y-m-d');
        }
        if(intval($request->dias)>0){
            $pago->fecha_fin = $date->addDays(intval($request->dias))->format('Y-m-d');
        }
        $pago->valor=intval($request->valor);

        $pago->save();

        if($request->pagos_torneo){

            $user_id = Sitio::find($pago->id_sitio)->id_usuario;

            $pagoTorneo = PagosTorneo::where("user_id",$user_id)->first();

            if($pagoTorneo==null){
                $pagoTorneo = new PagosTorneo();
            }
                $pagoTorneo->user_id=$user_id;
                $pagoTorneo->fecha_inicio = $pago->fecha_inicio;
                $pagoTorneo->fecha_fin = $pago->fecha_fin;
                $pagoTorneo->valor = $pago->valor;
                $pagoTorneo->estado = "X";
                $pagoTorneo->save();
        }

        $sitio = Sitio::find($request->id);
        $sitio->estado_pago= "A";
        $sitio->save();

        return "exito";
    }


    public function superTorneos()
    {
       //dd("hola") ;

        $pagosTorneos = PagosTorneo::where("estado","X")->get();

        $data["pagosTorneos"]=$pagosTorneos;

        //dd($data);

        return view("superAdmin.torneos",$data);
    }


    /**
     *
     */
    public function autoCompleUser(Request $request)
    {
        $busqueda = $request->all()["query"];
        $arrayUser = array();

        $personas = Persona::where("identificacion", "like","%" . $busqueda . "%")->get();

        if($personas->count()==0){
            $users = User::where("user", "like", "%" . $busqueda . "%")->get();

            if($users->count()>0) {
                foreach ($users as $user) {
                    $arrayUser[] = ["value" => $user->user, "data" => $user->id];
                }
            }else{
                $data["bandera"]=false;
                $data["suggestions"]=["No encontrado"];
            }
        }else{
            foreach ($personas as $persona) {
                $arrayUser[] = ["value"=>$persona->getUsuario->user,"data"=>$persona->getUsuario->id];
            }
        }

        $data["query"]="Unit";
        $data["suggestions"]=$arrayUser;
        return $data;

    }

    public function pagosTorneoUser(Request $request)
    {
        $date = Carbon::now();
        $user = User::where("user",$request->user)->first();

        if($user!=null){
            $pagoTorneo = PagosTorneo::where("user_id",$user->id)->first();

            if($pagoTorneo==null){
                $pagoTorneo = new PagosTorneo();
                $pagoTorneo->user_id=$user->id;
            }
            $pagoTorneo->fecha_inicio = $date->format('Y-m-d');
            $pagoTorneo->fecha_fin = $request->fecha_fin;
            $pagoTorneo->valor = $request->valor;
            $pagoTorneo->estado = "X";
            $pagoTorneo->save();
            $data["bandera"]=true;
            $data["user"]=$user->user;
            $data["rol"]=$user->rol;
            $data["sitio"]=($user->getSitio==null)?"":$user->getSitio->nombre;
            $data["fecha_fin"]=$request->fecha_fin;


        }else{
            $data["bandera"]=false;
            $data["mensaje"]="El usuario ".$request->user." no existe en nuestros registros";
        }

        return $data;
    }

}
