<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('build/assets/app.css') }}" rel="stylesheet" />
    @vite(['resources/js/app.js'])
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Biometric Card Identification') }}</div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="mb-3">{{ __('Place your finger on the scanner to identify card information') }}</h5>
                        <button id="captureBtn" class="btn btn-primary">
                            {{ __('Capture Fingerprint') }}
                        </button>
                    </div>

                    <div id="statusMessage" class="alert alert-info text-center" role="alert">
                        {{ __('Ready to scan') }}
                    </div>

                    <div id="fingerprintImageContainer" class="text-center mb-4">
                        <img id="FPImage1" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=" alt="Fingerprint Image" class="img-fluid" style="height: 300px; width: 210px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>

                    <div id="loadingSpinner" class="text-center mb-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                        <p class="mt-2">{{ __('Processing...') }}</p>
                    </div>

                    <div id="matchResult" class="mt-4" style="display: none;">
                        <div class="card">
                            <div class="card-header">{{ __('Card Information') }}</div>
                            <div class="card-body">
                                <div id="cardDetails" class="row">
                                    <!-- Card details will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="result" class="mt-4"></div>

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

    
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    // nice global area, so that only 1 location, contains this information
    var secugen_lic = "";

    document.addEventListener('DOMContentLoaded', function() {
        const captureBtn = document.getElementById('captureBtn');
        const statusMessage = document.getElementById('statusMessage');
        const fingerprintImageContainer = document.getElementById('fingerprintImageContainer');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const matchResult = document.getElementById('matchResult');
        const cardDetails = document.getElementById('cardDetails');
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

        // SecuGen fingerprint handling functions
        function captureFP() {
            CallSGIFPGetData(SuccessFunc, ErrorFunc);
        }

        /*
        This functions is called if the service sucessfully returns some data in JSON object
        */
        function SuccessFunc(result) {
            if (result.ErrorCode == 0) {
                /* Display BMP data in image tag
                   BMP data is in base 64 format
                */
                if (result != null && result.BMPBase64.length > 0) {
                    document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.BMPBase64;
                }
                
                var tbl = "<table class='table table-bordered'>";
                tbl += "<tr>";
                tbl += "<td> Serial Number of device </td>";
                tbl += "<td> <b>" + result.SerialNumber + "</b> </td>";
                tbl += "</tr>";
                tbl += "<tr>";
                tbl += "<td> Image Height</td>";
                tbl += "<td> <b>" + result.ImageHeight + "</b> </td>";
                tbl += "</tr>";
                tbl += "<tr>";
                tbl += "<td> Image Width</td>";
                tbl += "<td> <b>" + result.ImageWidth + "</b> </td>";
                tbl += "</tr>";
                tbl += "<tr>";
                tbl += "<td> Image Resolution</td>";
                tbl += "<td> <b>" + result.ImageDPI + "</b> </td>";
                tbl += "</tr>";
                tbl += "<tr>";
                tbl += "<td> Image Quality (1-100)</td>";
                tbl += "<td> <b>" + result.ImageQuality + "</b> </td>";
                tbl += "</tr>";
                tbl += "<tr>";
                tbl += "<td> NFIQ (1-5)</td>";
                tbl += "<td> <b>" + result.NFIQ + "</b> </td>";
                tbl += "</tr>";
                tbl += "</table>";
                
                document.getElementById('result').innerHTML = tbl;
                logDebug('Fingerprint captured successfully with quality: ' + result.ImageQuality);
                
                // Now use the template to match
                matchFingerprint(result);
            }
            else {
                logDebug("Fingerprint Capture Error Code: " + result.ErrorCode);
                alert("Fingerprint Capture Error Code:  " + result.ErrorCode + ".\nDescription:  " + ErrorCodeToString(result.ErrorCode) + ".");
                resetUI();
            }
        }

        function ErrorFunc(status) {
            /*
                If you reach here, user is probabaly not running the
                service. Redirect the user to a page where he can download the
                executable and install it.
            */
            logDebug("Check if SGIBIOSRV is running; Status = " + status);
            alert("Check if SGIBIOSRV is running; Status = " + status + ":");
            resetUI();
        }

        function CallSGIFPGetData(successCall, failCall) {
            // 8.16.2017 - At this time, only SSL client will be supported.
            var uri = "https://localhost:8443/SGIFPCapture";

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    fpobject = JSON.parse(xmlhttp.responseText);
                    successCall(fpobject);
                }
                else if (xmlhttp.status == 404) {
                    failCall(xmlhttp.status)
                }
            }
            
            // Update status
            statusMessage.textContent = 'Capturing fingerprint...';
            statusMessage.className = 'alert alert-primary text-center';
            
            // Disable button during capture
            captureBtn.disabled = true;
            
            var params = "Timeout=" + "10000";
            params += "&Quality=" + "50";
            params += "&licstr=" + encodeURIComponent(secugen_lic);
            params += "&templateFormat=" + "ISO";
            params += "&imageWSQRate=" + "0.75";

            xmlhttp.open("POST", uri, true);
            xmlhttp.send(params);

            xmlhttp.onerror = function () {
                failCall(xmlhttp.statusText);
            }
        }

        function ErrorCodeToString(ErrorCode) {
            var Description;
            switch (ErrorCode) {
                // 0 - 999 - Comes from SgFplib.h
                // 1,000 - 9,999 - SGIBioSrv errors
                // 10,000 - 99,999 license errors
                case 51:
                    Description = "System file load failure";
                    break;
                case 52:
                    Description = "Sensor chip initialization failed";
                    break;
                case 53:
                    Description = "Device not found";
                    break;
                case 54:
                    Description = "Fingerprint image capture timeout";
                    break;
                case 55:
                    Description = "No device available";
                    break;
                case 56:
                    Description = "Driver load failed";
                    break;
                case 57:
                    Description = "Wrong Image";
                    break;
                case 58:
                    Description = "Lack of bandwidth";
                    break;
                case 59:
                    Description = "Device Busy";
                    break;
                case 60:
                    Description = "Cannot get serial number of the device";
                    break;
                case 61:
                    Description = "Unsupported device";
                    break;
                case 63:
                    Description = "SgiBioSrv didn't start; Try image capture again";
                    break;
                default:
                    Description = "Unknown error code or Update code to reflect latest result";
                    break;
            }
            return Description;
        }

        // Match fingerprint against database
        function matchFingerprint(templateData) {
            logDebug('Sending template for matching');

            // Show loading state
            loadingSpinner.style.display = 'block';
            
            // Make API call to match endpoint
            fetch('{{ route("fingerprint.cardinfo.match") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(templateData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Match request failed with status ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';
                
                if (data.success) {
                    displayCardInfo(data.data);
                    logDebug('Match found: ' + JSON.stringify(data.data.id));
                } else {
                    throw new Error(data.message || 'No match found');
                }
            })
            .catch(error => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';
                
                // Show error message
                statusMessage.textContent = error.message || 'Error matching fingerprint';
                statusMessage.className = 'alert alert-danger text-center';
                
                logDebug('Match error: ' + error.message);
                
                // Enable capture button
                captureBtn.disabled = false;
            });
        }

        // Display card information
        function displayCardInfo(cardInfo) {
            // Clear previous results
            cardDetails.innerHTML = '';
            
            // Create card information display
            const cardInfoHTML = `
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Name:</strong> ${cardInfo.name || 'N/A'}
                    </div>
                    <div class="mb-3">
                        <strong>ID:</strong> ${cardInfo.id || 'N/A'}
                    </div>
                    <div class="mb-3">
                        <strong>Department:</strong> ${cardInfo.department?.name || 'N/A'}
                    </div>
                    <div class="mb-3">
                        <strong>Gate:</strong> ${cardInfo.gate?.name || 'N/A'}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Card Number:</strong> ${cardInfo.card_number || 'N/A'}
                    </div>
                    <div class="mb-3">
                        <strong>Employee ID:</strong> ${cardInfo.employee_id || 'N/A'}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> <span class="badge ${cardInfo.confirmed ? 'bg-success' : 'bg-warning'}">${cardInfo.confirmed ? 'Confirmed' : 'Pending'}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Created At:</strong> ${new Date(cardInfo.created_at).toLocaleString() || 'N/A'}
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="/sq/modules/employee/card-info/${cardInfo.id}" class="btn btn-primary" target="_blank">View Full Details</a>
                    </div>
                </div>
            `;
            
            cardDetails.innerHTML = cardInfoHTML;
            
            // Show match result
            matchResult.style.display = 'block';
            
            // Update status
            statusMessage.textContent = 'Card information found!';
            statusMessage.className = 'alert alert-success text-center';
            
            // Enable capture button
            captureBtn.disabled = false;
        }
    });
</script>
</body>
