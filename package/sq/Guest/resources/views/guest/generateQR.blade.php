<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>کارت مهمان موقت</title>

    <!-- Only include essential JS libraries for QR generation without external CSS dependencies -->
    <script src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script src="{{ asset('qrcode/qrcode.js') }}"></script>

    <style>
        /* Essential Thermal Printer Size Settings */
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
            width: 80mm;
            font-family: 'persian-font', Arial, sans-serif;
            direction: rtl;
            font-size: 10pt;
            line-height: 1.2;
            color: #000;
            background-color: #fff;
        }

        .receipt {
            width: 80mm;
            padding: 3mm;
            margin: 0 auto;
        }

        .receipt-border {
            border: 1px dashed #000;
            padding: 2mm;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding: 3mm 0;
            margin-bottom: 3mm;
            font-weight: bold;
            font-size: 12pt;
        }

        .receipt-content {
            display: flex;
            justify-content: space-between;
        }

        .guest-info {
            width: 65%;
            padding-right: 3mm;
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
            padding: 1.5mm 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 40%;
        }

        .info-value {
            width: 60%;
        }

        #qrcode {
            margin: 0 auto;
            background-color: white;
            padding: 1mm;
            /* QR code will be generated with JS */
        }

        .qr-code {
            margin-bottom: 2mm;
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

        .datetime {
            display: flex;
            justify-content: space-between;
            padding: 2mm 0;
            font-size: 8pt;
            border-bottom: 1px dotted #ccc;
            margin-bottom: 2mm;
        }

        .date-value, .time-value {
            font-weight: bold;
            direction: ltr;
            display: inline-block;
            unicode-bidi: isolate;
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

            /* Ensure high contrast for better print quality */
            body, .info-table td {
                color: #000 !important;
            }

            /* Avoid background colors which can cause issues on thermal printers */
            .receipt, .receipt-content, .guest-info, .qr-container {
                background-color: transparent !important;
            }

            /* Force page breaks appropriately */
            .receipt {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt-border">
            <div class="receipt-header">
                کارت مهمان موقت
            </div>

            <div class="datetime">
                <div class="date-label">تاریخ: <span class="date-value">{{ verta()->format('Y/m/d') }}</span></div>
                <div class="time-label">ساعت: <span class="time-value">{{ verta()->format('H:i') }}</span></div>
            </div>

            <div class="receipt-content">
                <div class="guest-info">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">نام:</td>
                            <td class="info-value">{{ $guest->name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">اداره:</td>
                            <td class="info-value">{{ $guest->host->department?->fa_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">دعوت کننده:</td>
                            <td class="info-value">{{ $guest->host->head_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">آدرس:</td>
                            <td class="info-value">{{ $guest->address }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">نوع واسطه:</td>
                            <td class="info-value">{{ $guest->vehical_type }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">رنگ واسطه:</td>
                            <td class="info-value">{{ $guest->vehical_color }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">شماره میزبان:</td>
                            <td class="info-value">{{ $guest->host?->phone }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">کد:</td>
                            <td class="info-value"><b>{{ $url }}</b></td>
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
                معتبر تا: <span class="date-value">{{ verta(now()->addHours(24))->format('Y/m/d H:i') }}</span>
            </div>
        </div>
    </div>

    <script>
        // Set up QR code with optimal size for thermal printer
        document.addEventListener('DOMContentLoaded', function() {
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                width: 85,
                height: 85,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            qrcode.makeCode("{{ $url }}");

            // Auto-print when loaded
            window.onload = function() {
                window.print();
            };
        });
    </script>
</body>

</html>
