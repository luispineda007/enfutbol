<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    
    protected $fillable = ['identificacion', 'nombres', 'telefono', 'id_municipio', 'sexo','fecha_nacimiento'];
    
    public function getUsuario()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function getMunicipio()
    {
        return $this->belongsTo('App\Municipio', 'id_municipio');
    }


}
