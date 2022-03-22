<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ConselhoFiscExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('conselho_fiscs')
        ->join('unidades', 'conselho_fiscs.unidade_id', '=','unidades.id')
        ->select('conselho_fiscs.name as NOME','conselho_fiscs.level','conselho_fiscs.tipo_membro','unidades.name as UNIDADE')
        ->get();
    }

    public function headings(): array
    {
        return [
            'NOME',
            'TIPO MEMBRO',
            'MEMBRO',
            'UNIDADE'
        ];
    }
}
