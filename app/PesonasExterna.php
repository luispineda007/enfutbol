<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesonasExterna extends Model
{
    protected $table = 'pesonas_externas';

    protected $fillable = ['identificacion', 'nombres', 'telefono', 'id_municipio', 'sexo','fecha_nacimiento'];
}
