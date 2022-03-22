<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class Pessoa extends Model
{
    protected $connection='oracle';
    protected $table='pessoas';
}
