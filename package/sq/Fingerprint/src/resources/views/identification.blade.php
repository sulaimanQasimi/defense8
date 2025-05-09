@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Fingerprint Identification') }}</div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="mb-3">{{ __('Place your finger on the scanner') }}</h5>
                        <button id="captureBtn" class="btn btn-primary">
                            {{ __('Capture Fingerprint') }}
                        </button>
                    </div>

                    <div id="statusMessage" class="alert alert-info text-center" role="alert">
                        {{ __('Ready to scan') }}
                    </div>

                    <div id="fingerprintImageContainer" class="text-center mb-4" style="display: none;">
                        <img id="fingerprintImage" src="" alt="Fingerprint Image" class="img-fluid" style="max-width: 300px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div id="loadingSpinner" class="text-center mb-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                        <p class="mt-2">{{ __('Processing...') }}</p>
                    </div>

                    <div id="matchResult" class="mt-4" style="display: none;">
                        <div class="card">
                            <div class="card-header">{{ __('Match Result') }}</div>
                            <div class="card-body">
                                <div id="matchDetails"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 form-check">
                        <input type="checkbox" class="form-check-input" id="debugMode">
                        <label class="form-check-label" for="debugMode">{{ __('Debug Mode') }}</label>
                    </div>

                    <div id="debugOutput" class="mt-3 p-2" style="display: none; background-color: #f8f9fa; border-radius: 5px; border: 1px solid #ddd; height: 200px; overflow-y: auto; text-align: left; font-family: monospace; font-size: 12px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const captureBtn = document.getElementById('captureBtn');
        const statusMessage = document.getElementById('statusMessage');
        const fingerprintImageContainer = document.getElementById('fingerprintImageContainer');
        const fingerprintImage = document.getElementById('fingerprintImage');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const matchResult = document.getElementById('matchResult');
        const matchDetails = document.getElementById('matchDetails');
        const debugMode = document.getElementById('debugMode');
        const debugOutput = document.getElementById('debugOutput');

        // Check if debug mode is enabled in localStorage
        if (localStorage.getItem('fingerprintDebugMode') === 'true') {
            debugMode.checked = true;
            debugOutput.style.display = 'block';
        }

        // Toggle debug mode
        debugMode.addEventListener('change', function() {
            debugOutput.style.display = this.checked ? 'block' : 'none';
            localStorage.setItem('fingerprintDebugMode', this.checked);

            if (this.checked) {
                logDebug('Debug mode enabled');
            }
        });

        // Log debug message
        function logDebug(message) {
            if (debugMode.checked) {
                const timestamp = new Date().toLocaleTimeString();
                const logEntry = document.createElement('div');
                logEntry.textContent = `[${timestamp}] ${message}`;
                debugOutput.appendChild(logEntry);
                debugOutput.scrollTop = debugOutput.scrollHeight;
            }
        }

        // Reset UI to initial state
        function resetUI() {
            statusMessage.textContent = 'Ready to scan';
            statusMessage.className = 'alert alert-info text-center';
            fingerprintImageContainer.style.display = 'none';
            loadingSpinner.style.display = 'none';
            matchResult.style.display = 'none';
            captureBtn.disabled = false;

            if (debugMode.checked) {
                logDebug('UI reset to initial state');
            }
        }

        // Handle fingerprint capture
        captureBtn.addEventListener('click', function() {
            captureFP();
        });

        // Capture fingerprint
        function captureFP() {
            if (debugMode.checked) {
                logDebug('Starting fingerprint capture');
            }

            // Reset UI
            resetUI();

            // Update status
            statusMessage.textContent = 'Place your finger on the scanner...';
            statusMessage.className = 'alert alert-primary text-center';

            // Disable button during capture
            captureBtn.disabled = true;

            // Check if we're in a secure context (needed for biometric devices)
            if (!window.isSecureContext) {
                statusMessage.textContent = 'Error: Secure context required. Please use HTTPS.';
                statusMessage.className = 'alert alert-danger text-center';
                captureBtn.disabled = false;
                logDebug('Error: Not in a secure context');
                return;
            }

            try {
                // This would be replaced with your actual fingerprint SDK integration
                // For demonstration, we'll simulate a fingerprint capture
                setTimeout(function() {
                    // Simulate successful capture
                    if (Math.random() > 0.1) { // 90% success rate for demo
                        onCaptureSuccess();
                    } else {
                        // Simulate capture error
                        onCaptureError('Failed to capture fingerprint. Please try again.');
                    }
                }, 2000);

                logDebug('Simulating fingerprint capture (replace with actual SDK call)');
            } catch (error) {
                onCaptureError('Error: ' + error.message);
                logDebug('Capture error: ' + error.message);
            }
        }

        // Handle successful capture
        function onCaptureSuccess() {
            // Update status
            statusMessage.textContent = 'Fingerprint captured successfully!';
            statusMessage.className = 'alert alert-success text-center';

            // Show a sample fingerprint image (replace with actual image)
            fingerprintImage.src = '/vendor/sqfingerprint/img/sample-fingerprint.png';
            fingerprintImageContainer.style.display = 'block';

            logDebug('Fingerprint captured successfully');

            // Show loading spinner
            loadingSpinner.style.display = 'block';

            // Simulate template creation (replace with actual SDK call)
            setTimeout(function() {
                // Create a mock result object (replace with actual SDK result)
                const mockResult = {
                    ImageWidth: 500,
                    ImageHeight: 500,
                    ImageDPI: 500,
                    ImageQuality: 85,
                    NFIQ: 2,
                    BMPBase64: 'mock-image-data', // Mock data
                    ISOTemplateBase64: 'mock-iso-template-data', // Mock data
                    TemplateBase64: 'mock-template-data' // Mock data
                };

                logDebug('Template created with quality: ' + mockResult.ImageQuality);

                // Send for matching
                matchFingerprint(mockResult);
            }, 1500);
        }

        // Handle capture error
        function onCaptureError(errorMessage) {
            statusMessage.textContent = errorMessage;
            statusMessage.className = 'alert alert-danger text-center';
            captureBtn.disabled = false;
            logDebug('Capture error: ' + errorMessage);
        }

        // Match fingerprint
        function matchFingerprint(fpResult) {
            logDebug('Sending template for matching');

            // Prepare payload for sending to server
            const payload = {
                ISOTemplateBase64: fpResult.ISOTemplateBase64,
                TemplateBase64: fpResult.TemplateBase64,
                BMPBase64: fpResult.BMPBase64,
                debug: debugMode.checked,
                _meta: {
                    imageWidth: fpResult.ImageWidth,
                    imageHeight: fpResult.ImageHeight,
                    imageDPI: fpResult.ImageDPI,
                    imageQuality: fpResult.ImageQuality,
                    nfiq: fpResult.NFIQ,
                    hasISOTemplate: !!fpResult.ISOTemplateBase64,
                    hasTemplate: !!fpResult.TemplateBase64,
                    hasBMP: !!fpResult.BMPBase64
                }
            };

            // Call the match endpoint
            fetch('/fingerprint/match', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';

                // Display match result
                matchResult.style.display = 'block';

                if (data.debug) {
                    // Log all debug information
                    logDebug('Server response received');
                    data.debug.steps.forEach(step => {
                        logDebug(`[${step.stage}] ${step.message}`);
                    });
                }

                if (data.match) {
                    // Match found
                    statusMessage.textContent = 'Match found!';
                    statusMessage.className = 'alert alert-success text-center';

                    // Build match details HTML
                    let detailsHTML = '<div class="alert alert-success">Match found!</div>';
                    detailsHTML += '<table class="table table-striped">';

                    if (data.data) {
                        // Add all available data to the table
                        const userData = data.data;
                        for (const key in userData) {
                            // Skip large binary data fields
                            if (['ISOTemplateBase64', 'TemplateBase64', 'ImageDataBase64', 'BMPBase64'].includes(key)) {
                                continue;
                            }

                            detailsHTML += `<tr>
                                <th>${key}</th>
                                <td>${userData[key]}</td>
                            </tr>`;
                        }
                    }

                    detailsHTML += `<tr>
                        <th>Match Method</th>
                        <td>${data.method || 'Standard'}</td>
                    </tr>`;

                    detailsHTML += '</table>';
                    matchDetails.innerHTML = detailsHTML;

                    logDebug('Match found! Method: ' + (data.method || 'Standard'));
                } else {
                    // No match found
                    statusMessage.textContent = 'No match found.';
                    statusMessage.className = 'alert alert-warning text-center';

                    matchDetails.innerHTML = '<div class="alert alert-warning">No matching record found in the database.</div>';
                    logDebug('No match found');
                }

                // Re-enable capture button
                captureBtn.disabled = false;
            })
            .catch(error => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';

                // Show error message
                statusMessage.textContent = 'Error: ' + error.message;
                statusMessage.className = 'alert alert-danger text-center';

                // Re-enable capture button
                captureBtn.disabled = false;

                logDebug('Match error: ' + error.message);
            });
        }
    });
</script>
@endpush
