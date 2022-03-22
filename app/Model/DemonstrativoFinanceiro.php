<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DemonstrativoFinanceiro extends Model
{
    protected $table = 'financial_reports';
	
	protected $fillable = [
		'title',
		'mes',
		'ano',
		'file_path',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' => 'required',
		'mes' => 'required|numeric',
		'ano' => 'required|numeric'
	];
}
