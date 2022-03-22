<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Model\Processos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use DB;

class processoImport implements ToModel, WithHeadingRow
{	
	public function __construct(int $id)
    {
        $this->id = $id;
	}
	 
	public function headingRow(): int
    {
        return 5;
    }
	 
    public function model(array $row)
    { 	
		if($row['no_de_solicitacao'] != "") {
			return new Processos([
				'numeroSolicitacao'  => $row['no_de_solicitacao'],
				'dataSolicitacao'    => $row['data_da_solicitacao'],
				'numeroOC' 			 => $row['n0_ordem_compra'],
				'dataAutorizacao' 	 => $row['data_de_autorizacao_da_ordem_de_compra'],
				'fornecedor' 		 => $row['fornecedor_razao_social'],
				'cnpj' 				 => $row['cnpj_do_fornecedor'],
				'produto'            => $row['produto'],
				'qtdOrdemCompra'     => $row['quantidade_da_ordem_de_compra'],
 				'totalValorOC' 	  	 => $row['valor_total_da_ordem_de_compra'],
				'classificacaoItem'  => $row['classificacao_do_item'],
				'numeroNotaFiscal'   => $row['n0_da_nota_fiscal'],
				'quantidadeRecebida' => $row['quantidade_recebida'],
				'valorTotalRecebido' => $row['valor_total_recebido'],
				'chaveAcesso'        => $row['chave_de_acesso'],
				'codigoIbge' 		 => $row['codigo_ibge'],
				'unidade_id'         => $this->id
		   ]);
		} else {
			
		}
    }
}
