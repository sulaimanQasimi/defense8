<!DOCTYPE html>

<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تأیید اثر انگشت - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <style>
        @font-face {
            font-family: 'Vazir';
            src: url('{{ asset('fonts/Vazir.woff2') }}') format('woff2'),
                 url('{{ asset('fonts/Vazir.woff') }}') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Vazir', Tahoma, Arial, sans-serif;
            background-color: #f7f9fc;
            color: #2c3e50;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            margin-bottom: 30px;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #e7e7e7;
        }

        .page-header h1 {
            font-size: 28px;
            color: #3498db;
            margin-bottom: 10px;
        }

        .page-header h3 {
            font-size: 18px;
            font-weight: normal;
            color: #7f8c8d;
        }

        .fingerprint-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
            gap: 30px;
        }

        .fingerprint-box {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            min-width: 300px;
            max-width: 450px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        .form-section input[type="text"] {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Vazir', Tahoma, Arial, sans-serif;
            font-size: 14px;
        }

        .fingerprint-images {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .fingerprint-pair {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .fingerprint-image {
            border: 2px solid #3498db;
            border-radius: 5px;
            padding: 3px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .fingerprint-image img {
            display: block;
            width: 210px;
            height: 300px;
            object-fit: contain;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 15px 0;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Vazir', Tahoma, Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .btn:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        .result-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #f8f9fa;
            border-right: 3px solid #3498db;
        }

        .result-box p {
            margin-bottom: 5px;
        }

        footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e7e7e7;
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>سیستم تطبیق اثر انگشت</h1>
            <h3>تأیید هویت با استفاده از اثر انگشت</h3>
        </div>

        <div class="fingerprint-container">
            <div class="fingerprint-box">
                <div class="form-section">
                    <label for="quality">حداقل امتیاز تطابق:</label>
                    <input type="text" id="quality" value="20">
                </div>

                <div class="form-section">
                    <label for="cardInfoId">شناسه کارت:</label>
                    <input type="text" id="cardInfoId" value="{{ $cardInfoId ?? '' }}">
                </div>

                <div class="fingerprint-images">
                    <div class="fingerprint-pair">
                        <div class="fingerprint-image">
                            <img id="FPImage1" alt="اثر انگشت اول" src="{{ asset('images/PlaceFinger.bmp') }}">
                        </div>
                        <div class="fingerprint-image">
                            <img id="FPImage2" alt="اثر انگشت دوم" src="{{ asset('images/PlaceFinger2.bmp') }}">
                        </div>
                    </div>
</div>

                <div class="button-group">
                    <button class="btn btn-primary" onclick="CallSGIFPGetData(SuccessFunc1, ErrorFunc)">اسکن اثر انگشت اول</button>
                    <button class="btn btn-primary" onclick="CallSGIFPGetData(SuccessFunc2, ErrorFunc)">اسکن اثر انگشت دوم</button>
                </div>

                <div class="button-group">
                    <button class="btn btn-secondary" id="loadStoredBtn" onclick="loadStoredFingerprint()">بارگذاری از کارت</button>
                    <button class="btn btn-success" id="verifyBtn" onclick="matchScore(succMatch, failureFunc)" disabled>تطبیق اثر انگشت</button>
                </div>

                <div class="result-box">
                    <p id="result1"></p>
                    <p id="result2"></p>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; {{ date('Y') }} - {{ config('app.name') }}</p>
        </footer>
    </div>

<script type="text/javascript">
    // Global variables to store templates
    var template_1 = "";
    var template_2 = "";
    var secugen_lic = "";

    // On page load, try to load fingerprint if cardInfo is provided
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($cardInfo) && $cardInfo && $cardInfo->biometricData)
            // Display stored fingerprint if available
            @if($cardInfo->biometricData->BMPBase64)
                document.getElementById('FPImage1').src = "data:image/bmp;base64,{{ $cardInfo->biometricData->BMPBase64 }}";
            @endif

            // Store the template
            @if($cardInfo->biometricData->ISOTemplateBase64)
                template_1 = "{{ $cardInfo->biometricData->ISOTemplateBase64 }}";
                document.getElementById('result1').innerHTML = "اثر انگشت ذخیره شده با موفقیت بارگذاری شد.";
            @elseif($cardInfo->biometricData->TemplateBase64)
                template_1 = "{{ $cardInfo->biometricData->TemplateBase64 }}";
                document.getElementById('result1').innerHTML = "اثر انگشت ذخیره شده با موفقیت بارگذاری شد.";
            @else
                document.getElementById('result1').innerHTML = "خطا: هیچ الگوی اثر انگشتی برای این کاربر یافت نشد.";
            @endif

            // Check if verify button should be enabled
            checkVerifyButtonStatus();
        @endif
    });

    function SuccessFunc1(result) {
        if (result.ErrorCode == 0) {
            /* Display BMP data in image tag
                BMP data is in base 64 format
            */
            if (result != null && result.BMPBase64.length > 0) {
                document.getElementById('FPImage1').src = "data:image/bmp;base64," + result.BMPBase64;
            }

            // Store the template
            template_1 = result.ISOTemplateBase64 || result.TemplateBase64;
            document.getElementById('result1').innerHTML = "اثر انگشت اول با موفقیت اسکن شد.";

            // Enable verify button if both fingerprints are available
            checkVerifyButtonStatus();
        }
        else {
            document.getElementById('result1').innerHTML = "خطا: " + ErrorCodeToString(result.ErrorCode);
        }
    }

    function SuccessFunc2(result) {
        if (result.ErrorCode == 0) {
            /* Display BMP data in image tag
                BMP data is in base 64 format
            */
            if (result != null && result.BMPBase64.length > 0) {
                document.getElementById('FPImage2').src = "data:image/bmp;base64," + result.BMPBase64;
            }

            // Store the template
            template_2 = result.ISOTemplateBase64 || result.TemplateBase64;
            document.getElementById('result2').innerHTML = "اثر انگشت دوم با موفقیت اسکن شد.";

            // Enable verify button if both fingerprints are available
            checkVerifyButtonStatus();
        }
        else {
            document.getElementById('result2').innerHTML = "خطا: " + ErrorCodeToString(result.ErrorCode);
        }
    }

    function loadStoredFingerprint() {
        var cardInfoId = document.getElementById('cardInfoId').value;

        if (!cardInfoId) {
            document.getElementById('result1').innerHTML = "خطا: لطفا ابتدا شناسه کارت را وارد کنید.";
            return;
        }

        // Redirect to the proper route with the CardInfo ID
        window.location.href = "{{ route('fingerprint.cardinfo.verify.page', '') }}/" + cardInfoId;
    }

    function ErrorFunc(status) {
        document.getElementById('result2').innerHTML = "خطا: " + status + ". بررسی کنید که SGIBIOSRV در حال اجراست.";
    }

    function CallSGIFPGetData(successCall, failCall) {
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
        xmlhttp.onerror = function () {
            failCall(xmlhttp.status);
        }
        var params = "Timeout=" + "10000";
        params += "&Quality=" + "50";
        params += "&licstr=" + encodeURIComponent(secugen_lic);
        params += "&templateFormat=" + "ISO";
        xmlhttp.open("POST", uri, true);
        xmlhttp.send(params);
    }

    function matchScore(succFunction, failFunction) {
        if (template_1 == "" || template_2 == "") {
            alert("لطفاً هر دو اثر انگشت را اسکن کنید!");
            return;
        }
        var uri = "https://localhost:8443/SGIMatchScore";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                fpobject = JSON.parse(xmlhttp.responseText);
                succFunction(fpobject);
            }
            else if (xmlhttp.status == 404) {
                failFunction(xmlhttp.status)
            }
        }

        xmlhttp.onerror = function () {
            failFunction(xmlhttp.status);
        }
        var params = "template1=" + encodeURIComponent(template_1);
        params += "&template2=" + encodeURIComponent(template_2);
        params += "&licstr=" + encodeURIComponent(secugen_lic);
        params += "&templateFormat=" + "ISO";
        xmlhttp.open("POST", uri, false);
        xmlhttp.send(params);
    }

    function succMatch(result) {
        var idQuality = document.getElementById("quality").value;
        if (result.ErrorCode == 0) {
            if (result.MatchingScore >= idQuality)
                alert("تطبیق موفق! (امتیاز: " + result.MatchingScore + ")");
            else
                alert("عدم تطبیق! (امتیاز: " + result.MatchingScore + ")");
        }
        else {
            alert("خطا در اسکن اثر انگشت، کد خطا = " + result.ErrorCode);
        }
    }

    function failureFunc(error) {
        alert("خطا در فرآیند تطبیق!");
    }

    function checkVerifyButtonStatus() {
        var verifyBtn = document.getElementById('verifyBtn');
        if (template_1 && template_2) {
            verifyBtn.disabled = false;
        } else {
            verifyBtn.disabled = true;
        }
    }

    function ErrorCodeToString(ErrorCode) {
        var Description;
        switch (ErrorCode) {
            // 0 - 999 - Comes from SgFplib.h
            // 1,000 - 9,999 - SGIBioSrv errors
            // 10,000 - 99,999 license errors
            case 51:
                Description = "خطا در بارگذاری فایل سیستمی";
                break;
            case 52:
                Description = "خطا در راه‌اندازی سنسور";
                break;
            case 53:
                Description = "دستگاه پیدا نشد";
                break;
            case 54:
                Description = "زمان اسکن اثر انگشت به پایان رسید";
                break;
            case 55:
                Description = "هیچ دستگاهی در دسترس نیست";
                break;
            case 56:
                Description = "خطا در بارگذاری درایور";
                break;
            case 57:
                Description = "تصویر نامعتبر";
                break;
            case 58:
                Description = "کمبود پهنای باند";
                break;
            case 59:
                Description = "دستگاه مشغول است";
                break;
            case 60:
                Description = "نمی‌توان شماره سریال دستگاه را خواند";
                break;
            case 61:
                Description = "دستگاه پشتیبانی نمی‌شود";
                break;
            case 63:
                Description = "سرویس SGIBIOSRV اجرا نشده است؛ دوباره تلاش کنید";
                break;
            default:
                Description = "کد خطای ناشناخته";
                break;
        }
        return Description;
    }
</script>
</body>
</html>
