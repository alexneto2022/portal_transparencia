<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use \Illuminate\Http\Request;

class AssociadosExport implements FromCollection, WithHeadings
{
	use Exportable;
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('associados')
        ->join('unidades', 'associados.unidade_id', '=','unidades.id')
        ->select('associados.name as NOME','associados.cpf','associados.tipo_membro','unidades.name as UNIDADE')
        ->get();
        
        
    }

    public function headings(): array
    {
        return [
            'NOME',
            'CPF',
            'MEMBRO',
            'UNIDADE'
        ];
    }
}
