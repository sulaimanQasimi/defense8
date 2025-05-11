<?php

namespace Sq\Employee\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Carbon\Carbon;

class CardInfoImport implements ToCollection
{
    protected $department_id;
    protected $errors = [];
    protected $uploadedPhotoPath;
    protected $gate_id;

    public function __construct($department_id, $uploadedPhotoPath = null, $gate_id = null)
    {
        $this->department_id = $department_id;
        $this->uploadedPhotoPath = $uploadedPhotoPath;
        $this->gate_id = $gate_id;
    }

    public function collection(Collection $rows)
    {
        // Create a data array to store the employee information
        $data = [];

        // Skip the header row
        $skipHeader = true;

        // Process each row to collect field-value pairs
        foreach ($rows as $row) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }

            // Skip empty rows or section titles
            if (empty($row[0]) || empty($row[1]) ||
                $row[0] === 'معلومات اسلحه' ||
                $row[0] === 'معلومات وسیله نقلیه') {
                continue;
            }

            // Map Persian field names to the corresponding properties
            switch (trim($row[0])) {
                case 'شماره ثبت':
                    $data['register_no'] = trim($row[1]);
                    break;
                case 'نام':
                    $data['name'] = trim($row[1]);
                    break;
                case 'نام خانوادگی':
                    $data['last_name'] = trim($row[1]);
                    break;
                case 'نام پدر':
                    $data['father_name'] = trim($row[1]);
                    break;
                case 'نام پدرکلان':
                    $data['grand_father_name'] = trim($row[1]);
                    break;
                case 'جنسیت (مرد/زن)':
                    $data['gender'] = trim($row[1]);
                    break;
                case 'تاریخ تولد (YYYY-MM-DD)':
                    $data['birthday'] = trim($row[1]);
                    break;
                case 'گروه خونی':
                    $data['blood_group'] = trim($row[1]);
                    break;
                case 'مسیر عکس':
                    // Only use the value from Excel if it's not empty and we don't have an uploaded photo
                    if (!empty(trim($row[1])) && empty($this->uploadedPhotoPath)) {
                        $data['photo_path'] = trim($row[1]);
                    } else {
                        $data['photo_path'] = $this->uploadedPhotoPath ?: null;
                    }
                    break;
                case 'کد ملی':
                    $data['national_id'] = trim($row[1]);
                    break;
                case 'دسته‌بندی':
                    $data['category'] = trim($row[1]);
                    break;
                case 'دیپارتمنت':
                    $data['department'] = trim($row[1]);
                    break;
                case 'موقعیت':
                    $data['position'] = trim($row[1]);
                    break;
                case 'درجه':
                    $data['degree'] = trim($row[1]);
                    break;
                case 'ساختار شغلی':
                    $data['job_structure'] = trim($row[1]);
                    break;
                case 'رتبه':
                    $data['grade'] = trim($row[1]);
                    break;
                case 'وظیفه':
                    $data['acupation'] = trim($row[1]);
                    break;
                case 'شغل قبلی':
                    $data['previous_job'] = trim($row[1]);
                    break;
                case 'شماره تلفن':
                    $data['phone'] = trim($row[1]);
                    break;
                case 'آدرس':
                    $data['address'] = trim($row[1]);
                    break;
                // Combined address fields instead of individual province/district/village
                case 'آدرس کامل اصلی (متنی)':
                    $data['address_main'] = trim($row[1]);
                    break;
                case 'آدرس کامل فعلی (متنی)':
                    $data['address_current'] = trim($row[1]);
                    break;
                // Main location fields (from dropdowns)
                case 'استان اصلی (انتخاب از لیست)':
                    // Extract the ID from the format "ID - Name"
                    if (preg_match('/^(\d+)\s+-\s+/', trim($row[1]), $matches)) {
                        $data['m_province_id'] = (int)$matches[1];
                    }
                    break;
                case 'شهرستان اصلی (انتخاب از لیست)':
                    if (preg_match('/^(\d+)\s+-\s+/', trim($row[1]), $matches)) {
                        $data['m_district_id'] = (int)$matches[1];
                    }
                    break;
                case 'روستا اصلی (انتخاب از لیست)':
                    if (preg_match('/^(\d+)\s+-\s+/', trim($row[1]), $matches)) {
                        $data['m_village_id'] = (int)$matches[1];
                    }
                    break;
                // Current location fields (from dropdowns)
                case 'استان فعلی (انتخاب از لیست)':
                    if (preg_match('/^(\d+)\s+-\s+/', trim($row[1]), $matches)) {
                        $data['c_province_id'] = (int)$matches[1];
                    }
                    break;
                case 'شهرستان فعلی (انتخاب از لیست)':
                    if (preg_match('/^(\d+)\s+-\s+/', trim($row[1]), $matches)) {
                        $data['c_district_id'] = (int)$matches[1];
                    }
                    break;
                case 'روستا فعلی (انتخاب از لیست)':
                    if (preg_match('/^(\d+)\s+-\s+/', trim($row[1]), $matches)) {
                        $data['c_village_id'] = (int)$matches[1];
                    }
                    break;
                // Gun information
                case 'نوع اسلحه':
                    $data['gun_type'] = trim($row[1]);
                    break;
                case 'شماره سریال اسلحه':
                    $data['gun_serial_number'] = trim($row[1]);
                    break;
                case 'شماره جواز اسلحه':
                    $data['gun_license_number'] = trim($row[1]);
                    break;
                case 'نوع سلاح برای کارت ویژه':
                    $data['special_gun'] = trim($row[1]);
                    break;
                // Vehicle information
                case 'نوع وسیله نقلیه':
                    $data['vehicle_type'] = trim($row[1]);
                    break;
                case 'مدل وسیله نقلیه':
                    $data['vehicle_model'] = trim($row[1]);
                    break;
                case 'رنگ وسیله نقلیه':
                    $data['vehicle_color'] = trim($row[1]);
                    break;
                case 'پلاک وسیله نقلیه':
                    $data['vehicle_plate'] = trim($row[1]);
                    break;
                case 'نوع واسطه برای کارت ویژه':
                    $data['special_vehical'] = trim($row[1]);
                    break;
                case 'شیشه سیاه برای کارت ویژه':
                    $data['special_black_mirror'] = trim($row[1]);
                    break;
                case 'ملاحظات':
                    $data['remark'] = trim($row[1]);
                    break;
            }
        }

        // Validate the collected data
        if ($this->validateData($data)) {
            try {

                // Process the data
                $cardInfo = new CardInfo();
                $cardInfo->registare_no = $data['register_no'];
                $cardInfo->name = $data['name'];
                $cardInfo->last_name = $data['last_name'];
                $cardInfo->father_name = $data['father_name'];
                $cardInfo->grand_father_name = $data['grand_father_name'] ?? null;

                // Convert Persian gender to the required format
                $cardInfo->gender = ($data['gender'] === 'مرد') ? 1 : 0;

                $cardInfo->birthday = Carbon::parse($data['birthday']);
                $cardInfo->blood_group = $data['blood_group'] ?? null;
                $cardInfo->national_id = $data['national_id'] ?? null;
                
                // Set job-related fields
                $cardInfo->department = $data['department'] ?? null;
                $cardInfo->position = $data['position'] ?? null;
                $cardInfo->job_structure = $data['job_structure'] ?? null;
                $cardInfo->degree = $data['degree'] ?? null;
                $cardInfo->grade = $data['grade'] ?? null;
                $cardInfo->acupation = $data['acupation'] ?? null;
                $cardInfo->previous_job = $data['previous_job'] ?? null;
                $cardInfo->category = $data['category'] ?? null;
                
                // Skip setting location fields directly - they will be set as IDs
                $skipFields = [
                    'm_province', 'm_district', 'm_village',
                    'c_province', 'c_district', 'c_village',
                ];

                foreach ($data as $key => $value) {
                    if (in_array($key, $skipFields)) {
                        continue;
                    }
                    
                    // Set location IDs from the extracted data
                    if ($key === 'm_province_id') {
                        $cardInfo->m_province_id = $value;
                    } elseif ($key === 'm_district_id') {
                        $cardInfo->m_district_id = $value;
                    } elseif ($key === 'm_village_id') {
                        $cardInfo->m_village_id = $value;
                    } elseif ($key === 'c_province_id') {
                        $cardInfo->c_province_id = $value;
                    } elseif ($key === 'c_district_id') {
                        $cardInfo->c_district_id = $value;
                    } elseif ($key === 'c_village_id') {
                        $cardInfo->c_village_id = $value;
                    } elseif ($key === 'address') {
                        // Handle address fields
                        $mainAddress = isset($data['address_main']) ? $data['address_main'] : '';
                        $currentAddress = isset($data['address_current']) ? $data['address_current'] : '';
                        
                        // Combine addresses if they exist
                        $fullAddress = $value;
                        if (!empty($mainAddress)) {
                            $fullAddress .= "\nآدرس اصلی: " . $mainAddress;
                        }
                        if (!empty($currentAddress)) {
                            $fullAddress .= "\nآدرس فعلی: " . $currentAddress;
                        }
                        
                        $cardInfo->address = $fullAddress;
                    } else {
                        $cardInfo->$key = $value;
                    }
                }
                
                // Set department_id from constructor parameter (not string value)
                $cardInfo->department_id = $this->department_id;
                
                // Set gate_id if provided
                if ($this->gate_id) {
                    $cardInfo->gate_id = $this->gate_id;
                }
                
                $cardInfo->remark = $data['remark'] ?? null;

                // Handle extra info for gun and vehicle
                $extraInfo = [
                    'gun' => [
                        'type' => $data['gun_type'] ?? null,
                        'serial_number' => $data['gun_serial_number'] ?? null,
                        'license_number' => $data['gun_license_number'] ?? null,
                    ],
                    'vehicle' => [
                        'type' => $data['vehicle_type'] ?? null,
                        'model' => $data['vehicle_model'] ?? null,
                        'color' => $data['vehicle_color'] ?? null,
                        'plate' => $data['vehicle_plate'] ?? null,
                    ]
                ];

                $cardInfo->extra_info = $extraInfo;
                $cardInfo->confirmed = false;

                // Handle photo path
                if (!empty($data['photo_path'])) {
                    // If this is the uploaded photo path, use it directly
                    if ($data['photo_path'] === $this->uploadedPhotoPath) {
                        $cardInfo->photo = $data['photo_path'];
                    } else {
                        // Otherwise normalize and check the path from Excel
                        $photoPath = $this->normalizePhotoPath($data['photo_path']);

                        // Check if the file exists
                        if ($this->photoExists($photoPath)) {
                            $cardInfo->photo = $photoPath;
                        } else {
                            $this->errors[] = "فایل تصویر پیدا نشد: " . $photoPath;
                        }
                    }
                }

                $cardInfo->save();

            } catch (\Exception $e) {
                $this->errors[] = "خطا در ذخیره کارمند: " . $e->getMessage() . " در خط " . $e->getLine();

                // Log the exception for further debugging
                \Illuminate\Support\Facades\Log::error('CardInfoImport Error: ' . $e->getMessage(), [
                    'exception' => $e,
                    'data' => $data,
                    'department_id' => $this->department_id
                ]);
            }
        }
    }

    /**
     * Normalize the photo path to work with Laravel Storage
     *
     * @param string $path
     * @return string
     */
    protected function normalizePhotoPath($path)
    {
        // Remove any quotes that might be in the Excel path
        $path = str_replace('"', '', $path);

        // Remove any file:// protocol
        $path = preg_replace('/^file:\/\/\/?/', '', $path);

        // For Windows paths, convert backslashes to forward slashes
        $path = str_replace('\\', '/', $path);

        // If the path is an absolute path, try to make it relative to storage
        if (strpos($path, '/') === 0) {
            // Already starts with slash, keep it as is
            return $path;
        } else if (preg_match('/^[A-Za-z]:\//i', $path)) {
            // Windows absolute path, extract filename and use that
            return '/uploads/photos/' . basename($path);
        } else if (!preg_match('/^\/|uploads|storage/i', $path)) {
            // Doesn't seem to be a system path, prepend uploads/photos
            return '/uploads/photos/' . $path;
        }

        return $path;
    }

    /**
     * Check if the photo file exists
     *
     * @param string $path
     * @return bool
     */
    protected function photoExists($path)
    {
        // Remove leading slash for Storage facade
        $path = ltrim($path, '/');

        // Try different storage disks
        if (Storage::exists($path)) {
            return true;
        }

        if (Storage::disk('public')->exists($path)) {
            return true;
        }

        // Also check if the file exists in the public directory
        if (file_exists(public_path($path))) {
            return true;
        }

        return false;
    }

    /**
     * Validate the employee data
     *
     * @param array $data
     * @return bool
     */
    protected function validateData($data)
    {
        $validator = Validator::make($data, [
            'register_no' => 'required|string',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'father_name' => 'required|string',
            'gender' => 'required|in:مرد,زن',
            'birthday' => 'required|date',
            'department' => 'required|string',
            'grand_father_name' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'national_id' => 'nullable|string',
            'position' => 'nullable|string',
            'job_structure' => 'nullable|string',
            'degree' => 'nullable|string',
            'grade' => 'nullable|string',
            'category' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'address_main' => 'nullable|string',
            'address_current' => 'nullable|string',
            'm_province_id' => 'nullable|integer|exists:provinces,id',
            'm_district_id' => 'nullable|integer|exists:districts,id',
            'm_village_id' => 'nullable|integer|exists:villages,id',
            'c_province_id' => 'nullable|integer|exists:provinces,id',
            'c_district_id' => 'nullable|integer|exists:districts,id',
            'c_village_id' => 'nullable|integer|exists:villages,id',
            'special_gun' => 'nullable|string',
            'special_vehical' => 'nullable|string',
            'special_black_mirror' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->errors[] = $error;
            }
            return false;
        }

        // Check if department_id is valid
        if (!$this->department_id) {
            $this->errors[] = "شناسه دیپارتمان نامعتبر است.";
            return false;
        }

        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
