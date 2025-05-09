@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Fingerprint Identification') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="text-center">
                                <h4>{{ __('Place your finger on the scanner to identify yourself') }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="fingerprint-scanner mb-3">
                                <div id="fingerprintImage" class="fingerprint-image">
                                    <div class="fingerprint-placeholder">
                                        <i class="fas fa-fingerprint fa-5x text-muted"></i>
                                    </div>
                                </div>
                                <div class="scanner-animation" id="scannerAnimation">
                                    <div class="scanner-line"></div>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <button id="captureBtn" class="btn btn-primary">
                                    {{ __('Capture Fingerprint') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="resultPanel" class="d-none">
                                <div class="card">
                                    <div class="card-header bg-success text-white d-none" id="successHeader">
                                        {{ __('Match Found') }}
                                    </div>
                                    <div class="card-header bg-danger text-white d-none" id="failureHeader">
                                        {{ __('No Match Found') }}
                                    </div>
                                    <div class="card-body">
                                        <div id="matchDetails">
                                            <h5 class="mb-3" id="identifierDisplay"></h5>
                                            <div class="match-info">
                                                <div class="row">
                                                    <div class="col-md-6">{{ __('Score') }}:</div>
                                                    <div class="col-md-6 font-weight-bold" id="scoreDisplay"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">{{ __('Method') }}:</div>
                                                    <div class="col-md-6" id="methodDisplay"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="noMatchMessage" class="d-none">
                                            <p class="text-center">{{ __('Your fingerprint did not match any records in our system.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="debugMode">
                                <label class="form-check-label" for="debugMode">
                                    {{ __('Debug Mode') }}
                                </label>
                            </div>
                            <div id="debugOutput" class="mt-2 d-none">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Debug Information') }}
                                    </div>
                                    <div class="card-body">
                                        <pre id="debugLog" class="debug-log"></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fingerprint-scanner {
        position: relative;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f5f5f5;
    }
    
    .fingerprint-image {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .fingerprint-placeholder {
        color: #aaa;
        text-align: center;
    }
    
    .scanner-animation {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
    }
    
    .scanner-animation.active {
        display: block;
    }
    
    .scanner-line {
        position: absolute;
        height: 2px;
        left: 0;
        right: 0;
        background: linear-gradient(to right, rgba(0,123,255,0), rgba(0,123,255,1), rgba(0,123,255,0));
        animation: scan 2s ease-in-out infinite;
    }
    
    @keyframes scan {
        0% {
            top: 0;
        }
        50% {
            top: 100%;
        }
        100% {
            top: 0;
        }
    }
    
    .match-info {
        margin-top: 1rem;
    }
    
    .match-info .row {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .debug-log {
        font-family: monospace;
        font-size: 12px;
        background-color: #f8f9fa;
        padding: 10px;
        max-height: 200px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const captureBtn = document.getElementById('captureBtn');
        const fingerprintImage = document.getElementById('fingerprintImage');
        const scannerAnimation = document.getElementById('scannerAnimation');
        const resultPanel = document.getElementById('resultPanel');
        const successHeader = document.getElementById('successHeader');
        const failureHeader = document.getElementById('failureHeader');
        const identifierDisplay = document.getElementById('identifierDisplay');
        const scoreDisplay = document.getElementById('scoreDisplay');
        const methodDisplay = document.getElementById('methodDisplay');
        const matchDetails = document.getElementById('matchDetails');
        const noMatchMessage = document.getElementById('noMatchMessage');
        const debugMode = document.getElementById('debugMode');
        const debugOutput = document.getElementById('debugOutput');
        const debugLog = document.getElementById('debugLog');
        
        let isCapturing = false;
        
        // Toggle debug output when checkbox is changed
        debugMode.addEventListener('change', function() {
            debugOutput.classList.toggle('d-none', !this.checked);
        });
        
        // Log debug message
        function logDebug(message) {
            if (debugMode.checked) {
                const timestamp = new Date().toLocaleTimeString();
                const logMessage = `[${timestamp}] ${message}`;
                debugLog.innerHTML += logMessage + '\n';
                debugLog.scrollTop = debugLog.scrollHeight;
            }
        }
        
        // Reset the UI
        function resetUI() {
            resultPanel.classList.add('d-none');
            successHeader.classList.add('d-none');
            failureHeader.classList.add('d-none');
            matchDetails.classList.add('d-none');
            noMatchMessage.classList.add('d-none');
            fingerprintImage.innerHTML = `
                <div class="fingerprint-placeholder">
                    <i class="fas fa-fingerprint fa-5x text-muted"></i>
                </div>
            `;
        }
        
        // Show the scanner animation
        function showScannerAnimation() {
            scannerAnimation.classList.add('active');
            logDebug('Scanner animation started');
        }
        
        // Hide the scanner animation
        function hideScannerAnimation() {
            scannerAnimation.classList.remove('active');
            logDebug('Scanner animation stopped');
        }
        
        // Simulate fingerprint capture (in a real app, this would use a scanner SDK)
        function captureFingerprint() {
            return new Promise((resolve, reject) => {
                logDebug('Starting fingerprint capture');
                
                // This is where you would normally interface with a fingerprint SDK
                // For demo purposes, we'll simulate a capture after a delay
                setTimeout(() => {
                    // Simulate random success/failure (90% success rate)
                    const success = Math.random() < 0.9;
                    
                    if (success) {
                        // Simulated fingerprint data
                        const fingerprintData = {
                            BMPBase64: 'simulated_image_data',
                            ISOTemplateBase64: 'simulated_iso_template_data',
                            TemplateBase64: 'simulated_template_data',
                            ImageWidth: 500,
                            ImageHeight: 500,
                            ImageDPI: 500,
                            _meta: {
                                captureDevice: 'SimulatedScanner',
                                timestamp: new Date().toISOString()
                            }
                        };
                        
                        logDebug('Fingerprint captured successfully');
                        resolve(fingerprintData);
                    } else {
                        logDebug('Failed to capture fingerprint');
                        reject(new Error('Failed to capture fingerprint'));
                    }
                }, 2000);
            });
        }
        
        // Send fingerprint data to server for matching
        function matchFingerprint(fingerprintData) {
            logDebug('Sending fingerprint data to server for matching');
            
            // Add debug flag if debug mode is enabled
            const requestData = {
                ...fingerprintData,
                debug: debugMode.checked
            };
            
            return fetch('{{ route("fingerprint.match") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                logDebug(`Matching result: ${JSON.stringify(data)}`);
                return data;
            });
        }
        
        // Display the match result
        function displayResult(result) {
            resultPanel.classList.remove('d-none');
            
            if (result.found) {
                successHeader.classList.remove('d-none');
                matchDetails.classList.remove('d-none');
                
                identifierDisplay.textContent = `Identifier: ${result.identifier}`;
                scoreDisplay.textContent = result.score;
                methodDisplay.textContent = result.method;
                
                logDebug(`Match found: ${result.identifier}, score: ${result.score}, method: ${result.method}`);
            } else {
                failureHeader.classList.remove('d-none');
                noMatchMessage.classList.remove('d-none');
                
                logDebug('No match found');
            }
            
            // If debug data is available, display it
            if (result.debug) {
                logDebug(`Debug data: ${JSON.stringify(result.debug)}`);
            }
        }
        
        // Handle capture button click
        captureBtn.addEventListener('click', function() {
            if (isCapturing) return;
            
            isCapturing = true;
            resetUI();
            captureBtn.disabled = true;
            captureBtn.textContent = '{{ __("Scanning...") }}';
            
            showScannerAnimation();
            
            captureFingerprint()
                .then(fingerprintData => {
                    // Display the captured fingerprint image
                    fingerprintImage.innerHTML = `
                        <img src="data:image/png;base64,${fingerprintData.BMPBase64}" 
                             alt="Fingerprint" class="img-fluid" />
                    `;
                    
                    return matchFingerprint(fingerprintData);
                })
                .then(result => {
                    displayResult(result);
                })
                .catch(error => {
                    logDebug(`Error: ${error.message}`);
                    alert(`Error: ${error.message}`);
                })
                .finally(() => {
                    hideScannerAnimation();
                    captureBtn.disabled = false;
                    captureBtn.textContent = '{{ __("Capture Fingerprint") }}';
                    isCapturing = false;
                });
        });
        
        // Initialize
        resetUI();
        logDebug('Fingerprint identification page loaded');
    });
</script>
@endpush 