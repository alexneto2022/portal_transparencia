<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Ouvidoria extends Model{	protected $table = 'ouvidoria';		protected $fillable = [		'responsavel',		'email',		'telefone',		'unidade_id',		'created_at',		'updated_at'	];}
