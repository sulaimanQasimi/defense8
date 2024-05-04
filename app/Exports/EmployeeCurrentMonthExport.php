<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Card\CardInfo;
use App\Models\Department;
use Hekmatinasser\Verta\Facades\Verta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class EmployeeCurrentMonthExport implements FromCollection, WithMapping, WithHeadings, WithEvents, WithColumnWidths, WithStyles
{
    public function __construct(public $department_id, public $start, public $end)
    {

    }
    public function collection()
    {
        return CardInfo::where('department_id', $this->department_id)->with([
            'attendance' => function ($query) {
                $query
                    ->orderBy('date', 'ASC')
                    ->whereBetween("date", [$this->start, $this->end]);
            }
        ])->get();
    }

    public function map($row): array
    {
        $day = array_fill(1, 31, '');
        foreach ($row->attendance as $attendance) {
            $day[intval($attendance->shamsi_day)] = $attendance->label;
        }

        for ($j = 1; $j <= 31; $j++) {
        }

        $column = array_merge([
            $row->registare_no,
            $row->name,
            $row->last_name,
            $row->father_name,
        ], $day);
        return $column;
    }

    public function headings(): array
    {
        $columnDay = [];
        $day = array_fill(1, 31, '');
        foreach ($day as $key => $i) {
            $columnDay[$key] = $key;
        }
        $column = array_merge([
            trans("Register No"),
            trans("Name"),
            trans("Last Name"),
            trans("Father Name"),
        ], $columnDay);
        return $column;

    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);

            }
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 3,
            'F' => 3,
            'G' => 3,
            'H' => 3,
            'I' => 3,
            'J' => 3,
            'K' => 3,
            'L' => 3,
            'M' => 3,
            'N' => 3,
            'O' => 3,
            'P' => 3,
            'Q' => 3,
            'R' => 3,
            'S' => 3,
            'T' => 3,
            'U' => 3,
            'V' => 3,
            'W' => 3,
            'X' => 3,
            'Y' => 3,
            'Z' => 3,
            'AA' => 3,
            'AB' => 3,
            'AC' => 3,
            'AD' => 3,
            'AE' => 3,
            'AF' => 3,
            'AG' => 3,
            'AH' => 3,
            'AI' => 3,
            'AJ' => 3,
            'AK' => 3,
            'AL' => 3,
            'AM' => 3,
            'AN' => 3,
            'AO' => 3,
            'AP' => 3,
            'AQ' => 3,
            'AR' => 3,
            'AS' => 3,
        ];
    }
    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): void
    {
        $sheet->getStyle('A1:AI1')->getFont()->setBold(true);
        $sheet->getStyle('A1:AI1')->getBorders();
    }
}
