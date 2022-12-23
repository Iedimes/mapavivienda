<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sat extends Model
{
    protected $table = 'SHMNUC';

    protected $connection = 'pgsql';

    protected $primaryKey = 'NucCod';

    public $incrementing = false;


    public function satnombre()
    {
        return $this->hasOne('App\Bamper', 'PerCod', 'NucCod');
    }
    /*public function distrito() {
        return $this->hasOne('App\Distrito','CiuId','CiuId');
    }

    public function departamento() {
        return $this->hasOne('App\Departamento','DptoId','DptoId');
    }

    public function programa() {
        return $this->hasOne('App\Programa','id','SEOBProgr');
    }

    public function estado() {
        return $this->hasOne('App\Estado','value','SEOBEst');
    }

    public function terreno() {
        return $this->hasOne('App\Terreno','ident','SEOBTerr');
    }*/
}
