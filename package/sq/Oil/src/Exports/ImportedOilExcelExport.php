<?php

namespace Sq\Oil\Exports;

use Sq\Query\DateFromAndToModelQuery;
use Sq\Oil\Models\Oil;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Vehical\OilType;

class ImportedOilExcelExport implements FromQuery, WithHeadings, WithMapping, WithEvents
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
            '#',
            trans('Code'),
            trans("Oil Type"),
            trans('Oil Quality'),
            trans("Oil Amount"),
            trans("Date"),
        ];
    }
    public function query()
    {
        return (new DateFromAndToModelQuery(Oil::class, 'filled_date'))->query();
    }
    public function map($oil): array
    {
        return [
            $this->i++,
            $oil->code,
            trans(($oil->oil_type == OilType::Diesel) ? "Diesel" : "Petrole"),
            $oil->oil_quality->name,
            trans("Liter", ['value' => $oil->oil_amount]),
            verta($oil->filled_date)->format('Y/m/d'),
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

