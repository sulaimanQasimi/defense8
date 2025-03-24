<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <script type="text/javascript" src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    @vite(['resources/js/app.js'])
    <script type="text/javascript" src="{{ asset('build/assets/app.css') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/sqguest/css/single.css') }}"></script>
    <style>
        th, td {
            border-bottom: 1px solid #ccc;
            padding: 2px;
            text-align: right;
            font-family: 'persian-font';
        }
    </style>
</head>
<body dir="rtl">
    <div class="p-1">
        <div class="h-[160px] w-[260px] border-gray-300 border-2 border-dashed relative text-sm">
            <div class="text-center pb-3 border-gray-300 border-b-2" style="font-family: 'persian-font';">@lang("Patient QR Code")</div>

            <div class="grid grid-col-2">
                <div class="col-span-1">
                    <table class="text-xs">
                        <tr>
                            <td style="font-family: 'persian-font';">@lang('Name'): </td>
                            <td style="font-family: 'persian-font';">{{ $patient->name }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Last Name'):</td>
                            <td>{{ $patient->last_name }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Phone'):</td>
                            <td>{{ $patient->phone }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Department'):</td>
                            <td>{{ $patient->host->department?->fa_name }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Doctor'):</td>
                            <td>{{ $patient->doctor_name }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Blood Type'):</td>
                            <td>{{ $patient->blood_type }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Status'):</td>
                            <td>{{ $patient->status }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Code'):</td>
                            <td><i><b>{{ $url }}</b></i></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div id="qrcode" class="absolute top-8 left-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 50,
            height: 50
        });
        qrcode.makeCode("{{ $url }}");
    </script>
</body>
</html>
