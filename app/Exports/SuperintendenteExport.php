<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class SuperintendenteExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('superintendentes')
        ->join('unidades', 'superintendentes.unidade_id', '=','unidades.id')
        ->select('superintendentes.name as NOME','superintendentes.cargo','superintendentes.tipo_membro','unidades.name as UNIDADE')
        ->get();
    }

    public function headings(): array
    {
        return [
            'NOME',
            'CARGOs',
            'MEMBRO',
            'UNIDADE'
        ];
    }
}
