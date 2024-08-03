<?php

namespace App\Exports;

use Sq\Query\DateFromAndToModelQuery;
use Sq\Oil\Models\OilDisterbution;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Vehical\OilType;

class DisterbutedOilExcelExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    use Exportable;
    private $i;
    public function __construct()
    {
        $this->i = 1;
    }
    public function headings(): array
    {
        return [
            trans('#'),
            trans('Register No'),
            trans('Name'),
            trans('Father Name'),
            trans("Oil Type"),
            trans("Monthly Rate"),
            trans("Oil Amount"),
            trans("Date")
        ];
    }
    public function query()
    {
        return (new DateFromAndToModelQuery(OilDisterbution::class, 'filled_date'))->query();
    }
    public function map($d_oil): array
    {
        return [
            $this->i++,
            $d_oil->card_info->registare_no,
            $d_oil->card_info->full_name,
            $d_oil->card_info->father_name,
            trans(($d_oil->card_info->oil_type == OilType::Diesel) ? "Diesel" : "Petrole"),
            trans("Liter", ['value' => $d_oil->card_info->monthly_rate]),
            trans("Liter", ['value' => $d_oil->oil_amount]),
            verta($d_oil->filled_date)->format('Y/m/d'),
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}
