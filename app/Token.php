<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    protected $fillable = ['id_sitio', 'id_usuario', 'tipo', 'fecha', 'estado', 'motivo'];

    public function getUsuario()
    {
        return $this->belongsTo('App\User','id_usuario');
    }
    
}
