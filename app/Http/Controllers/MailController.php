<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{

    /**
     * @return string
     */
    public function enviar(Request $request)
    {
        global  $email;
         $email = $request->email;
        Mail::send("emails.contacto",$request->all(),function ($msj){
            global  $email;
            $msj->subject("contacto enFutbol");
            $msj->to("informacion.enfutbol.co@gmail.com");
            $msj->replyTo($email, $name = null);

        });
        //Session::flash('message','Mensaje fue enviado correctamente');
        return "exito";
    }


    /**
     * @return string
     */
    public static function ConfirmarRegistroU($request)
    {
        global  $email;
        $email = $request["email"];
        Mail::send("emails.CRegistroUser",$request,function ($msj){
            global  $email;
            $msj->subject("Registro en enFutbol.co");
            $msj->to($email);
            $msj->replyTo("informacion.enfutbol.co@gmail.com", $name = "enfutbol");

        });
        //Session::flash('message','Mensaje fue enviado correctamente');
        return "exito";
    }

    /**
     * @return string
     */
    public static function activarCUser($request)
    {
        global  $email;
        $email = $request["email"];
        Mail::send("emails.activarCUser",$request,function ($msj){
            global  $email;
            $msj->subject("Activar cuenta enFutbol.co");
            $msj->to($email);
            $msj->replyTo("informacion.enfutbol.co@gmail.com", $name = "enfutbol");

        });
        //Session::flash('message','Mensaje fue enviado correctamente');
        return "exito";
    }
    

    /**
     * @return string
     */
    public static function cancelarReserva($data)
    {
        global  $email;
        $email = $data["email"];
        Mail::send("emails.NotiCancelReserva",$data,function ($msj){
            global  $email;
            $msj->subject("Cancelación de Reserva en enFutbol");
            $msj->to($email);
            $msj->replyTo("informacion.enfutbol.co@gmail.com", $name = "enfutbol");

        });
        //Session::flash('message','Mensaje fue enviado correctamente');
        return "exito";
    }
    
    /**
     * Envia email con codigo para inscripcion en torneo.
     *
     * @return array
     */
    public static function enviarCodigo($data){
        global  $email;
        $email = $data["email"];
        Mail::send("emails.codigoTorneo",$data,function ($msj){
            global  $email;
            $msj->subject("Codigo para inscripcion a Ttorneo");
            $msj->to($email);
            $msj->replyTo("informacion.enfutbol.co@gmail.com", $name = "enfutbol");

        });
        return "exito";
    }

}
