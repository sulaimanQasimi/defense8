<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportCardInfo extends DownloadExcel implements WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithEvents, WithStyles
{
    public function map($info): array
    {
        return [
            $info->national_id, // A
            $info->name,  //B
            $info->last_name,
            $info->father_name,
            $info->grand_father_name,
            ($info->birthday) ? Date::dateTimeToExcel($info->birthday) : '', //F
            $info->phone,
            $info->degree,
            $info->grade,
            $info->acupation,
            $info->registare_no,
            $info->job_structure,
            $info->previous_job,
            $info->department,

            $info->m_village,
            $info->m_district,
            $info->m_province,

            $info->c_village,
            $info->c_district,
            $info->c_province,
        ];
    }

    public function headings(): array
    {
        return [

            [
                __("Info"),
                __("Job"),
                __("Main Address"),
                __("Current Address")
            ],

            [
                __("National ID"),  //A
                __("Name"),
                __("Last Name"),
                __("Father Name"),
                __("Grand Father Name"),
                __("Date of Birth"),
                __("Phone"), //G

                __("Degree"), //H
                __("Grade"),
                __("Acupation"),
                __("Register No"),
                __("Job Stracture Title"),
                __("Previous Job"),
                __("Department/Chancellor"),
                __("Village"),
                __("District"),
                __("Province"),

                __("Village"),
                __("District"),
                __("Province"),
            ],
        ];
    }
    public function columnFormats(): array
    {
        return [
            'A' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'B' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'C' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'D' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'E' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            //'F'=>\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'G' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'H' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            // 'V' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
            'W' => NumberFormat::FORMAT_DATE_DDMMYYYY,

            'AB' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            //'C' => NumberFormat::FORMAT_CURRENCY_EUR_INTEGER,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Right to Left
                $event->sheet->getDelegate()->setRightToLeft(true);
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', __("Info"));
                $sheet->mergeCells('H1:N1');

                $sheet->setCellValue('H1', __("Job"));

                $sheet->mergeCells('O1:Q1');

                $sheet->setCellValue('O1', __("Main Address"));

                $sheet->mergeCells('R1:T1');

                $sheet->setCellValue(
                    'R1',
                    __("Current Address")
                );


                $sheet->mergeCells('U1:X1');

                $sheet->setCellValue(
                    'U1',
                    __("Main Card")
                );

                $sheet->mergeCells('Y1:AB1');

                $sheet->setCellValue(
                    'Y1',
                    __("Gun Card")
                );



            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'name' => 'Arial',
                    'bold' => true,
                    'italic' => false,
                    // 'underline' => Font::UNDERLINE_DOUBLE,
                    'strikethrough' => false,
                    // 'color' => [
                    //     'rgb' => '808080'
                    // ]
                ],
                // 'borders' => [
                //     'allBorders' => [
                //         'borderStyle' => Border::BORDER_DASHDOT,
                //         'color' => [
                //             'rgb' => '808080'
                //         ]
                //     ],
                // ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],

            ],
        ];
    }

    public function name(){
        return trans("Download Excel");
    }
}
