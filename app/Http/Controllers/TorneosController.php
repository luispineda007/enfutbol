<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Fases_torneo;
use App\Torneo;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TorneosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $data['torneos'] = $user->getTorneos;
        return view('torneos.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function torneoNuevo()
    {
        $usuario = \Auth::user();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            return "exito";
        }catch(\Exception $e){
            DB::rollBack();
            return json_encode(array('error' => "Ha ocurrido el siguiente error: " . $e->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
