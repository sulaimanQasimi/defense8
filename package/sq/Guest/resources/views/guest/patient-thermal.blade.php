<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>توکن مریض</title>
    <script src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script src="{{ asset('qrcode/qrcode.js') }}"></script>
    <style>
        /* Thermal Printer Size Settings */
        @page {
            size: 80mm 150mm;
            margin: 0;
        }

        @font-face {
            font-family: "persian-font";
            src: url("/mod_font.ttf") format("truetype");
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'persian-font', Arial, sans-serif;
            direction: rtl;
            width: 80mm;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            background-color: #fff;
        }

        .thermal-receipt {
            width: 80mm;
            padding: 3mm;
            margin: 0 auto;
        }

        .receipt-border {
            border: 1px dashed #000;
            padding: 2mm;
            border-radius: 4px;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding: 3mm 0;
            margin-bottom: 3mm;
            font-weight: bold;
            font-size: 14pt;
        }

        .datetime {
            display: flex;
            justify-content: space-between;
            padding: 2mm 0;
            font-size: 8pt;
            border-bottom: 1px dotted #ccc;
            margin-bottom: 2mm;
        }

        .date-label, .time-label {
            font-weight: normal;
        }

        .date-value, .time-value {
            font-weight: bold;
            direction: ltr;
            display: inline-block;
            unicode-bidi: isolate;
        }

        .receipt-content {
            display: flex;
            justify-content: space-between;
        }

        .patient-info {
            width: 65%;
            padding-right: 2mm;
        }

        .qr-container {
            width: 35%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px dotted #ccc;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 2mm 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 40%;
            color: #333;
        }

        .info-value {
            width: 60%;
        }

        .token-number {
            font-weight: bold;
            font-size: 12pt;
        }

        .qr-code {
            margin-bottom: 3mm;
            padding: 2mm;
            background-color: white;
            border-radius: 4px;
        }

        #qrcode {
            margin: 0 auto;
        }

        .qr-help-text {
            font-size: 7pt;
            text-align: center;
            margin-top: 1mm;
        }

        .receipt-footer {
            margin-top: 3mm;
            padding-top: 2mm;
            border-top: 1px dashed #000;
            font-size: 8pt;
            text-align: center;
        }

        /* Thermal Printer Optimizations */
        @media print {
            html, body {
                width: 80mm;
                height: auto;
                margin: 0 !important;
                padding: 0 !important;
            }

            .receipt-border {
                border: none;
            }

            .receipt-header {
                border-bottom: 1px dashed #000;
            }

            body, .info-table td {
                color: #000 !important;
            }

            .thermal-receipt, .receipt-content, .patient-info, .qr-container {
                background-color: transparent !important;
            }

            .thermal-receipt {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="thermal-receipt">
        <div class="receipt-border">
            <div class="receipt-header">
                توکن مریض
            </div>

            <div class="datetime">
                <div class="date-label">تاریخ: <span class="date-value">{{ verta()->format('Y/m/d') }}</span></div>
                <div class="time-label">ساعت: <span class="time-value">{{ verta()->format('H:i') }}</span></div>
            </div>

            <div class="receipt-content">
                <div class="patient-info">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">نام:</td>
                            <td class="info-value">{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">تخلص:</td>
                            <td class="info-value">{{ $patient->last_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">شماره تماس:</td>
                            <td class="info-value">{{ $patient->phone }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">اداره:</td>
                            <td class="info-value">{{ $patient->host->department?->fa_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">بخش:</td>
                            <td class="info-value">{{ $patient->department }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">داکتر:</td>
                            <td class="info-value">{{ $patient->doctor_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">تاریخ مراجعه:</td>
                            <td class="info-value">{{ \Verta::instance($patient->registered_at)->format('Y/m/d H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">میزبان:</td>
                            <td class="info-value">{{ $patient->host->fa_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">نمبر توکن:</td>
                            <td class="info-value token-number">{{ $patient->barcode }}</td>
                        </tr>
                    </table>
                </div>

                <div class="qr-container">
                    <div class="qr-code">
                        <div id="qrcode"></div>
                    </div>
                    <div class="qr-help-text">
                        برای تایید اسکن کنید
                    </div>
                </div>
            </div>

            <div class="receipt-footer">
                تشکر از مراجعه شما - صحت و سلامتی شما آرزوی ماست
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                width: 85,
                height: 85,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            qrcode.makeCode("{{ $patient->barcode }}");

            // Auto-print when loaded
            window.onload = function() {
                window.print();
            };
        });
    </script>
</body>
</html>
