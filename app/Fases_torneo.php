<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fases_torneo extends Model
{
  protected $table = 'fases_torneos';

  protected $fillable = ['padre_id','torneo_id','numero_fase','nombre_fase','tipo_juego','estado'];

}
