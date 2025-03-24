<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <script type="text/javascript" src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    <style>
        @page {
            size: 80mm 150mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'persian-font', Arial, sans-serif;
            direction: rtl;
            width: 80mm;
            font-size: 8pt;
        }
        .container {
            width: 80mm;
            padding: 2mm;
            border: 1px dashed #000;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding: 2mm 0;
            font-weight: bold;
        }
        .content {
            display: flex;
            justify-content: space-between;
            padding: 2mm 0;
        }
        .info {
            width: 60%;
            padding-right: 2mm;
        }
        .qr {
            width: 40%;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 1mm 0;
            border-bottom: 1px dotted #ccc;
        }
        .label {
            font-weight: bold;
            width: 40%;
        }
        .value {
            width: 60%;
        }
        #qrcode {
            margin: 0 auto;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .container {
                border: none;
            }
            .header {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @lang("توکن مریض")
        </div>
        <div class="content">
            <div class="info">
                <table>
                    <tr>
                        <td class="label">@lang('Name'):</td>
                        <td class="value">{{ $patient->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Last Name'):</td>
                        <td class="value">{{ $patient->last_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Phone'):</td>
                        <td class="value">{{ $patient->phone }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Department'):</td>
                        <td class="value">{{ $patient->host->department?->fa_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('بخش'):</td>
                        <td class="value">{{ $patient->department }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('داکتر'):</td>
                        <td class="value">{{ $patient->doctor_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('تاریخ مراجعه'):</td>
                        <td class="value">{{ \Verta::instance($patient->registered_at)->format('Y/m/d H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Department'):</td>
                        <td class="value">{{ $patient->host?->department?->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Host'):</td>
                        <td class="value">{{ $patient->host->fa_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('نمبر توکن'):</td>
                        <td class="value">{{ $patient->barcode }}</td>
                    </tr>
                </table>
            </div>
            <div class="qr">
                <div id="qrcode"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 50,
            height: 50,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcode.makeCode("{{ $patient->barcode }}");
    </script>
</body>
</html>
