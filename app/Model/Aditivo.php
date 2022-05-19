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
        'aviso_venc90',
		'aviso_venc60',
        'yellow_alert',
        'red_alert',
        'file_path',
        'ativa',
        'inativa',
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
