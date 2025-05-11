<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Sq\Employee\Exports\CardInfoImportTemplate;
use Sq\Employee\Imports\CardInfoImport;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;

class CardInfoImportController extends Controller
{
    /**
     * Show the import form
     *
     * @return \Illuminate\View\View
     */
    public function showImportForm()
    {
        // Get departments the user has access to
        $departmentIds = UserDepartment::getUserDepartment();
        $departments = Department::whereIn('id', $departmentIds)->get();

        return view('sqemployee::import.form', [
            'departments' => $departments
        ]);
    }

    /**
     * Get gates for a department (AJAX)
     * 
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartmentGates(Request $request, Department $department)
    {
        // Check if user has permission for this department
        if (!in_array($department->id, UserDepartment::getUserDepartment())) {
            return response()->json(['error' => 'شما اجازه دسترسی به این دیپارتمان را ندارید'], 403);
        }

        $gates = $department->gates()->get();
        
        return response()->json([
            'gates' => $gates
        ]);
    }

    /**
     * Download the single employee import template
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        return Excel::download(new CardInfoImportTemplate(), 'قالب-وارد-کردن-کارمند.xlsx');
    }

    /**
     * Import a single employee's data from Excel file
     *
     * @param Request $request
     * @param Department $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request, Department $department)
    {
        // Check if user has permission for this department
        if (!in_array($department->id, UserDepartment::getUserDepartment())) {
            return redirect()->back()->with('error', 'شما اجازه وارد کردن اطلاعات به این دیپارتمان را ندارید.');
        }

        // Validate the request
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gate_id' => 'nullable|exists:gates,id'
        ], [
            'import_file.required' => 'لطفا یک فایل اکسل آپلود کنید.',
            'import_file.file' => 'فایل آپلود شده معتبر نیست.',
            'import_file.mimes' => 'فایل باید با فرمت xlsx یا xls باشد.',
            'photo_file.image' => 'فایل آپلود شده باید یک تصویر باشد.',
            'photo_file.mimes' => 'تصویر باید با فرمت jpeg، png، jpg یا gif باشد.',
            'photo_file.max' => 'حجم تصویر نباید بیشتر از 2 مگابایت باشد.',
            'gate_id.exists' => 'گیت انتخاب شده معتبر نیست.'
        ]);

        // Process separately uploaded photo if provided
        $photoPath = null;
        if ($request->hasFile('photo_file')) {
            $photoFile = $request->file('photo_file');
            $filename = time() . '_' . $photoFile->getClientOriginalName();
            $photoPath = $photoFile->storeAs('uploads/photos', $filename, 'public');
            $photoPath = '/storage/' . $photoPath; // Make it accessible via public URL
        } else {
            // Extract embedded images from Excel if there are any
            $photoPath = $this->extractImagesFromExcel($request->file('import_file')->getPathname());
        }

        // Import the data
        $importer = new CardInfoImport($department->id, $photoPath, $request->gate_id);
        Excel::import($importer, $request->file('import_file'));

        // Check for errors
        $errors = $importer->getErrors();
        if (count($errors) > 0) {
            return redirect()->back()->with('errors', $errors)->withInput();
        }

        return redirect()->back()->with('success', 'اطلاعات کارمند با موفقیت وارد شد.');
    }

    /**
     * Extract images from Excel file
     *
     * @param string $filePath
     * @return string|null
     */
    protected function extractImagesFromExcel($filePath)
    {
        try {
            // Create a temporary directory to extract files
            $tempDir = storage_path('app/public/temp_excel_' . time());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Copy the Excel file to a zip file
            $zipPath = $tempDir . '/excel.zip';
            copy($filePath, $zipPath);

            // Open the Excel file as a zip archive
            $zip = new \ZipArchive();
            if ($zip->open($zipPath) === true) {
                // Create the output directory for photos
                $outputDir = storage_path('app/public/uploads/photos');
                if (!file_exists($outputDir)) {
                    mkdir($outputDir, 0755, true);
                }

                // Generate a unique filename
                $filename = 'photo_' . time() . '.png';
                $outputPath = $outputDir . '/' . $filename;
                $found = false;

                // Extract all image files
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $fileName = $zip->getNameIndex($i);

                    // Look for image files in the media folder (where Excel stores embedded images)
                    if (strpos($fileName, 'xl/media/') === 0 &&
                        preg_match('/\.(png|jpe?g|gif|bmp)$/i', $fileName)) {

                        // Extract the image file
                        $imageData = $zip->getFromIndex($i);
                        file_put_contents($outputPath, $imageData);
                        $found = true;

                        // We only need one image, preferably the first one
                        break;
                    }
                }

                $zip->close();

                // Clean up temporary directory
                if (file_exists($zipPath)) {
                    unlink($zipPath);
                }
                if (file_exists($tempDir)) {
                    rmdir($tempDir);
                }

                if ($found) {
                    return '/storage/uploads/photos/' . $filename;
                }
            }

            return null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Excel Image Extraction Error: ' . $e->getMessage(), [
                'exception' => $e,
                'file_path' => $filePath
            ]);
            return null;
        }
    }

    /**
     * Get the file extension based on mime type
     *
     * @param string $mimeType
     * @return string
     */
    protected function getImageExtension($mimeType)
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
        ];

        return $extensions[$mimeType] ?? 'jpg';
    }

    /**
     * Upload a photo for the employee
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'photo.required' => 'لطفا یک تصویر انتخاب کنید.',
            'photo.image' => 'فایل آپلود شده باید یک تصویر باشد.',
            'photo.mimes' => 'تصویر باید با فرمت jpeg، png، jpg یا gif باشد.',
            'photo.max' => 'حجم تصویر نباید بیشتر از 2 مگابایت باشد.'
        ]);

        $photoFile = $request->file('photo');
        $filename = time() . '_' . $photoFile->getClientOriginalName();
        $photoPath = $photoFile->storeAs('uploads/photos', $filename, 'public');
        $fullPath = '/storage/' . $photoPath;

        return response()->json([
            'success' => true,
            'path' => $fullPath,
            'message' => 'تصویر با موفقیت آپلود شد.'
        ]);
    }
}
