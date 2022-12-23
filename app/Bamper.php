<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bamper extends Model
{
    protected $table = 'BAMPER';

    protected $primaryKey = 'PerCod';

    protected $connection = 'pgsql';

    public $incrementing = false;

    //protected $connection = 'sqlsrv';


    //public $timestamps = false;

    //protected $connection = 'sqlsrv';

    //protected $dateFormat = 'Y-m-d H:i:s.v';

    //public $incrementing = false;
}
