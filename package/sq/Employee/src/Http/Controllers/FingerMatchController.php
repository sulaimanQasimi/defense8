<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sq\Employee\Models\BioData;
use Sq\Employee\Models\CardInfo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Sq\Employee\Services\FingerprintService;

class FingerMatchController extends Controller
{
    /**
     * @var FingerprintService
     */
    protected $fingerprintService;

    /**
     * Constructor
     *
     * @param FingerprintService $fingerprintService
     */
    public function __construct(FingerprintService $fingerprintService)
    {
        $this->fingerprintService = $fingerprintService;
    }

    /**
     * Display the fingerprint matching interface.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sqemployee::employee.finger_match');
    }

    /**
     * Match a fingerprint.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function match(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'ISOTemplateBase64' => 'nullable|string',
            'TemplateBase64' => 'nullable|string',
            'BMPBase64' => 'nullable|string',
            'debug' => 'boolean|nullable'
        ]);

        // Debug mode flag
        $debug = $request->input('debug', false);

        // Create response array with debug information
        $response = [
            'success' => false,
            'match' => false,
            'message' => '',
            'employee' => null,
            'method' => null
        ];

        if ($debug) {
            $response['debug'] = [
                'timestamp' => now()->toIso8601String(),
                'received' => [
                    'hasISOTemplate' => !empty($request->input('ISOTemplateBase64')),
                    'hasTemplate' => !empty($request->input('TemplateBase64')),
                    'hasBMP' => !empty($request->input('BMPBase64')),
                ],
                'meta' => $request->input('_meta', []),
                'steps' => []
            ];
        }

        // Ensure at least one template format is provided
        if (empty($request->input('ISOTemplateBase64')) &&
            empty($request->input('TemplateBase64')) &&
            empty($request->input('BMPBase64'))) {

            $response['message'] = 'No fingerprint template provided';

            if ($debug) {
                $response['debug']['steps'][] = [
                    'stage' => 'validation',
                    'status' => 'error',
                    'message' => 'No templates provided'
                ];
            }

            return response()->json($response);
        }

        try {
            $matchFound = false;
            $matchedEmployee = null;
            $matchMethod = null;

            // Get all employees with fingerprints (via BioData)
            $bioDataRecords = BioData::whereNotNull('ISOTemplateBase64')
                ->orWhereNotNull('TemplateBase64')
                ->get();

            if ($debug) {
                $response['debug']['steps'][] = [
                    'stage' => 'database',
                    'status' => 'info',
                    'message' => 'Found ' . $bioDataRecords->count() . ' fingerprint records'
                ];
            }

            if ($bioDataRecords->isEmpty()) {
                $response['message'] = 'No fingerprint records found in database';

                if ($debug) {
                    $response['debug']['steps'][] = [
                        'stage' => 'database',
                        'status' => 'warning',
                        'message' => 'No employees with fingerprint data'
                    ];
                }

                return response()->json($response);
            }

            // Create samples directory from BioData records
            $samplesDir = $this->fingerprintService->createSamplesFromBioData($bioDataRecords);

            if (!$samplesDir) {
                throw new \Exception("Failed to create samples directory");
            }

            if ($debug) {
                $response['debug']['steps'][] = [
                    'stage' => 'preparation',
                    'status' => 'info',
                    'message' => 'Created samples directory: ' . $samplesDir
                ];
            }

            // Try with ISO template if available
            if (!$matchFound && !empty($request->input('ISOTemplateBase64'))) {
                $isoTemplateBase64 = $request->input('ISOTemplateBase64');

                if ($debug) {
                    $response['debug']['steps'][] = [
                        'stage' => 'matching',
                        'method' => 'SecuGen',
                        'status' => 'info',
                        'message' => 'Starting SecuGen ISO template matching',
                        'templateLength' => strlen($isoTemplateBase64)
                    ];
                }

                // Create a temporary file with the ISO template
                $tempFile = tempnam(sys_get_temp_dir(), 'fingerprint_iso_');
                file_put_contents($tempFile, base64_decode($isoTemplateBase64));

                // Attempt to match the fingerprint
                $matchResult = $this->fingerprintService->match($tempFile, $samplesDir);

                if ($matchResult) {
                    // Extract the employee ID from the filename
                    preg_match('/employee_(\d+)\.dat/', $matchResult, $matches);

                    if (isset($matches[1])) {
                        $employeeId = $matches[1];

                        // Find the employee in the database
                        $employee = CardInfo::find($employeeId);

                        if ($employee) {
                            $matchFound = true;
                            $matchedEmployee = $employee;
                            $matchMethod = 'SecuGen';

                            if ($debug) {
                                $response['debug']['steps'][] = [
                                    'stage' => 'matching',
                                    'method' => 'SecuGen',
                                    'status' => 'success',
                                    'message' => 'Match found: ' . $employeeId
                                ];
                            }
                        }
                    }
                } else if ($debug) {
                    $response['debug']['steps'][] = [
                        'stage' => 'matching',
                        'method' => 'SecuGen',
                        'status' => 'info',
                        'message' => 'No match found using SecuGen matching'
                    ];
                }

                // Clean up
                @unlink($tempFile);
            }

            // Try with proprietary template if available and no match found yet
            if (!$matchFound && !empty($request->input('TemplateBase64'))) {
                // Add proprietary template matching implementation here if needed
                // This would use another approach for matching
            }

            // Clean up the samples directory
            $this->fingerprintService->cleanup($samplesDir);

            // Prepare response based on match result
            if ($matchFound && $matchedEmployee) {
                // Format employee data for response
                $employeeData = [
                    'id' => $matchedEmployee->id,
                    'name' => $matchedEmployee->name,
                    'last_name' => $matchedEmployee->last_name,
                    'email' => $matchedEmployee->email,
                    'phone' => $matchedEmployee->phone,
                    'department' => $matchedEmployee->department ? $matchedEmployee->department->name : 'N/A',
                    'position' => $matchedEmployee->position,
                    'photo' => $matchedEmployee->photo ? asset('storage/' . $matchedEmployee->photo) : null
                ];

                $response['success'] = true;
                $response['match'] = true;
                $response['method'] = $matchMethod;
                $response['message'] = 'Fingerprint match found';
                $response['employee'] = $employeeData;

                if ($debug) {
                    $response['debug']['steps'][] = [
                        'stage' => 'result',
                        'status' => 'success',
                        'message' => 'Match found using ' . $matchMethod . ' method',
                        'employee_id' => $matchedEmployee->id
                    ];
                }
            } else {
                $response['success'] = true;
                $response['match'] = false;
                $response['message'] = 'No fingerprint match found';

                if ($debug) {
                    $response['debug']['steps'][] = [
                        'stage' => 'result',
                        'status' => 'info',
                        'message' => 'No match found with any method'
                    ];
                }
            }

            return response()->json($response);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Fingerprint matching error: ' . $e->getMessage());

            $response['success'] = false;
            $response['match'] = false;
            $response['message'] = 'Error during fingerprint matching: ' . $e->getMessage();

            if ($debug) {
                $response['debug']['steps'][] = [
                    'stage' => 'error',
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ];
            }

            return response()->json($response);
        }
    }

    /**
     * Clean up temporary files and directory.
     *
     * @param string $directory The directory to clean up
     * @return void
     */
    private function cleanupTemporaryFiles($directory)
    {
        if (is_dir($directory)) {
            $files = glob($directory . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
            @rmdir($directory);
        }
    }

    /**
     * Match fingerprints using the provided match.py script from the SecuGen library
     *
     * @param string $fingerprintToMatch Path to the fingerprint file to match
     * @param array $bioDataRecords Collection of BioData records
     * @param boolean $debug Whether to enable debug mode
     * @return array [matchFound, matchedEmployee, matchMethod]
     */
    private function matchUsingSecuGenLib($fingerprintToMatch, $bioDataRecords, $debug = false)
    {
        // Create a temporary directory for samples
        $samplesDir = storage_path('app/fingerprints/temp/' . uniqid());
        if (!file_exists($samplesDir)) {
            mkdir($samplesDir, 0755, true);
        }

        // Save each employee fingerprint to the samples directory
        foreach ($bioDataRecords as $bioData) {
            $filename = "employee_{$bioData->personal_info_id}.dat";
            $templatePath = $samplesDir . '/' . $filename;

            // Skip invalid templates
            if (empty($bioData->ISOTemplateBase64)) {
                \Illuminate\Support\Facades\Log::warning("Empty ISO template for employee ID: " . $bioData->personal_info_id);
                continue;
            }

            $decodedTemplate = base64_decode($bioData->ISOTemplateBase64);

            // Validate the decoded template
            if (strlen($decodedTemplate) < 30) {
                \Illuminate\Support\Facades\Log::warning("Invalid template for employee ID: " . $bioData->personal_info_id . " (length: " . strlen($decodedTemplate) . ")");
                continue;
            }

            file_put_contents($templatePath, $decodedTemplate);

            if ($debug) {
                \Illuminate\Support\Facades\Log::debug("Saved template for employee ID: " . $bioData->personal_info_id . " to " . $filename . ", size: " . strlen($decodedTemplate) . " bytes");
            }
        }

        try {
            // Get the match.py script from our local package
            $matchScript = __DIR__ . '/../../fingerprint-matching-master/match.py';

            if (!file_exists($matchScript)) {
                throw new \Exception("SecuGen matching script not found at: " . $matchScript);
            }

            // Check if Python is available
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                throw new \Exception("Python interpreter not found");
            }

            // Create command using the SecuGen matching script
            $command = $pythonCommand . " " . escapeshellarg($matchScript) .
                      " --samples=" . escapeshellarg($samplesDir) .
                      " --fingerprint=" . escapeshellarg($fingerprintToMatch) .
                      " 2>&1";

            if ($debug) {
                \Illuminate\Support\Facades\Log::debug("Running SecuGen matching command: " . $command);
            }

            // Execute the command
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($debug) {
                \Illuminate\Support\Facades\Log::debug("Command output: " . implode("\n", $output) . ", Return code: " . $returnCode);
            }

            // Check if there's a match (should be the filename in the output)
            if (!empty($output)) {
                $matchResult = trim($output[0]);

                // Extract the employee ID from the filename
                preg_match('/employee_(\d+)\.dat/', $matchResult, $matches);

                if (isset($matches[1])) {
                    $employeeId = $matches[1];

                    // Find the employee in our collection
                    foreach ($bioDataRecords as $bioData) {
                        if ($bioData->personal_info_id == $employeeId) {
                            $this->cleanupTemporaryFiles($samplesDir);
                            return [true, $bioData->cardInfo, 'secugen_lib'];
                        }
                    }
                }
            }

            // No match found with SecuGen library, fall back to direct matching
            if ($debug) {
                \Illuminate\Support\Facades\Log::debug("No match found with SecuGen library, trying direct matching");
            }

            // Use our fallback direct matching script
            $directMatchScript = app_path('Services/Fingerprint/direct_match.py');

            if (file_exists($directMatchScript)) {
                // Create a command to run the direct matching script
                $command = $pythonCommand . " " . escapeshellarg($directMatchScript) .
                          " --samples=" . escapeshellarg($samplesDir) .
                          " --fingerprint=" . escapeshellarg($fingerprintToMatch) .
                          " --threshold=20" .  // Lower threshold to increase matches
                          " 2>&1";

                if ($debug) {
                    \Illuminate\Support\Facades\Log::debug("Running direct matching command: " . $command);
                }

                // Execute the command
                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);

                if ($debug) {
                    \Illuminate\Support\Facades\Log::debug("Direct matching output: " . implode("\n", $output) . ", Return code: " . $returnCode);
                }

                // Check if there's a match from direct matching
                if (!empty($output)) {
                    $matchResult = trim($output[0]);

                    // Extract the employee ID from the filename
                    preg_match('/employee_(\d+)\.dat/', $matchResult, $matches);

                    if (isset($matches[1])) {
                        $employeeId = $matches[1];

                        // Find the employee in our collection
                        foreach ($bioDataRecords as $bioData) {
                            if ($bioData->personal_info_id == $employeeId) {
                                $this->cleanupTemporaryFiles($samplesDir);
                                return [true, $bioData->cardInfo, 'direct_match'];
                            }
                        }
                    }
                }
            }

            // No match found with any method
            $this->cleanupTemporaryFiles($samplesDir);
            return [false, null, null];

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error using matching library: " . $e->getMessage());
            $this->cleanupTemporaryFiles($samplesDir);
            return [false, null, null];
        }
    }

    /**
     * Get the appropriate Python command
     *
     * @return string|null The Python command to use, or null if Python is not available
     */
    private function getPythonCommand()
    {
        // Try 'python' command
        $output = [];
        $returnCode = 0;
        exec('python --version 2>&1', $output, $returnCode);

        if ($returnCode === 0) {
            return 'python';
        }

        // Try 'python3' command
        $output = [];
        $returnCode = 0;
        exec('python3 --version 2>&1', $output, $returnCode);

        if ($returnCode === 0) {
            return 'python3';
        }

        // Try 'py' command (Windows)
        $output = [];
        $returnCode = 0;
        exec('py --version 2>&1', $output, $returnCode);

        if ($returnCode === 0) {
            return 'py';
        }

        return null;
    }
}
