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
            'debug' => 'boolean|nullable',
            'security_level' => 'integer|min:1|max:4|nullable'
        ]);

        // Debug mode flag
        $debug = $request->input('debug', false);
        $securityLevel = $request->input('security_level', 2); // Default to normal security

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
                    'securityLevel' => $securityLevel
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

            // Create a temporary file for the submitted fingerprint template
            $fingerprintBase64 = null;
            if (!empty($request->input('ISOTemplateBase64'))) {
                $fingerprintBase64 = $request->input('ISOTemplateBase64');
            } elseif (!empty($request->input('TemplateBase64'))) {
                $fingerprintBase64 = $request->input('TemplateBase64');
            } elseif (!empty($request->input('BMPBase64'))) {
                $fingerprintBase64 = $request->input('BMPBase64');
            }

            $fingerprintFile = tempnam(sys_get_temp_dir(), 'fp_search_');
            file_put_contents($fingerprintFile, base64_decode($fingerprintBase64));

            if ($debug) {
                $response['debug']['steps'][] = [
                    'stage' => 'preparation',
                    'status' => 'info',
                    'message' => 'Saved fingerprint template to: ' . $fingerprintFile
                ];
            }

            // Use the FingerprintService to create samples directory
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

            // Use the FingerprintService to match the fingerprint
            $matchedFilename = $this->fingerprintService->match($fingerprintFile, $samplesDir, $securityLevel);

            if ($debug) {
                $response['debug']['steps'][] = [
                    'stage' => 'matching',
                    'status' => 'info',
                    'message' => 'Match result: ' . ($matchedFilename ? $matchedFilename : 'No match')
                ];
            }

            // Extract the employee ID from the matched filename
            if ($matchedFilename) {
                // Extract employee ID from the filename (format: employee_ID.dat)
                preg_match('/employee_(\d+)\.dat/', $matchedFilename, $matches);

                if (isset($matches[1])) {
                    $employeeId = $matches[1];

                    // Find the employee
                    $matchedEmployee = CardInfo::find($employeeId);
                    if ($matchedEmployee) {
                        $matchFound = true;
                        $matchMethod = 'fingerprint_service';

                        if ($debug) {
                            $response['debug']['steps'][] = [
                                'stage' => 'matching',
                                'status' => 'success',
                                'message' => "Match found for employee ID: " . $employeeId
                            ];
                        }
                    }
                }
            }

            // Clean up temporary files
            @unlink($fingerprintFile);
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
