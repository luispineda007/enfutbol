<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';

    public function getDepartamento()
    {
        return $this->belongsTo('App\Departamento','id_dpto');
    }
}
