<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Biometric Data</title>
    <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js'])
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            cursor: pointer;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            margin-right: 5px;
            font-weight: 500;
        }
        .btn-primary { background: #3490dc; color: white; }
        .btn-success { background: #38c172; color: white; }
        .btn-danger { background: #e3342f; color: white; }
        .btn-info { background: #6cb2eb; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }
        .alert-warning { background-color: #fff3cd; color: #856404; }
        #debugOutput {
            font-family: monospace;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            height: 200px;
            overflow-y: auto;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Biometric Data</h2>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div id="alertContainer"></div>
                
                <h4>Record ID: <span id="recordId">{{ $record_id }}</span></h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Fingerprint Capture</div>
                            <div class="card-body text-center">
                                <img id="FPImage1" alt="Fingerprint Image" height="300" width="210" align="center" 
                                    src="{{ asset('vendor/sq-fingerprint/img/fingerprint-placeholder.png') }}">
                                <br><br>
                                <button type="button" class="btn btn-primary" onclick="captureFP()">Capture Fingerprint</button>
                                <button type="button" id="saveBtn" class="btn btn-success" onclick="saveTemplate()" disabled>Save Template</button>
                                <button type="button" id="deleteBtn" class="btn btn-danger" onclick="deleteTemplate()">Delete Template</button>
                                
                                <div class="mt-3">
                                    <label>
                                        <input type="checkbox" id="debugMode"> Debug Mode
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Device Information</div>
                            <div class="card-body">
                                <div id="result">
                                    <p>Ready to capture fingerprint</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="debugOutput"></div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        // License key (if required)
        var secugen_lic = "";
        var recordId = document.getElementById('recordId').innerText;
        var capturedTemplate = null;
        var capturedISOTemplate = null;
        var capturedImage = null;
        
        // DOM elements
        const saveBtn = document.getElementById('saveBtn');
        const deleteBtn = document.getElementById('deleteBtn');
        const debugMode = document.getElementById('debugMode');
        const debugOutput = document.getElementById('debugOutput');
        const alertContainer = document.getElementById('alertContainer');
        
        // Toggle debug output
        debugMode.addEventListener('change', function() {
            debugOutput.style.display = this.checked ? 'block' : 'none';
        });
        
        // Check if template exists for this record
        checkExistingTemplate();
        
        function captureFP() {
            logDebug('Capturing fingerprint...');
            CallSGIFPGetData(SuccessFunc, ErrorFunc);
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
                }
                
                // Store captured templates
                capturedTemplate = result.TemplateBase64;
                capturedISOTemplate = result.ISOTemplateBase64;
                capturedImage = result.BMPBase64;
                
                // Enable buttons
                saveBtn.disabled = false;
                
                // Build device info table
                var tbl = "<table class='table table-bordered'>";
                tbl += "<tr><td>Serial Number</td><td><b>" + result.SerialNumber + "</b></td></tr>";
                tbl += "<tr><td>Manufacturer</td><td><b>" + (result.Manufacturer || 'SecuGen') + "</b></td></tr>";
                tbl += "<tr><td>Model</td><td><b>" + (result.Model || 'USB Scanner') + "</b></td></tr>";
                tbl += "<tr><td>Image Height</td><td><b>" + result.ImageHeight + "</b></td></tr>";
                tbl += "<tr><td>Image Width</td><td><b>" + result.ImageWidth + "</b></td></tr>";
                tbl += "<tr><td>Image Resolution</td><td><b>" + result.ImageDPI + "</b></td></tr>";
                tbl += "<tr><td>Image Quality</td><td><b>" + result.ImageQuality + "</b></td></tr>";
                tbl += "<tr><td>NFIQ (1-5)</td><td><b>" + result.NFIQ + "</b></td></tr>";
                tbl += "</table>";
                
                document.getElementById('result').innerHTML = tbl;
                logDebug('Fingerprint captured successfully');
            } else {
                alert("Fingerprint Capture Error Code: " + result.ErrorCode + ".\nDescription: " + ErrorCodeToString(result.ErrorCode) + ".");
            }
        }
        
        function ErrorFunc(status) {
            /*
                If you reach here, user is probably not running the
                service. Redirect the user to a page where they can download the
                executable and install it.
            */
            alert("Check if SGIBIOSRV is running; Status = " + status + ":");
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
        
        // Function to check if template exists
        function checkExistingTemplate() {
            logDebug('Checking if template exists for record: ' + recordId);
            
            fetch(`/fingerprint/biodata/${recordId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    logDebug('Template exists for this record');
                    
                    // Display the image if available
                    if (data.data.BMPBase64) {
                        document.getElementById("FPImage1").src = "data:image/bmp;base64," + data.data.BMPBase64;
                    }
                    
                    // Show device info
                    var tbl = "<table class='table table-bordered'>";
                    tbl += "<tr><td>Serial Number</td><td><b>" + (data.data.SerialNumber || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>Manufacturer</td><td><b>" + (data.data.Manufacturer || 'SecuGen') + "</b></td></tr>";
                    tbl += "<tr><td>Model</td><td><b>" + (data.data.Model || 'USB Scanner') + "</b></td></tr>";
                    tbl += "<tr><td>Image Height</td><td><b>" + (data.data.ImageHeight || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>Image Width</td><td><b>" + (data.data.ImageWidth || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>Image Resolution</td><td><b>" + (data.data.ImageDPI || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>Image Quality</td><td><b>" + (data.data.ImageQuality || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>NFIQ (1-5)</td><td><b>" + (data.data.NFIQ || 'N/A') + "</b></td></tr>";
                    tbl += "</table>";
                    document.getElementById('result').innerHTML = tbl;
                } else {
                    logDebug('No template found for this record');
                    document.getElementById('result').innerHTML = "<p>No biometric data available. Please capture a fingerprint.</p>";
                }
            })
            .catch(error => {
                console.error('Error checking template:', error);
                logDebug('Error checking template: ' + error.message);
                document.getElementById('result').innerHTML = "<p>Error checking for existing template.</p>";
            });
        }
        
        // Function to save template
        function saveTemplate() {
            if (!capturedTemplate && !capturedISOTemplate) {
                showAlert('No template captured. Please capture a fingerprint first.', 'warning');
                return;
            }
            
            logDebug('Saving template for record: ' + recordId);
            
            const templateData = {
                Manufacturer: 'SecuGen',
                Model: 'USB Scanner',
                SerialNumber: 'Secugen Device',
                ImageWidth: 500,
                ImageHeight: 500,
                ImageDPI: 500,
                ImageQuality: 90,
                NFIQ: 1,
                TemplateBase64: capturedTemplate,
                ISOTemplateBase64: capturedISOTemplate,
                BMPBase64: capturedImage
            };
            
            fetch(`/fingerprint/biodata/${recordId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(templateData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Template saved successfully.', 'success');
                    logDebug('Template saved successfully');
                } else {
                    showAlert('Error saving template: ' + data.message, 'danger');
                    logDebug('Error saving template: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error saving template:', error);
                showAlert('Error saving template: ' + error.message, 'danger');
                logDebug('Error saving template: ' + error.message);
            });
        }
        
        // Function to delete template
        function deleteTemplate() {
            if (!confirm('Are you sure you want to delete the fingerprint template?')) {
                return;
            }
            
            logDebug('Deleting template for record: ' + recordId);
            
            fetch(`/fingerprint/biodata/${recordId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Template deleted successfully.', 'success');
                    
                    // Reset the image
                    document.getElementById("FPImage1").src = "{{ asset('vendor/sq-fingerprint/img/fingerprint-placeholder.png') }}";
                    
                    document.getElementById('result').innerHTML = "<p>No biometric data available. Please capture a fingerprint.</p>";
                    
                    logDebug('Template deleted successfully');
                } else {
                    showAlert('Error deleting template: ' + data.message, 'danger');
                    logDebug('Error deleting template: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting template:', error);
                showAlert('Error deleting template: ' + error.message, 'danger');
                logDebug('Error deleting template: ' + error.message);
            });
        }
        
        // Helper function to show alerts
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = message;
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alertDiv);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
        
        // Helper function to log debug information
        function logDebug(message) {
            if (debugMode.checked) {
                const now = new Date();
                const timestamp = now.toLocaleTimeString() + '.' + now.getMilliseconds().toString().padStart(3, '0');
                const logEntry = document.createElement('div');
                logEntry.innerHTML = `[${timestamp}] ${message}`;
                debugOutput.appendChild(logEntry);
                debugOutput.scrollTop = debugOutput.scrollHeight;
                console.log(`[Debug] ${message}`);
            }
        }
    </script>
</body>
</html> 