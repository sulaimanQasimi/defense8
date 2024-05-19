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
        .row-style {
            vertical-align: middle !important;
            text-align: center;
        }

        .row-styles {
            transform: rotate(90deg);
            font-size: 10px;
        }

        .width {
            width: 10px !important;
        }

        .center {
            text-align: center;
        }

        .page {
            width: 100%;
            height: 600px;
            /* border-radius: 0 0 3px 3px; */
            /* background-color: #2a8a42; */
            max-width: 220px;
        }

        .card {
            display: flex;
            border: 1px solid #ccc;
            width: 300px;
            height: 200px;
            padding: 10px;
        }

        img {
            max-width: 100px;
            max-height: 100px;
        }

        /* table {
            margin-left: 10px;
            width: 100%;
        } */

        th,
        td {
            border-bottom: 1px solid #ccc;
            padding: 2px;
            text-align: right;
        }
    </style>
</head>

<body dir="rtl">
    {{-- <div class="page">
    <div class="card">
        <table>

            <tr>
                <th>@lang("Name")</th>
                <th>{{$guest->name}}</th>
            </tr>

            <tr>
                <td>@lang("Invited By")</td>
                <td>{{$guest->host->department?->fa_name}}</td>
            </tr>
            <tr>
                <td>@lang("Address")</td>
                <td>{{$guest->address}}</td>
            </tr>
			<tr>
			<td colspan="2">{{ $url }}</td>
			</tr>
        </table>


    </div> --}}
    <div class="p-1">
        <div class="h-[200px] w-[300px] border-gray-300 border-2 border-dashed relative text-sm">
            <div class="text-center pb-3 border-gray-300 border-b-2  ">@lang("Temporary Guest QR Code")</div>

            <div class="grid grid-col-2">
                <div class="col-span-1">
                    <table>

                        <tr>
                            <td>@lang('Name'): </td>
                            <td>{{ $guest->name }}</td>
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

                    </table>
                </div>
                <div>
                    <div id="qrcode" class="absolute bottom-3"></div>
                    <div class=" absolute bottom-16 left-0 rotate-90"> {{ $url }}</div>
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
