<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use phpDocumentor\Reflection\Types\Object_;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user', 'email', 'password','rol','avatar','activado'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function getPersona()
    {
        return $this->hasOne('App\Persona');
    }

    public function getPagoServiTorneo()
    {
        return $this->hasOne('App\PagosTorneo');
    }

    public function getSitio()
    {
        return $this->hasOne('App\Sitio','id_usuario');
    }

    public function getToken()
    {
        return $this->hasOne('App\Token','id_usuario');
    }


    /**
     * @return Object_ token
     */
    public function getTorneos()
    {
        return $this->hasMany('App\Torneo', 'usuario_id');
    }

    public function getPlantillas()
    {
        return $this->hasMany('App\Plantilla', 'usuario_id');
    }

    public function capitanEnTorneo( $torneo_id , $identificacion ){
        $torneos = DB::table('torneos')
            ->select('equipos.id', 'equipos.nombre', DB::raw('equipos_torneos.id as equipoTorneo'))
            ->join('equipos_torneos', 'equipos_torneos.torneo_id', '=', 'torneos.id')
            ->join('equipos', 'equipos.id', '=', 'equipos_torneos.equipo_id')
//            ->join('jugadors', 'jugadors.equipo_id', '=', 'equipos.id')
            ->where('torneos.estado', '<>', "T")
            ->where('equipos.capitan_id', '=', $identificacion)
            ->where('torneos.id', '=', $torneo_id)
            ->first();
        return $torneos;

    }
    
    

}
