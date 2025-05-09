<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - داده‌های بیومتریک</title>
    <style>
        @font-face {
            font-family: 'Vazir';
            src: url('{{ asset('fonts/Vazir.woff2') }}') format('woff2'),
                 url('{{ asset('fonts/Vazir.woff') }}') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazir', 'Tahoma', 'Arial', sans-serif;
        }

        body {
            background-color: #f7f9fc;
            color: #333;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
            padding: 0;
            margin: 0;
            background-image: linear-gradient(135deg, #f9fcff 0%, #f7f7f7 100%);
        }

        .persian-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .persian-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid #e8e8e8;
            position: relative;
            overflow: hidden;
        }

        .persian-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            height: 5px;
            width: 100%;
            background: linear-gradient(90deg, #26a0da, #314755);
        }

        .persian-card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fcfcfc;
        }

        .persian-card-header h2 {
            font-size: 24px;
            color: #314755;
            font-weight: bold;
            margin: 0;
        }

        .persian-card-body {
            padding: 25px;
        }

        .persian-btn {
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            margin-right: 5px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .persian-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .persian-btn-primary {
            background: linear-gradient(135deg, #26a0da, #314755);
            color: white;
        }

        .persian-btn-success {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .persian-btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .persian-btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .persian-alert {
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            position: relative;
            border-right: 4px solid;
        }

        .persian-alert-success {
            background-color: #f4fff8;
            color: #1e7e34;
            border-color: #28a745;
        }

        .persian-alert-danger {
            background-color: #fff5f5;
            color: #c82333;
            border-color: #dc3545;
        }

        .persian-alert-warning {
            background-color: #fffcf3;
            color: #d39e00;
            border-color: #ffc107;
        }

        .persian-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .persian-col {
            padding: 0 15px;
            flex: 1;
        }

        @media (max-width: 768px) {
            .persian-row {
                flex-direction: column;
            }

            .persian-col {
                width: 100%;
                margin-bottom: 20px;
            }
        }

        .persian-fingerprint-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border: 1px solid #eaeaea;
        }

        .persian-fingerprint-image {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .persian-button-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .persian-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .persian-table th,
        .persian-table td {
            padding: 12px 15px;
            text-align: right;
            border-bottom: 1px solid #e9ecef;
        }

        .persian-table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }

        .persian-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .persian-table tr:hover {
            background-color: #f8f9fa;
        }

        .persian-debug-output {
            font-family: monospace;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            height: 200px;
            overflow-y: auto;
            margin-top: 25px;
            display: none;
        }

        .persian-checkbox {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .persian-checkbox input[type="checkbox"] {
            margin-left: 10px;
        }

        .persian-title {
            font-size: 18px;
            color: #314755;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eaeaea;
            position: relative;
        }

        .persian-title::after {
            content: '';
            position: absolute;
            bottom: -1px;
            right: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #26a0da, #314755);
            border-radius: 3px;
        }

        /* Persian design elements */
        .persian-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h20v20H0z' fill='%23f8f9fa'/%3E%3Cpath d='M10 10L0 0v20h20V0L10 10z' fill='%23eaeaea' fill-opacity='.5'/%3E%3C/svg%3E");
            opacity: 0.05;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="persian-container">
        <div class="persian-card">
            <div class="persian-pattern"></div>
            <div class="persian-card-header">
                <h2>داده‌های بیومتریک</h2>
                <a href="{{ url()->previous() }}" class="persian-btn persian-btn-secondary">بازگشت</a>
            </div>
            <div class="persian-card-body">
                <div id="alertContainer"></div>

                <h4 class="persian-title">شناسه رکورد: <span id="recordId">{{ $record_id }}</span></h4>

                <div class="persian-row">
                    <div class="persian-col">
                        <div class="persian-card">
                            <div class="persian-card-header">
                                <h2>ثبت اثر انگشت</h2>
                            </div>
                            <div class="persian-card-body">
                                <div class="persian-fingerprint-container">
                                    <div class="persian-fingerprint-image">
                                        <img id="FPImage1" alt="تصویر اثر انگشت" height="300" width="210"
                                            src="{{ asset('vendor/sq-fingerprint/img/fingerprint-placeholder.png') }}">
                                    </div>
                                    <div class="persian-button-group">
                                        <button type="button" class="persian-btn persian-btn-primary" onclick="captureFP()">دریافت اثر انگشت</button>
                                        <button type="button" id="saveBtn" class="persian-btn persian-btn-success" onclick="saveTemplate()" disabled>ذخیره قالب</button>
                                        <button type="button" id="deleteBtn" class="persian-btn persian-btn-danger" onclick="deleteTemplate()">حذف قالب</button>
                                    </div>

                                    <div class="persian-checkbox">
                                        <input type="checkbox" id="debugMode">
                                        <label for="debugMode">حالت اشکال‌زدایی</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="persian-col">
                        <div class="persian-card">
                            <div class="persian-card-header">
                                <h2>اطلاعات دستگاه</h2>
                            </div>
                            <div class="persian-card-body">
                                <div id="result">
                                    <p>آماده برای دریافت اثر انگشت</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="debugOutput" class="persian-debug-output"></div>
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
            logDebug('دریافت اثر انگشت...');
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
                var tbl = "<table class='persian-table'>";
                tbl += "<tr><td>شماره سریال</td><td><b>" + result.SerialNumber + "</b></td></tr>";
                tbl += "<tr><td>سازنده</td><td><b>" + (result.Manufacturer || 'SecuGen') + "</b></td></tr>";
                tbl += "<tr><td>مدل</td><td><b>" + (result.Model || 'USB Scanner') + "</b></td></tr>";
                tbl += "<tr><td>ارتفاع تصویر</td><td><b>" + result.ImageHeight + "</b></td></tr>";
                tbl += "<tr><td>عرض تصویر</td><td><b>" + result.ImageWidth + "</b></td></tr>";
                tbl += "<tr><td>وضوح تصویر</td><td><b>" + result.ImageDPI + "</b></td></tr>";
                tbl += "<tr><td>کیفیت تصویر</td><td><b>" + result.ImageQuality + "</b></td></tr>";
                tbl += "<tr><td>NFIQ (1-5)</td><td><b>" + result.NFIQ + "</b></td></tr>";
                tbl += "</table>";

                document.getElementById('result').innerHTML = tbl;
                logDebug('اثر انگشت با موفقیت دریافت شد');
            } else {
                alert("خطای دریافت اثر انگشت با کد: " + result.ErrorCode + ".\nتوضیحات: " + ErrorCodeToString(result.ErrorCode) + ".");
            }
        }

        function ErrorFunc(status) {
            /*
                If you reach here, user is probably not running the
                service. Redirect the user to a page where they can download the
                executable and install it.
            */
            alert("بررسی کنید که آیا SGIBIOSRV در حال اجراست؛ وضعیت = " + status + ":");
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
                    Description = "خطا در بارگذاری فایل سیستم";
                    break;
                case 52:
                    Description = "راه‌اندازی تراشه سنسور با شکست مواجه شد";
                    break;
                case 53:
                    Description = "دستگاه یافت نشد";
                    break;
                case 54:
                    Description = "مهلت دریافت تصویر اثر انگشت به پایان رسید";
                    break;
                case 55:
                    Description = "هیچ دستگاهی در دسترس نیست";
                    break;
                case 56:
                    Description = "بارگذاری درایور با شکست مواجه شد";
                    break;
                case 57:
                    Description = "تصویر اشتباه";
                    break;
                case 58:
                    Description = "کمبود پهنای باند";
                    break;
                case 59:
                    Description = "دستگاه مشغول است";
                    break;
                case 60:
                    Description = "دریافت شماره سریال دستگاه امکان‌پذیر نیست";
                    break;
                case 61:
                    Description = "دستگاه پشتیبانی نمی‌شود";
                    break;
                case 63:
                    Description = "SGIBIOSRV شروع به کار نکرده است؛ دوباره تلاش کنید";
                    break;
                default:
                    Description = "کد خطای ناشناخته یا به‌روزرسانی کد برای نمایش آخرین نتیجه";
                    break;
            }
            return Description;
        }

        // Function to check if template exists
        function checkExistingTemplate() {
            logDebug('بررسی وجود قالب برای رکورد: ' + recordId);

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
                    logDebug('قالب برای این رکورد وجود دارد');

                    // Display the image if available
                    if (data.data.BMPBase64) {
                        document.getElementById("FPImage1").src = "data:image/bmp;base64," + data.data.BMPBase64;
                    }

                    // Show device info
                    var tbl = "<table class='persian-table'>";
                    tbl += "<tr><td>شماره سریال</td><td><b>" + (data.data.SerialNumber || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>سازنده</td><td><b>" + (data.data.Manufacturer || 'SecuGen') + "</b></td></tr>";
                    tbl += "<tr><td>مدل</td><td><b>" + (data.data.Model || 'USB Scanner') + "</b></td></tr>";
                    tbl += "<tr><td>ارتفاع تصویر</td><td><b>" + (data.data.ImageHeight || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>عرض تصویر</td><td><b>" + (data.data.ImageWidth || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>وضوح تصویر</td><td><b>" + (data.data.ImageDPI || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>کیفیت تصویر</td><td><b>" + (data.data.ImageQuality || 'N/A') + "</b></td></tr>";
                    tbl += "<tr><td>NFIQ (1-5)</td><td><b>" + (data.data.NFIQ || 'N/A') + "</b></td></tr>";
                    tbl += "</table>";
                    document.getElementById('result').innerHTML = tbl;
                } else {
                    logDebug('قالبی برای این رکورد یافت نشد');
                    document.getElementById('result').innerHTML = "<p>داده بیومتریک موجود نیست. لطفا یک اثر انگشت دریافت کنید.</p>";
                }
            })
            .catch(error => {
                console.error('خطا در بررسی قالب:', error);
                logDebug('خطا در بررسی قالب: ' + error.message);
                document.getElementById('result').innerHTML = "<p>خطا در بررسی قالب موجود.</p>";
            });
        }

        // Function to save template
        function saveTemplate() {
            if (!capturedTemplate && !capturedISOTemplate) {
                showAlert('قالبی ثبت نشده است. لطفا ابتدا یک اثر انگشت را دریافت کنید.', 'warning');
                return;
            }

            logDebug('ذخیره‌سازی قالب برای رکورد: ' + recordId);

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
                    showAlert('قالب با موفقیت ذخیره شد.', 'success');
                    logDebug('قالب با موفقیت ذخیره شد');
                } else {
                    showAlert('خطا در ذخیره‌سازی قالب: ' + data.message, 'danger');
                    logDebug('خطا در ذخیره‌سازی قالب: ' + data.message);
                }
            })
            .catch(error => {
                console.error('خطا در ذخیره‌سازی قالب:', error);
                showAlert('خطا در ذخیره‌سازی قالب: ' + error.message, 'danger');
                logDebug('خطا در ذخیره‌سازی قالب: ' + error.message);
            });
        }

        // Function to delete template
        function deleteTemplate() {
            if (!confirm('آیا از حذف قالب اثر انگشت اطمینان دارید؟')) {
                return;
            }

            logDebug('حذف قالب برای رکورد: ' + recordId);

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
                    showAlert('قالب با موفقیت حذف شد.', 'success');

                    // Reset the image
                    document.getElementById("FPImage1").src = "{{ asset('vendor/sq-fingerprint/img/fingerprint-placeholder.png') }}";

                    document.getElementById('result').innerHTML = "<p>داده بیومتریک موجود نیست. لطفا یک اثر انگشت دریافت کنید.</p>";

                    logDebug('قالب با موفقیت حذف شد');
                } else {
                    showAlert('خطا در حذف قالب: ' + data.message, 'danger');
                    logDebug('خطا در حذف قالب: ' + data.message);
                }
            })
            .catch(error => {
                console.error('خطا در حذف قالب:', error);
                showAlert('خطا در حذف قالب: ' + error.message, 'danger');
                logDebug('خطا در حذف قالب: ' + error.message);
            });
        }

        // Helper function to show alerts
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `persian-alert persian-alert-${type}`;
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
