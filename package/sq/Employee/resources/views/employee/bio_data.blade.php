<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Employee Biometric Data</h3>
                    <h4>{{ $employee->name }} {{ $employee->last_name }}</h4>
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
                            <div class="card">
                                <div class="card-header">Capture Fingerprint</div>
                                <div class="card-body text-center">
                                    <img id="FPImage1" alt="Fingerprint Image" height=300 width=210
                                        src="{{ $bioData ? 'data:image/bmp;base64,' . $bioData->BMPBase64 : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=' }}">
                                    <br>
                                    <button type="button" class="btn btn-primary mt-3" onclick="captureFP()">Capture Fingerprint</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Device Information</div>
                                <div class="card-body">
                                    <div id="result">
                                        @if($bioData)
                                        <table class="table table-striped">
                                            <tr>
                                                <td>Serial Number</td>
                                                <td>{{ $bioData->SerialNumber }}</td>
                                            </tr>
                                            <tr>
                                                <td>Manufacturer</td>
                                                <td>{{ $bioData->Manufacturer }}</td>
                                            </tr>
                                            <tr>
                                                <td>Model</td>
                                                <td>{{ $bioData->Model }}</td>
                                            </tr>
                                            <tr>
                                                <td>Image Height</td>
                                                <td>{{ $bioData->ImageHeight }}</td>
                                            </tr>
                                            <tr>
                                                <td>Image Width</td>
                                                <td>{{ $bioData->ImageWidth }}</td>
                                            </tr>
                                            <tr>
                                                <td>Image Resolution</td>
                                                <td>{{ $bioData->ImageDPI }}</td>
                                            </tr>
                                            <tr>
                                                <td>Image Quality</td>
                                                <td>{{ $bioData->ImageQuality }}</td>
                                            </tr>
                                            <tr>
                                                <td>NFIQ</td>
                                                <td>{{ $bioData->NFIQ }}</td>
                                            </tr>
                                        </table>
                                        @else
                                        <p>No biometric data available. Please capture a fingerprint.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden form for submitting fingerprint data -->
                    <form id="bioDataForm" method="POST" action="{{ route('sqemployee.employee.biodata.store', $employee->id) }}">
                        @csrf
                        <input type="hidden" name="Manufacturer" id="Manufacturer">
                        <input type="hidden" name="Model" id="Model">
                        <input type="hidden" name="SerialNumber" id="SerialNumber">
                        <input type="hidden" name="ImageWidth" id="ImageWidth">
                        <input type="hidden" name="ImageHeight" id="ImageHeight">
                        <input type="hidden" name="ImageDPI" id="ImageDPI">
                        <input type="hidden" name="ImageQuality" id="ImageQuality">
                        <input type="hidden" name="NFIQ" id="NFIQ">
                        <input type="hidden" name="ImageDataBase64" id="ImageDataBase64">
                        <input type="hidden" name="BMPBase64" id="BMPBase64">
                        <input type="hidden" name="ISOTemplateBase64" id="ISOTemplateBase64">
                        <input type="hidden" name="TemplateBase64" id="TemplateBase64">
                    </form>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-success" id="saveButton" disabled>Save Biometric Data</button>
                                @if($bioData)
                                <form method="POST" action="{{ route('sqemployee.employee.biodata.destroy', $employee->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this biometric data?')">Delete Biometric Data</button>
                                </form>
                                @endif
                                <a href="{{ route('sqemployee.employee.finger.index') }}" class="btn btn-info">
                                    <i class="fas fa-fingerprint mr-1"></i> Fingerprint Identification
                                </a>
                                {{-- <a href="{{ route('sqemployee.employee.show', $employee->id) }}" class="btn btn-secondary">Back to Employee</a> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Fingerprint Verification Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Fingerprint Verification</div>
                                <div class="card-body">
                                    <div id="verificationResult"></div>
                                    <button type="button" class="btn btn-info" id="verifyButton" onclick="verifyFingerprint()">Verify Fingerprint</button>
                                </div>
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

    function captureFP() {
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

            // Fill in the form fields
            document.getElementById('Manufacturer').value = result.Manufacturer || '';
            document.getElementById('Model').value = result.Model || '';
            document.getElementById('SerialNumber').value = result.SerialNumber || '';
            document.getElementById('ImageWidth').value = result.ImageWidth || '';
            document.getElementById('ImageHeight').value = result.ImageHeight || '';
            document.getElementById('ImageDPI').value = result.ImageDPI || '';
            document.getElementById('ImageQuality').value = result.ImageQuality || '';
            document.getElementById('NFIQ').value = result.NFIQ || '';
            document.getElementById('BMPBase64').value = result.BMPBase64 || '';
            document.getElementById('TemplateBase64').value = result.TemplateBase64 || '';
            document.getElementById('ISOTemplateBase64').value = result.ISOTemplateBase64 || '';

            // Build device info table
            var tbl = "<table class='table table-striped'>";
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

            // Enable the save button
            document.getElementById('saveButton').disabled = false;
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

    // Submit form when save button is clicked
    document.getElementById('saveButton').addEventListener('click', function() {
        document.getElementById('bioDataForm').submit();
    });

    // Function to verify fingerprint
    function verifyFingerprint() {
        CallSGIFPGetData(function(result) {
            if (result.ErrorCode == 0) {
                // Send the ISO template to the server for verification
                fetch('{{ route("sqemployee.employee.biodata.verify", $employee->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ISOTemplateBase64: result.ISOTemplateBase64
                    })
                })
                .then(response => response.json())
                .then(data => {
                    var resultDiv = document.getElementById('verificationResult');
                    if (data.match) {
                        resultDiv.innerHTML = '<div class="alert alert-success">Fingerprint verified! Match: ' + data.match + '</div>';
                    } else {
                        resultDiv.innerHTML = '<div class="alert alert-danger">Fingerprint does not match any records.</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('verificationResult').innerHTML =
                        '<div class="alert alert-danger">Error verifying fingerprint: ' + error.message + '</div>';
                });
            } else {
                alert("Fingerprint Capture Error Code: " + result.ErrorCode + ".\nDescription: " + ErrorCodeToString(result.ErrorCode) + ".");
            }
        }, ErrorFunc);
    }
</script>
</body>
</html>
