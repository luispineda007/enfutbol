<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    public function getUsuario()
    {
        return $this->belongsTo('App\User', 'usuario_id');
    }
}
