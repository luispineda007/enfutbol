<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosSitios extends Model
{
    protected $table = 'pagos_sitios';
    
    protected $fillable = ['id_sitio', 'fecha_inicio', 'fecha_fin','valor'];

}
