<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <script type="text/javascript" src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    @vite(['resources/js/app.js'])

    <script type="text/javascript" src="{{ asset('single.css') }}"></script>
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
            @lang("Temporary Guest QR Code")
        </div>
        <div class="content">
            <div class="info">
                <table>
                    <tr>
                        <td class="label">@lang('Name'):</td>
                        <td class="value">{{ $guest->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Department'):</td>
                        <td class="value">{{ $guest->host->department?->fa_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Invited By'):</td>
                        <td class="value">{{ $guest->host->head_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Address'):</td>
                        <td class="value">{{ $guest->address }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('نوع واسطه'):</td>
                        <td class="value">{{ $guest->vehical_type }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('رنگ واسطه'):</td>
                        <td class="value">{{ $guest->vehical_color }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('شماره میزبان'):</td>
                        <td class="value">{{ $guest->host?->phone }}</td>
                    </tr>
                    <tr>
                        <td class="label">@lang('Code'):</td>
                        <td class="value"><i><b>{{ $url }}</b></i></td>
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
        qrcode.makeCode("{{ $url }}");
    </script>
</body>

</html>
