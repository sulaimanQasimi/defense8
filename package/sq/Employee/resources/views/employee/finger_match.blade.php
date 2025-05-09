<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Fingerprint Identification</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('build/assets/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    @vite(['resources/js/app.js'])
    <style>
        .employee-card {
            display: none;
            transition: all 0.3s ease;
        }
        .employee-photo {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #3490dc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .employee-photo:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .fingerprint-area {
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .pulse {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(52, 144, 220, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(52, 144, 220, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(52, 144, 220, 0);
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Improve card appearance */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
        }

        /* Styles for the identification result */
        .employee-details {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        /* Loading spinner for processing */
        .spinner-border {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Employee Fingerprint Identification</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">Scan Fingerprint</div>
                                    <div class="card-body fingerprint-area">
                                        <img id="FPImage1" alt="Fingerprint Image" height=300 width=210
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=">
                                        <div id="scanStatus" class="mt-3 text-center">
                                            <p>Please place your finger on the scanner</p>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-3 pulse" id="scanButton" onclick="captureFP()">
                                            <i class="fas fa-fingerprint mr-2"></i> Scan Fingerprint
                                        </button>

                                        <!-- Progress bar for scanning and matching -->
                                        <div id="searchProgress" class="mt-3 w-100" style="display: none;">
                                            <div class="progress">
                                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 0%"></div>
                                            </div>
                                            <p id="progressText" class="text-center mt-2">Initializing scan...</p>
                                        </div>

                                        <!-- Debug Mode -->
                                        <div class="mt-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="debugMode">
                                            <label class="form-check-label" for="debugMode">Debug Mode</label>
                                        </div>

                                        <!-- Debug Output -->
                                        <div id="debugOutput" class="mt-3 p-2" style="display: none; background-color: #f8f9fa; border-radius: 5px; border: 1px solid #ddd; height: 100px; overflow-y: auto; text-align: left; font-family: monospace; font-size: 12px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div id="matchResult" class="card h-100">
                                    <div class="card-header">Identification Result</div>
                                    <div class="card-body text-center">
                                        <div id="noMatch" class="mt-5">
                                            <p class="text-muted">Scan your fingerprint to identify</p>
                                            <i class="fas fa-search fa-4x text-muted mt-3"></i>
                                        </div>

                                        <div id="employeeCard" class="employee-card">
                                            <img id="employeePhoto" class="employee-photo mb-3" src="" alt="Employee Photo">
                                            <h4 id="employeeName" class="mb-2"></h4>
                                            <div class="employee-details">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="text-right"><strong>ID:</strong></td>
                                                        <td id="employeeId" class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>Department:</strong></td>
                                                        <td id="employeeDepartment" class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>Position:</strong></td>
                                                        <td id="employeePosition" class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>Email:</strong></td>
                                                        <td id="employeeEmail" class="text-left"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>Phone:</strong></td>
                                                        <td id="employeePhone" class="text-left"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="notFound" class="mt-5" style="display:none;">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                                <p>No matching fingerprint found in the database</p>
                                            </div>
                                        </div>

                                        <div id="errorMessage" class="mt-5" style="display:none;">
                                            <div class="alert alert-danger">
                                                <i class="fas fa-times-circle fa-2x mb-3"></i>
                                                <p id="errorText"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('sqemployee.employee.finger.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // License key (if required)
        var secugen_lic = "";

        // Set CSRF token for all AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function captureFP() {
            // Reset UI
            resetUI();

            // Show progress
            document.getElementById('searchProgress').style.display = 'block';
            document.getElementById('scanButton').disabled = true;
            document.getElementById('scanStatus').innerHTML = '<p class="text-primary">Scanning your fingerprint...</p>';
            updateProgress(10, 'Initializing scanner...');

            // Check if debug mode is enabled
            const debugMode = document.getElementById('debugMode').checked;
            if (debugMode) {
                document.getElementById('debugOutput').style.display = 'block';
                logDebug('Starting fingerprint capture...');
            }

            // Capture fingerprint
            CallSGIFPGetData(SuccessFunc, ErrorFunc);
        }

        function resetUI() {
            document.getElementById('noMatch').style.display = 'block';
            document.getElementById('employeeCard').style.display = 'none';
            document.getElementById('notFound').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('progressBar').style.width = '0%';
            document.getElementById('progressBar').setAttribute('aria-valuenow', 0);
            document.getElementById('debugOutput').innerHTML = '';
        }

        function updateProgress(percentage, message) {
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);
            progressText.textContent = message;

            // Change color based on progress
            if (percentage < 30) {
                progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-info';
            } else if (percentage < 70) {
                progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-primary';
            } else if (percentage < 100) {
                progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-warning';
            } else {
                progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-success';
            }
        }

        function logDebug(message) {
            const debugOutput = document.getElementById('debugOutput');
            if (debugOutput.style.display === 'block') {
                const timestamp = new Date().toLocaleTimeString();
                debugOutput.innerHTML += `<div>[${timestamp}] ${message}</div>`;
                debugOutput.scrollTop = debugOutput.scrollHeight;
            }
        }

        /*
            This function is called if the service successfully returns some data in JSON object
        */
        function SuccessFunc(result) {
            if (result.ErrorCode == 0) {
                /* Display BMP data in image tag
                   BMP data is in base 64 format
                */
                if (result != null && result.BMPBase64.length > 0) {
                    document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.BMPBase64;
                    logDebug(`BMP image captured: ${result.BMPBase64.substr(0, 20)}...`);
                }

                // Log templates for debugging
                const debugMode = document.getElementById('debugMode').checked;
                if (debugMode) {
                    logDebug(`Captured fingerprint data:`);
                    logDebug(`- Image size: ${result.ImageWidth}x${result.ImageHeight}`);
                    logDebug(`- Image DPI: ${result.ImageDPI}`);
                    logDebug(`- ISO Template: ${result.ISOTemplateBase64 ? 'Present' : 'Missing'}`);
                    logDebug(`- Template: ${result.TemplateBase64 ? 'Present' : 'Missing'}`);

                    if (result.ISOTemplateBase64) {
                        logDebug(`- ISO Template length: ${result.ISOTemplateBase64.length} bytes`);
                    }
                    if (result.TemplateBase64) {
                        logDebug(`- Template length: ${result.TemplateBase64.length} bytes`);
                    }
                }

                updateProgress(30, 'Fingerprint captured successfully. Searching database...');
                document.getElementById('scanStatus').innerHTML = '<p class="text-success">Fingerprint captured successfully. Searching...</p>';

                setTimeout(() => {
                    updateProgress(50, 'Analyzing fingerprint patterns...');
                    logDebug('Sending fingerprint data to server for matching...');

                    // Prepare request data
                    const requestData = {
                        ISOTemplateBase64: result.ISOTemplateBase64,
                        TemplateBase64: result.TemplateBase64,
                        BMPBase64: result.BMPBase64,
                        debug: debugMode,
                        _meta: {
                            imageWidth: result.ImageWidth,
                            imageHeight: result.ImageHeight,
                            imageDPI: result.ImageDPI,
                            hasISOTemplate: !!result.ISOTemplateBase64,
                            hasTemplate: !!result.TemplateBase64,
                            hasImage: !!result.BMPBase64,
                            dataLength: result.ISOTemplateBase64 ? result.ISOTemplateBase64.length : 0
                        }
                    };

                    // Send the data to the server for matching
                    fetch('{{ route("sqemployee.employee.finger.match") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => {
                        updateProgress(70, 'Processing results...');
                        logDebug(`Server response status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('noMatch').style.display = 'none';
                        logDebug(`Server response: ${JSON.stringify(data)}`);

                        if (data.success) {
                            if (data.match) {
                                // Match found, display employee data
                                updateProgress(100, 'Match found! Employee identified.');
                                logDebug(`Match found using method: ${data.method || 'unknown'}`);

                                document.getElementById('employeeCard').style.display = 'block';
                                document.getElementById('notFound').style.display = 'none';
                                document.getElementById('errorMessage').style.display = 'none';

                                const employee = data.employee;
                                document.getElementById('employeePhoto').src = employee.photo || 'https://via.placeholder.com/200x200?text=No+Photo';
                                document.getElementById('employeeName').textContent = `${employee.name} ${employee.last_name}`;
                                document.getElementById('employeeId').textContent = employee.id;
                                document.getElementById('employeeDepartment').textContent = employee.department;
                                document.getElementById('employeePosition').textContent = employee.position || 'N/A';
                                document.getElementById('employeeEmail').textContent = employee.email || 'N/A';
                                document.getElementById('employeePhone').textContent = employee.phone || 'N/A';

                                document.getElementById('scanStatus').innerHTML = '<p class="text-success">Match found! Employee identified.</p>';

                                // Add flashing animation to the employee card
                                const employeeCard = document.getElementById('employeeCard');
                                employeeCard.classList.add('fade-in');

                                // Apply animation to photo
                                const employeePhoto = document.getElementById('employeePhoto');
                                employeePhoto.classList.add('slide-in');

                            } else {
                                // No match found
                                updateProgress(100, 'No matching fingerprint found.');
                                logDebug('No match found in database');

                                document.getElementById('employeeCard').style.display = 'none';
                                document.getElementById('notFound').style.display = 'block';
                                document.getElementById('errorMessage').style.display = 'none';

                                document.getElementById('scanStatus').innerHTML = '<p class="text-warning">No matching fingerprint found. Try again?</p>';
                            }
                        } else {
                            // Error occurred
                            updateProgress(100, 'Error during identification.');
                            logDebug(`Error: ${data.message}`);

                            document.getElementById('employeeCard').style.display = 'none';
                            document.getElementById('notFound').style.display = 'none';
                            document.getElementById('errorMessage').style.display = 'block';
                            document.getElementById('errorText').textContent = data.message;

                            document.getElementById('scanStatus').innerHTML = '<p class="text-danger">Error during identification. Try again?</p>';
                        }

                        // Re-enable the scan button
                        document.getElementById('scanButton').disabled = false;
                    })
                    .catch(error => {
                        updateProgress(100, 'Error during identification.');
                        logDebug(`Network/parsing error: ${error.message}`);

                        document.getElementById('noMatch').style.display = 'none';
                        document.getElementById('employeeCard').style.display = 'none';
                        document.getElementById('notFound').style.display = 'none';
                        document.getElementById('errorMessage').style.display = 'block';
                        document.getElementById('errorText').textContent = 'An error occurred during the identification process: ' + error.message;

                        document.getElementById('scanStatus').innerHTML = '<p class="text-danger">Error during identification. Try again?</p>';

                        // Re-enable the scan button
                        document.getElementById('scanButton').disabled = false;
                    });
                }, 500); // Short delay for better UI feedback
            } else {
                updateProgress(100, 'Fingerprint capture failed.');
                logDebug(`Fingerprint capture error: ${result.ErrorCode}`);

                document.getElementById('scanStatus').innerHTML = '<p class="text-danger">Fingerprint capture failed. Please try again.</p>';
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('errorText').textContent = "Fingerprint Capture Error Code: " + result.ErrorCode + ". " + ErrorCodeToString(result.ErrorCode);

                // Re-enable the scan button
                document.getElementById('scanButton').disabled = false;
            }
        }

        function ErrorFunc(status) {
            /*
                If you reach here, user is probably not running the
                service. Redirect the user to a page where they can download the
                executable and install it.
            */
            updateProgress(100, 'Fingerprint service error.');
            document.getElementById('scanStatus').innerHTML = '<p class="text-danger">Fingerprint service error. Is SGIBIOSRV running?</p>';
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('errorText').textContent = "Fingerprint service error. Check if SGIBIOSRV is running; Status = " + status;

            // Re-enable the scan button
            document.getElementById('scanButton').disabled = false;
        }

        function CallSGIFPGetData(successCall, failCall) {
            // SSL client will be supported
            var uri = "https://localhost:8443/SGIFPCapture";

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    fpobject = JSON.parse(xmlhttp.responseText);
                    successCall(fpobject);
                } else if (xmlhttp.status == 404) {
                    failCall(xmlhttp.status)
                }
            }

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
    </script>
</body>
</html>
