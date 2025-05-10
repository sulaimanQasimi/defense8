<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسید تیل</title>
    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    <style>
        @media print {
            @page {
                size: 80mm 297mm;  /* Width x Height - standard thermal receipt size */
                margin: 0;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tahoma', Arial, sans-serif;
        }

        body {
            width: 80mm;
            margin: 0 auto;
            padding: 3mm;
            font-size: 12px;
            line-height: 1.2;
            text-align: center;
            direction: rtl;
        }

        .receipt {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
            padding-bottom: 2mm;
            border-bottom: 1px dashed #000;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2mm;
        }

        .subtitle {
            font-size: 14px;
            font-weight: bold;
            margin: 2mm 0;
            padding: 1mm 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
        }

        .info-table th {
            text-align: right;
            font-weight: bold;
            padding: 1mm;
            width: 40%;
        }

        .info-table td {
            text-align: right;
            padding: 1mm;
        }

        .info-table tr {
            border-bottom: 1px dotted #ccc;
        }

        .footer {
            text-align: center;
            margin-top: 3mm;
            padding-top: 2mm;
            border-top: 1px dashed #000;
            font-size: 10px;
        }

        .qr-section {
            display: flex;
            justify-content: center;
            margin: 3mm 0;
        }

        .back-button {
            display: inline-block;
            margin-top: 5mm;
            padding: 2mm 4mm;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 3mm;
        }

        @media print {
            .back-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <div class="title">رسید تیل</div>
            <div>{{ config('app.name') }}</div>
        </div>

        <div class="subtitle">معلومات کارمند</div>

        <table class="info-table">
            <tr>
                <th>ثبت ګنه:</th>
                <td>{{ $employee->registare_no }}</td>
            </tr>
            <tr>
                <th>نوم او تخلص:</th>
                <td>{{ $employee->full_name }}</td>
            </tr>
            <tr>
                <th>د پلارنوم:</th>
                <td>{{ $employee->father_name }}</td>
            </tr>
            <tr>
                <th>دنده:</th>
                <td>{{ $employee->job_structure }}</td>
            </tr>
            <tr>
                <th>اروند اداره:</th>
                <td>{{ $employee->orginization?->fa_name }}</td>
            </tr>
        </table>

        <div class="subtitle">معلومات تیل</div>

        <table class="info-table">
            <tr>
                <th>نوع تیل:</th>
                <td>
                    @if($employee->oil_type && $employee->oil_type == \Vehical\OilType::Diesel)
                        دیزل
                    @else
                        پطرول
                    @endif
                </td>
            </tr>
            <tr>
                <th>مقدار ماهانه:</th>
                <td>{{ $employee->monthly_rate }} لیتر</td>
            </tr>
            <tr>
                <th>مقدار مصرف:</th>
                <td>{{ $employee->current_month_oil_consumtion }} لیتر</td>
            </tr>
            <tr>
                <th>باقیمانده:</th>
                <td>{{ $employee->current_month_oil_remain }} لیتر</td>
            </tr>
            <tr>
                <th>تیل دریافت شده:</th>
                <td>{{ $oil->oil_amount }} لیتر</td>
            </tr>
            <tr>
                <th>تاریخ:</th>
                <td>{{ verta($oil->filled_date)->format('Y/m/d') }}</td>
            </tr>
        </table>

        <div class="qr-section">
            <div id="qrcode"></div>
        </div>

        <div class="footer">
            <div>شماره تراکنش: {{ $oil->id }}</div>
            <div>{{ verta($oil->created_at) }}</div>
            <div>پمپ استیشن: {{ $employee->pumpStation?->name ?? '---' }}</div>
        </div>
    </div>

    <a href="{{ route('sq.oil.oil') }}" class="back-button">بازگشت</a>

    <script type="text/javascript">
        // Generate QR code
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "{{ request()->url() }}",
            width: 64,
            height: 64,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Auto print on page load
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>

</html>
