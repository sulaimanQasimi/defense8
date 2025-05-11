<?php

namespace Sq\Employee\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Sq\Location\Models\Province;
use Sq\Location\Models\District;
use Sq\Location\Models\Village;

class CardInfoImportTemplate implements FromCollection, WithHeadings, WithEvents, WithColumnWidths, WithStyles
{
    public function collection()
    {
        // Return an empty collection as this is just a template
        return new Collection([]);
    }

    public function headings(): array
    {
        return [
            'فیلد',                  // Field name
            'مقدار',                 // Value to be filled by user
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);

                // Add title
                $event->sheet->setCellValue('A1', 'فیلد');
                $event->sheet->setCellValue('B1', 'مقدار');

                // Personal Information section
                $event->sheet->setCellValue('A2', 'اطلاعات شخصی');
                $event->sheet->getStyle('A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A2:B2');

                $event->sheet->setCellValue('A3', 'شماره ثبت');
                $event->sheet->setCellValue('B3', 'EMP001');

                $event->sheet->setCellValue('A4', 'نام');
                $event->sheet->setCellValue('B4', 'احمد');

                $event->sheet->setCellValue('A5', 'نام خانوادگی');
                $event->sheet->setCellValue('B5', 'محمدی');

                $event->sheet->setCellValue('A6', 'نام پدر');
                $event->sheet->setCellValue('B6', 'محمود');

                $event->sheet->setCellValue('A7', 'نام پدرکلان');
                $event->sheet->setCellValue('B7', 'علی');

                $event->sheet->setCellValue('A8', 'جنسیت (مرد/زن)');
                $event->sheet->setCellValue('B8', 'مرد');

                $event->sheet->setCellValue('A9', 'تاریخ تولد (YYYY-MM-DD)');
                $event->sheet->setCellValue('B9', '1990-01-01');

                $event->sheet->setCellValue('A10', 'گروه خونی');
                $event->sheet->setCellValue('B10', 'O+');

                $event->sheet->setCellValue('A11', 'کد ملی');
                $event->sheet->setCellValue('B11', '1234567890');

                $event->sheet->setCellValue('A12', 'شماره تلفن');
                $event->sheet->setCellValue('B12', '0789123456');

                $event->sheet->setCellValue('A13', 'آدرس');
                $event->sheet->setCellValue('B13', 'کابل، افغانستان');

                $event->sheet->setCellValue('A14', 'مسیر عکس');
                $event->sheet->setCellValue('B14', 'اینجا عکس را درج کنید (کلیک + درج)');

                // Job Information section
                $event->sheet->setCellValue('A16', 'اطلاعات شغلی');
                $event->sheet->getStyle('A16')->getFont()->setBold(true);
                $event->sheet->getStyle('A16')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A16')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A16:B16');

                $event->sheet->setCellValue('A17', 'دسته‌بندی');
                $event->sheet->setCellValue('B17', 'منسوبین نظامی');

                $event->sheet->setCellValue('A18', 'دیپارتمنت');
                $event->sheet->setCellValue('B18', 'آی تی');

                $event->sheet->setCellValue('A19', 'موقعیت');
                $event->sheet->setCellValue('B19', 'برنامه نویس');

                $event->sheet->setCellValue('A20', 'ساختار شغلی');
                $event->sheet->setCellValue('B20', 'متخصص نرم افزار');

                $event->sheet->setCellValue('A21', 'درجه');
                $event->sheet->setCellValue('B21', 'کارشناس');

                $event->sheet->setCellValue('A22', 'رتبه');
                $event->sheet->setCellValue('B22', '3');

                $event->sheet->setCellValue('A23', 'وظیفه');
                $event->sheet->setCellValue('B23', 'برنامه نویس');

                $event->sheet->setCellValue('A24', 'شغل قبلی');
                $event->sheet->setCellValue('B24', 'مدیر پروژه');

                // Address Information - Main
                $event->sheet->setCellValue('A26', 'آدرس اصلی');
                $event->sheet->getStyle('A26')->getFont()->setBold(true);
                $event->sheet->getStyle('A26')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A26')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A26:B26');

                $event->sheet->setCellValue('A27', 'آدرس کامل اصلی (متنی)');
                $event->sheet->setCellValue('B27', 'استان، شهرستان و روستای اصلی');

                // Add province/district/village fields with dropdowns
                $event->sheet->setCellValue('A28', 'استان اصلی (انتخاب از لیست)');
                $event->sheet->setCellValue('B28', '');

                $event->sheet->setCellValue('A29', 'شهرستان اصلی (انتخاب از لیست)');
                $event->sheet->setCellValue('B29', '');

                $event->sheet->setCellValue('A30', 'روستا اصلی (انتخاب از لیست)');
                $event->sheet->setCellValue('B30', '');

                // Address Information - Current
                $event->sheet->setCellValue('A32', 'آدرس فعلی');
                $event->sheet->getStyle('A32')->getFont()->setBold(true);
                $event->sheet->getStyle('A32')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A32')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A32:B32');

                $event->sheet->setCellValue('A33', 'آدرس کامل فعلی (متنی)');
                $event->sheet->setCellValue('B33', 'استان، شهرستان و روستای فعلی');

                // Add current province/district/village fields with dropdowns
                $event->sheet->setCellValue('A34', 'استان فعلی (انتخاب از لیست)');
                $event->sheet->setCellValue('B34', '');

                $event->sheet->setCellValue('A35', 'شهرستان فعلی (انتخاب از لیست)');
                $event->sheet->setCellValue('B35', '');

                $event->sheet->setCellValue('A36', 'روستا فعلی (انتخاب از لیست)');
                $event->sheet->setCellValue('B36', '');

                // Add note about province/district/village selections
                $event->sheet->setCellValue('C28', 'توجه: برای استان، شهرستان و روستا از لیست کشویی استفاده کنید. در هنگام وارد کردن، شناسه (ID) آنها استفاده خواهد شد.');
                $event->sheet->getStyle('C28')->getFont()->setBold(true);
                $event->sheet->getStyle('C28')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFCCCC');
                $event->sheet->mergeCells('C28:D31');
                $event->sheet->getStyle('C28:D31')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('C28:D31')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Gun information section
                $event->sheet->setCellValue('A38', 'معلومات اسلحه');
                $event->sheet->getStyle('A38')->getFont()->setBold(true);
                $event->sheet->getStyle('A38')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A38')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A38:B38');

                $event->sheet->setCellValue('A39', 'نوع اسلحه');
                $event->sheet->setCellValue('B39', 'تفنگچه');

                $event->sheet->setCellValue('A40', 'شماره سریال اسلحه');
                $event->sheet->setCellValue('B40', 'G12345');

                $event->sheet->setCellValue('A41', 'شماره جواز اسلحه');
                $event->sheet->setCellValue('B41', 'L54321');

                $event->sheet->setCellValue('A42', 'نوع سلاح برای کارت ویژه');
                $event->sheet->setCellValue('B42', 'کلاشینکف');

                // Vehicle information section
                $event->sheet->setCellValue('A44', 'معلومات وسیله نقلیه');
                $event->sheet->getStyle('A44')->getFont()->setBold(true);
                $event->sheet->getStyle('A44')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A44')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A44:B44');

                $event->sheet->setCellValue('A45', 'نوع وسیله نقلیه');
                $event->sheet->setCellValue('B45', 'موتر');

                $event->sheet->setCellValue('A46', 'مدل وسیله نقلیه');
                $event->sheet->setCellValue('B46', 'تویوتا کرولا');

                $event->sheet->setCellValue('A47', 'رنگ وسیله نقلیه');
                $event->sheet->setCellValue('B47', 'سفید');

                $event->sheet->setCellValue('A48', 'پلاک وسیله نقلیه');
                $event->sheet->setCellValue('B48', 'KBL-123');

                $event->sheet->setCellValue('A49', 'نوع واسطه برای کارت ویژه');
                $event->sheet->setCellValue('B49', 'لندکروزر');

                $event->sheet->setCellValue('A50', 'شیشه سیاه برای کارت ویژه');
                $event->sheet->setCellValue('B50', 'دارد');

                // Additional Information
                $event->sheet->setCellValue('A52', 'سایر اطلاعات');
                $event->sheet->getStyle('A52')->getFont()->setBold(true);
                $event->sheet->getStyle('A52')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('A52')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->mergeCells('A52:B52');

                $event->sheet->setCellValue('A53', 'ملاحظات');
                $event->sheet->setCellValue('B53', 'یادداشت های اضافی در مورد کارمند');

                // Style the example values
                $event->sheet->getStyle('B3:B53')->getFont()->setItalic(true);
                $event->sheet->getStyle('B3:B53')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EFEFEF');

                // Make cell B14 stand out clearly as the place to put photos
                $event->sheet->setCellValue('B14', 'اینجا عکس را درج کنید (کلیک + درج)');
                $event->sheet->getStyle('B14')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $event->sheet->getStyle('B14')->getFont()->setColor(new Color(Color::COLOR_WHITE));
                $event->sheet->getStyle('B14')->getFont()->setBold(true);
                $event->sheet->getStyle('B14')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
                $event->sheet->getStyle('B14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('B14')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getRowDimension(14)->setRowHeight(40);

                // Add clear photo instructions in adjacent cell
                $event->sheet->setCellValue('C14', '← عکس را اینجا درج کنید');
                $event->sheet->getStyle('C14')->getFont()->setBold(true);
                $event->sheet->getStyle('C14')->getFont()->setSize(12);
                $event->sheet->getStyle('C14')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFD966');
                $event->sheet->getStyle('C14')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Add detailed photo instructions that actually work
                $instructionsText = "مراحل افزودن عکس:
1. روی سلول آبی کلیک کنید
2. به منوی Insert/درج بروید
3. Pictures/تصویر را انتخاب کنید
4. This Device/از این دستگاه را انتخاب کنید
5. عکس را انتخاب کنید و درج کنید
6. اگر عکس بزرگ بود آن را کوچک کنید تا در سلول جای بگیرد";

                $event->sheet->setCellValue('C15', $instructionsText);
                $event->sheet->mergeCells('C15:D21');
                $event->sheet->getStyle('C15:D21')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EAF1FB');
                $event->sheet->getStyle('C15:D21')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('C15:D21')->getFont()->setSize(11);
                $event->sheet->getStyle('C15:D21')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Add blood group dropdown
                $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                $validation = $event->sheet->getCell('B10')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('خطای ورودی');
                $validation->setError('مقدار انتخاب شده در لیست نیست.');
                $validation->setPromptTitle('انتخاب از لیست');
                $validation->setPrompt('لطفاً یک گروه خونی را انتخاب کنید.');
                $validation->setFormula1('"'.implode(',', $bloodGroups).'"');

                // Add province dropdowns with IDs
                $provinces = Province::all(['id', 'name'])->map(function($province) {
                    return $province->id . ' - ' . $province->name;
                })->toArray();
                
                // Main province dropdown
                $provinceValidation = $event->sheet->getCell('B28')->getDataValidation();
                $provinceValidation->setType(DataValidation::TYPE_LIST);
                $provinceValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $provinceValidation->setAllowBlank(true);
                $provinceValidation->setShowInputMessage(true);
                $provinceValidation->setShowErrorMessage(true);
                $provinceValidation->setShowDropDown(true);
                $provinceValidation->setErrorTitle('خطای ورودی');
                $provinceValidation->setError('مقدار انتخاب شده در لیست نیست.');
                $provinceValidation->setPromptTitle('انتخاب استان');
                $provinceValidation->setPrompt('لطفاً یک استان را انتخاب کنید.');
                if (count($provinces) > 0) {
                    $provinceValidation->setFormula1('"'.implode(',', $provinces).'"');
                } else {
                    $provinceValidation->setFormula1('"لطفا ابتدا استان‌ها را در سیستم تعریف کنید"');
                }
                
                // Current province dropdown
                $currentProvinceValidation = $event->sheet->getCell('B34')->getDataValidation();
                $currentProvinceValidation->setType(DataValidation::TYPE_LIST);
                $currentProvinceValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $currentProvinceValidation->setAllowBlank(true);
                $currentProvinceValidation->setShowInputMessage(true);
                $currentProvinceValidation->setShowErrorMessage(true);
                $currentProvinceValidation->setShowDropDown(true);
                $currentProvinceValidation->setErrorTitle('خطای ورودی');
                $currentProvinceValidation->setError('مقدار انتخاب شده در لیست نیست.');
                $currentProvinceValidation->setPromptTitle('انتخاب استان');
                $currentProvinceValidation->setPrompt('لطفاً یک استان را انتخاب کنید.');
                if (count($provinces) > 0) {
                    $currentProvinceValidation->setFormula1('"'.implode(',', $provinces).'"');
                } else {
                    $currentProvinceValidation->setFormula1('"لطفا ابتدا استان‌ها را در سیستم تعریف کنید"');
                }
                
                // Add special note about district and village selections
                $event->sheet->setCellValue('B29', 'ابتدا استان را انتخاب کنید و سپس در سیستم، شهرستان را انتخاب کنید');
                $event->sheet->setCellValue('B30', 'ابتدا استان و شهرستان را انتخاب کنید و سپس در سیستم، روستا را انتخاب کنید');
                $event->sheet->setCellValue('B35', 'ابتدا استان را انتخاب کنید و سپس در سیستم، شهرستان را انتخاب کنید');
                $event->sheet->setCellValue('B36', 'ابتدا استان و شهرستان را انتخاب کنید و سپس در سیستم، روستا را انتخاب کنید');
                
                // Add category dropdown
                $categories = ['منسوبین نظامی', 'کارمندان ملکی', 'کارکنان خدمتی و مؤقت'];
                $categoryValidation = $event->sheet->getCell('B17')->getDataValidation();
                $categoryValidation->setType(DataValidation::TYPE_LIST);
                $categoryValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $categoryValidation->setAllowBlank(true);
                $categoryValidation->setShowInputMessage(true);
                $categoryValidation->setShowErrorMessage(true);
                $categoryValidation->setShowDropDown(true);
                $categoryValidation->setErrorTitle('خطای ورودی');
                $categoryValidation->setError('مقدار انتخاب شده در لیست نیست.');
                $categoryValidation->setPromptTitle('انتخاب از لیست');
                $categoryValidation->setPrompt('لطفاً یک دسته‌بندی را انتخاب کنید.');
                $categoryValidation->setFormula1('"'.implode(',', $categories).'"');

                // Add gender dropdown
                $genders = ['مرد', 'زن'];
                $genderValidation = $event->sheet->getCell('B8')->getDataValidation();
                $genderValidation->setType(DataValidation::TYPE_LIST);
                $genderValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $genderValidation->setAllowBlank(false);
                $genderValidation->setShowInputMessage(true);
                $genderValidation->setShowErrorMessage(true);
                $genderValidation->setShowDropDown(true);
                $genderValidation->setErrorTitle('خطای ورودی');
                $genderValidation->setError('مقدار انتخاب شده در لیست نیست.');
                $genderValidation->setPromptTitle('انتخاب از لیست');
                $genderValidation->setPrompt('لطفاً جنسیت را انتخاب کنید.');
                $genderValidation->setFormula1('"'.implode(',', $genders).'"');

                // Black mirror dropdown for special card
                $blackMirrorOptions = ['دارد', 'ندارد'];
                $blackMirrorValidation = $event->sheet->getCell('B50')->getDataValidation();
                $blackMirrorValidation->setType(DataValidation::TYPE_LIST);
                $blackMirrorValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $blackMirrorValidation->setAllowBlank(true);
                $blackMirrorValidation->setShowInputMessage(true);
                $blackMirrorValidation->setShowErrorMessage(true);
                $blackMirrorValidation->setShowDropDown(true);
                $blackMirrorValidation->setErrorTitle('خطای ورودی');
                $blackMirrorValidation->setError('مقدار انتخاب شده در لیست نیست.');
                $blackMirrorValidation->setPromptTitle('انتخاب از لیست');
                $blackMirrorValidation->setPrompt('لطفاً وضعیت شیشه سیاه را انتخاب کنید.');
                $blackMirrorValidation->setFormula1('"'.implode(',', $blackMirrorOptions).'"');

                // Add instructions row
                $event->sheet->mergeCells('A55:D55');
                $event->sheet->setCellValue('A55', 'دستورالعمل: ستون مقدار را با اطلاعات کارمند پر کنید. برای عکس، لطفاً از دستورالعمل‌های ارائه شده در کنار سلول مسیر عکس استفاده کنید.');
                $event->sheet->getStyle('A55')->getFont()->setBold(true);
                $event->sheet->getStyle('A55')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $event->sheet->getStyle('A55')->getAlignment()->setWrapText(true);
                $event->sheet->getRowDimension(55)->setRowHeight(40);

                // Set the row height for photo instructions to fit all the text
                $event->sheet->getRowDimension(15)->setRowHeight(160);

                // Add dropdowns for districts and villages
                $provinces = Province::all();
                $districts = District::all();
                $villages = Village::all();
                
                // Blood group dropdown
                $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                $validation = $event->sheet->getDataValidation('B12');
                $validation->setType(DataValidation::TYPE_LIST)
                    ->setErrorStyle(DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(true)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('خطای انتخاب')
                    ->setError('مقدار انتخاب شده در لیست وجود ندارد')
                    ->setPromptTitle('انتخاب از لیست')
                    ->setPrompt('لطفا یک گزینه از لیست انتخاب کنید')
                    ->setFormula1('"' . implode(',', $bloodGroups) . '"');
                
                // Province dropdown for main address
                $provincesForDropdown = $provinces->map(function ($province) {
                    return $province->id . ' - ' . $province->name;
                })->implode(',');
                
                $validation = $event->sheet->getDataValidation('B28');
                $validation->setType(DataValidation::TYPE_LIST)
                    ->setErrorStyle(DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(true)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('خطای انتخاب')
                    ->setError('مقدار انتخاب شده در لیست وجود ندارد')
                    ->setPromptTitle('انتخاب از لیست')
                    ->setPrompt('لطفا استان را از لیست انتخاب کنید')
                    ->setFormula1('"' . $provincesForDropdown . '"');
                
                // District dropdown for main address - using the same Excel feature
                $districtsByProvince = [];
                foreach ($provinces as $province) {
                    $districtList = $districts->where('province_id', $province->id)
                        ->map(function ($district) {
                            return $district->id . ' - ' . $district->name;
                        })->implode(',');
                    
                    if (!empty($districtList)) {
                        $districtsByProvince[] = $province->id . ' - ' . $province->name . ': ' . $districtList;
                    }
                }
                
                // Add note about districts
                $event->sheet->setCellValue('C29', 'برای انتخاب شهرستان، ابتدا استان را انتخاب نمایید. سپس با مراجعه به برگه «راهنمای انتخاب» شهرستان‌های استان انتخابی را مشاهده و یکی را انتخاب کنید.');
                $event->sheet->getStyle('C29')->getAlignment()->setWrapText(true);
                
                // Village dropdown - similar approach
                $villagesByDistrict = [];
                foreach ($districts as $district) {
                    $villageList = $villages->where('district_id', $district->id)
                        ->map(function ($village) {
                            return $village->id . ' - ' . $village->name;
                        })->implode(',');
                    
                    if (!empty($villageList)) {
                        $villagesByDistrict[] = $district->id . ' - ' . $district->name . ': ' . $villageList;
                    }
                }
                
                // Add note about villages
                $event->sheet->setCellValue('C30', 'برای انتخاب روستا، ابتدا شهرستان را انتخاب نمایید. سپس با مراجعه به برگه «راهنمای انتخاب» روستاهای شهرستان انتخابی را مشاهده و یکی را انتخاب کنید.');
                $event->sheet->getStyle('C30')->getAlignment()->setWrapText(true);
                
                // Province dropdown for current address - same as main
                $validation = $event->sheet->getDataValidation('B34');
                $validation->setType(DataValidation::TYPE_LIST)
                    ->setErrorStyle(DataValidation::STYLE_INFORMATION)
                    ->setAllowBlank(true)
                    ->setShowInputMessage(true)
                    ->setShowErrorMessage(true)
                    ->setShowDropDown(true)
                    ->setErrorTitle('خطای انتخاب')
                    ->setError('مقدار انتخاب شده در لیست وجود ندارد')
                    ->setPromptTitle('انتخاب از لیست')
                    ->setPrompt('لطفا استان را از لیست انتخاب کنید')
                    ->setFormula1('"' . $provincesForDropdown . '"');
                
                // Add notes for current address selections
                $event->sheet->setCellValue('C35', 'برای انتخاب شهرستان، ابتدا استان را انتخاب نمایید. سپس با مراجعه به برگه «راهنمای انتخاب» شهرستان‌های استان انتخابی را مشاهده و یکی را انتخاب کنید.');
                $event->sheet->getStyle('C35')->getAlignment()->setWrapText(true);
                
                $event->sheet->setCellValue('C36', 'برای انتخاب روستا، ابتدا شهرستان را انتخاب نمایید. سپس با مراجعه به برگه «راهنمای انتخاب» روستاهای شهرستان انتخابی را مشاهده و یکی را انتخاب کنید.');
                $event->sheet->getStyle('C36')->getAlignment()->setWrapText(true);
                
                // Create a new sheet for location selection help
                $workbook = $event->sheet->getParent();
                $helpSheet = $workbook->createSheet();
                $helpSheet->setTitle('راهنمای انتخاب');
                
                // Add title for districts
                $helpSheet->setCellValue('A1', 'شهرستان‌ها بر اساس استان');
                $helpSheet->getStyle('A1')->getFont()->setBold(true);
                $helpSheet->getStyle('A1')->getFont()->setSize(14);
                
                // Add districts
                $rowNumber = 2;
                foreach ($provinces as $province) {
                    $helpSheet->setCellValue('A' . $rowNumber, $province->id . ' - ' . $province->name);
                    $helpSheet->getStyle('A' . $rowNumber)->getFont()->setBold(true);
                    $rowNumber++;
                    
                    $provinceDistricts = $districts->where('province_id', $province->id);
                    foreach ($provinceDistricts as $district) {
                        $helpSheet->setCellValue('B' . $rowNumber, $district->id . ' - ' . $district->name);
                        $rowNumber++;
                    }
                }
                
                // Add title for villages
                $rowNumber += 2;
                $helpSheet->setCellValue('A' . $rowNumber, 'روستاها بر اساس شهرستان');
                $helpSheet->getStyle('A' . $rowNumber)->getFont()->setBold(true);
                $helpSheet->getStyle('A' . $rowNumber)->getFont()->setSize(14);
                $rowNumber++;
                
                // Add villages
                foreach ($districts as $district) {
                    $districtVillages = $villages->where('district_id', $district->id);
                    if ($districtVillages->count() > 0) {
                        $helpSheet->setCellValue('A' . $rowNumber, $district->id . ' - ' . $district->name);
                        $helpSheet->getStyle('A' . $rowNumber)->getFont()->setBold(true);
                        $rowNumber++;
                        
                        foreach ($districtVillages as $village) {
                            $helpSheet->setCellValue('B' . $rowNumber, $village->id . ' - ' . $village->name);
                            $rowNumber++;
                        }
                    }
                }
                
                // Auto-size columns in help sheet
                $helpSheet->getColumnDimension('A')->setAutoSize(true);
                $helpSheet->getColumnDimension('B')->setAutoSize(true);
                
                // Add instructions at the bottom
                $helpSheet->setCellValue('A' . ($rowNumber + 2), 'راهنمای استفاده:');
                $helpSheet->getStyle('A' . ($rowNumber + 2))->getFont()->setBold(true);
                $helpSheet->setCellValue('A' . ($rowNumber + 3), '1. ابتدا استان را از لیست کشویی در برگه اصلی انتخاب کنید.');
                $helpSheet->setCellValue('A' . ($rowNumber + 4), '2. سپس به این برگه راهنما مراجعه کرده و شهرستان مورد نظر را از لیست شهرستان‌های استان انتخابی پیدا کنید.');
                $helpSheet->setCellValue('A' . ($rowNumber + 5), '3. شناسه و نام شهرستان (مانند «2 - تهران») را در سلول مربوطه در برگه اصلی وارد کنید.');
                $helpSheet->setCellValue('A' . ($rowNumber + 6), '4. برای انتخاب روستا، همین مراحل را با استفاده از بخش روستاها انجام دهید.');
                $helpSheet->setCellValue('A' . ($rowNumber + 7), 'توجه: دقت کنید که قالب وارد شده دقیقا مطابق با فرمت «شناسه - نام» باشد تا سیستم بتواند آن را به درستی پردازش کند.');
                
                // Hide the help sheet from immediate view (user can still access it)
                $helpSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);
            }
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,  // Field name - wider to accommodate longer names
            'B' => 40,  // Value
            'C' => 25,  // Button/instructions
            'D' => 15,  // Additional space for merged cells
        ];
    }

    public function styles(Worksheet $sheet): void
    {
        // Style headers
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DDDDDD');

        // Style field names
        $sheet->getStyle('A3:A53')->getFont()->setBold(true);

        // Add borders to all data cells
        $sheet->getStyle('A1:B53')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Style section headers (already styled in registerEvents but adding border consistency)
        $sheet->getStyle('A2:B2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A16:B16')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A26:B26')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A32:B32')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A38:B38')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $sheet->getStyle('A52:B52')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
    }
}
