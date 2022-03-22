<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ConselhoAdmExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('conselho_adms')
        ->join('unidades', 'conselho_adms.unidade_id', '=','unidades.id')
        ->select('conselho_adms.name as NOME','conselho_adms.cargo','conselho_adms.tipo_membro','unidades.name as UNIDADE')
        ->get();
    }

    public function headings(): array
    {
        return [
            'NOME',
            'CARGO',
            'MEMBRO',
            'UNIDADE'
        ];
    }
}
