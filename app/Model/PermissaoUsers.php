<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissaoUsers extends Model
{
    protected $table = 'permissao_user';
	
	protected $fillable = [
		'user_id',
	    'permissao_id',
		'created_at',
		'updated_at',
		'unidade_id'
	];
}
