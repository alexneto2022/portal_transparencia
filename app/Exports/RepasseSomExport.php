<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use \Illuminate\Http\Request;
use App\Model\Repasse;

class RepasseSomExport implements FromCollection, WithHeadings
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
        ->select(DB::raw('sum(`contratado`) as Contratado, sum(`recebido`) as Recebido, sum(`contratado` - `recebido`) as Total'))
		->where('repasses.unidade_id', $this->id)
		->get();
    }
	
    public function headings(): array
    {
        return [
			'Contratado',
			'Recebido',
			'Total'
		];
    }
}
