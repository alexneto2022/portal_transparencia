<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Aditivo extends Model
{
    protected $table = 'aditivos';

    protected $fillable = [
        'contrato_id',
        'valor',
        'inicio',
        'fim',
        'yellow_alert',
        'red_alert',
        'file_path',
        'ativa',
        'created_at',
        'updated_at',
        'unidade_id',
        'opcao',
        'vinculado'
    ];


    public function contratos()
    {
        return $this->belongsTo('App\Model\Contrato');
    }
}
