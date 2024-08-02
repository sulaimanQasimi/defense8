<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} " dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} || @lang("Print Card Frame")</title>
    @vite(['resources/js/app.js'])
    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
    <style>
        body{
            margin: 0;
            padding: 0;
        }
        @page {
            height: 3.34in;
            width: 2.13in;
        }

        @media print {
            .print-none {
                display: none;
            }
        }
    </style>
    <script src="{{ asset('alpine.min.js') }}"></script>
</head>

<body class="persian-font antialiased">

    {{-- Print Context --}}
    <x-sqcard::card.horizontal :card="$card" :cardInfo="$cardInfo" :id="'guest-' . $cardInfo->id">
        {!! $details !!}
    </x-sqcard::card.horizontal>

    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 100,
            height: 100
        });
        qrcode.makeCode("{{ $cardInfo->registare_no }}");
    </script>
</body>

</html>
