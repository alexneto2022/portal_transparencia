<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssistencialCovid extends Model
{
    protected $table = 'assistencial_covid';

    protected $fillable = [
        'titulo',
        'file_name',
        'file_path',
        'ano',
        'mes',
        'created_at',
        'updated_at'
    ];
}
