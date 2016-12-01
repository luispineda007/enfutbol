<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    protected $table = 'canchas';


    protected $fillable = ['id_sitio', 'id_padre', 'nombre', 'tipo','foto','precio_base','precio_nocturno','precio_festivo','descripcion'];


    public function getSitio()
    {
        return $this->belongsTo('App\Sitio','id_sitio');
    }
    
    
    
    

}
