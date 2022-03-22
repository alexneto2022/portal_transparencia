<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoggerUsers extends Model
{
	protected $table = 'logger_users';
	
    protected $fillable = [
        'user_id', 'tela', 'acao', 'unidade_id', 'created_at', 'updated_at'
    ];
	
}
