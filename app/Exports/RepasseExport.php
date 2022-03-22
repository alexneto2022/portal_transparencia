<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use \Illuminate\Http\Request;

class RepasseExport implements FromCollection, WithHeadings
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
        return DB::table('repasses')
        ->join('unidades', 'repasses.unidade_id', '=','unidades.id')
        ->select('repasses.mes','repasses.ano','repasses.contratado','repasses.recebido','repasses.desconto','unidades.name as unidade')
        ->where('repasses.unidade_id', $this->id)
        ->where('repasses.ano',$this->year)
        ->get();
    }

    public function headings(): array
    {
        return [
            'mes',
            'ano',
            'contratado',
            'recebido',
            'desconto',
            'unidade'
        ];
    }
}
