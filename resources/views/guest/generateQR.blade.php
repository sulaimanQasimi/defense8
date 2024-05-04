<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <script type="text/javascript" src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    <style>

        @page { size: A4 }
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
        .center{
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

    table {
        margin-left: 10px;
        width: 100%;
    }

    th, td {
        border-bottom: 1px solid #ccc;
        padding: 2px;
        text-align: right;
    }
    </style>
</head>

<body dir="rtl" >
    <div class="page">
    <div class="card">
        <table>
            <tr>
                <th>@lang("Name")</th>
                <th>{{$guest->name}}</th>
            </tr>
            <tr>
                <td>@lang("Invited By")</td>
                <td>{{$guest->host->name}}</td>
            </tr>
            <tr>
                <td>@lang("Address")</td>
                <td>{{$guest->address}}</td>
            </tr>
			<tr>
			<td colspan="2">{{ $url }}</td>
			</tr>
        </table>

        <div id="qrcode" style="width:100px; height:100px;display: block; margin-top:30px; margin-left: 60px;"></div>

    </div>
    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 100,
            height: 100
        });
        qrcode.makeCode("{{ $url }}");
    </script>
</body>

</html>
