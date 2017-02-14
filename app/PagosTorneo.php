<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosTorneo extends Model
{
    protected $table = 'pagos_torneos';


    public function getUsuario()
    {
        return $this->belongsTo('App\User','user_id');
    }


}
