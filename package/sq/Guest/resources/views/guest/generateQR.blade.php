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

        /* table {
            margin-left: 10px;
            width: 100%;
        } */

        th,
        td {
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
            <div class="text-center pb-3 border-gray-300 border-b-2  " style="font-family: 'persian-font'; ">@lang("Temporary Guest QR Code")</div>

            <div class="grid grid-col-2">
                <div class="col-span-1">
                    <table class="text-xs">

                        <tr>
                            <td style="font-family: 'persian-font'; ">@lang('Name'): </td>
                            <td style="font-family: 'persian-font'; ">{{ $guest->name }}</td>
                        </tr>

                        <tr>
                            <td>@lang('Department'):</td>
                            <td>{{ $guest->host->department?->fa_name }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Invited By'):</td>
                            <td>{{ $guest->host->head_name }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Address'):</td>
                            <td>{{ $guest->address }}</td>
                        </tr>
                        <tr>
                            <td>@lang('نوع واسطه'):</td>
                            <td>{{ $guest->vehical_type }}</td>
                        </tr>
                        <tr>
                            <td>@lang('رنگ واسطه'):</td>
                            <td>{{ $guest->vehical_color }}</td>
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
