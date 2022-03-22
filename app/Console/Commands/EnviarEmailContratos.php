<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Unidade;
use App\Model\Contrato;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EnviarEmailContratos extends Command
{
    protected $signature = 'enviar:emails';

    protected $description = 'Enviar Email dos Contratos';

    public function __construct()
    {
	    parent::__construct();
    }
	
    public function handle (Unidade $unidade, Contrato $contrato)
    {
		DB::table('unidades')->get();
	    for($i = 2; $i <= 8; $i++) {
			$contratos = Contrato::where('unidade_id', $i)->where('renovacao_automatica', 0)->get();
			$qtd = sizeof($contratos);
			for($j = 0; $j < $qtd; $j++){
				$data_fim = $contratos[$j]->fim;
				$hoje = date('Y-m-d',(strtotime('now')));
				$data = date('Y-m-d', strtotime('-90 days', strtotime($data_fim)));
				$contrato = $contratos[$j]->objeto;
				$link = $contratos[$j]->file_path;
				if(strtotime($hoje) == strtotime($data)){
					Mail::send('email.contatoEmail', ['contrato' => ''.$contrato.'', 'link' => ''.$link.''], function($m) {
						$m->from('ilton.albuquerque@hcpgestao.org.br', 'Portal da Transparencia');
						$m->subject('Contratos prestes a vencer!');
						$m->to('ilton.albuquerque@hcpgestao.org.br');
					});
				}
			}		
	   }
   }
}
