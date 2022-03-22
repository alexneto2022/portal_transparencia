<?php

namespace App\Exports;

use \DB;
use \Maatwebsite\Excel\Concerns\FromCollection;
use \Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use \Illuminate\Http\Request;

class AssistencialExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id, int $year)
    {
        $this->id = $id;
        $this->year = $year;
    }

    public function collection()
    {
        $ano = ($this->year == 0 ? $this->year = false : $this->year);
        return DB::table('assistencials')
        ->join('unidades', 'assistencials.unidade_id', '=','unidades.id')
        ->join('indicadors', 'assistencials.indicador_id', '=','indicadors.id')
        ->select('assistencials.id AS ID' ,'assistencials.descricao as DESCRIÇÃO', 'indicadors.title AS INDICADOR', 'assistencials.meta AS META', 'assistencials.janeiro AS JANEIRO',
        'assistencials.fevereiro AS FEVEREIRO', 'assistencials.marco AS MARÇO', 'assistencials.abril AS ABRIL', 'assistencials.maio AS MAIO', 'assistencials.junho AS JUNHO', 
        'assistencials.julho AS JULHO', 'assistencials.agosto AS AGOSTO', 'assistencials.setembro AS SETEMBRO', 'assistencials.outubro AS OUTUBRO', 'assistencials.novembro AS NOVEMBRO', 
        'assistencials.dezembro AS DEZEMBRO', 'assistencials.ano_ref AS ANO', 'unidades.name as NAME')
        ->where('assistencials.unidade_id', $this->id)
        ->when($ano, function ($query, $ano) {
            return $query->where('assistencials.ano_ref',$ano);
        })
        ->get();
    
    }

    public function headings(): array
    {
        return [
            'ID',
            'DESCRIÇÃO',
            'INDICADOR',
            'META',
            'JANEIRO',
            'FEVEREIRO',
            'MARÇO',
            'ABRIL',
            'MAIO',
            'JUNHO',
            'JULHO',
            'AGOSTO',
            'SETEMBRO',
            'OUTUBRO',
            'NOVEMBRO',
            'DEZEMBRO',
            'ANO',
            'UNIDADE'
        ];
    }
}
