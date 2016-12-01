<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    protected $table = 'galerias';


    protected $fillable = ['id_sitio', 'foto','tipo'];
}
