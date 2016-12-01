<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    protected $table = 'sitios';
    protected $fillable = ['nombre', 'id_usuario', 'estado_pago', 'fecha_registro', 'id_municipio', 'info_adicional', 'geolocalizacion', 'direccion', 'facebook', 'twitter'];


    public function getUsuario()
    {
        return $this->belongsTo('App\User','id_usuario');
    }

    public function getMunicipio()
    {
        return $this->belongsTo('App\Municipio','id_municipio');
    }

    public function getCanchas()
    {
        return $this->hasMany('App\Cancha', 'id_sitio');
    }

    public function getHorario()
    {
        return $this->hasOne('App\Horario','id_sitio');
    }

    public function getGaleria()
    {
        return $this->hasMany('App\Galeria','id_sitio');
    }
    

}
