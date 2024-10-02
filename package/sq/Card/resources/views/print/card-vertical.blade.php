<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} || @lang('Print Card Frame')</title>
    @vite(['resources/js/app.js'])
    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('cards/font.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('build/assets/app.css') }}" rel="stylesheet" />

    <style>
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
    <x-sqcard::card.vertical :card="$card" :cardInfo="$cardInfo" :id="'guest-' . $cardInfo->id">
        {!! $details !!}
        <x-slot:remark>
            {!! $remark !!}
        </x-slot:remark>
    </x-sqcard::card.vertical>
    <script type="text/javascript" src="{{ asset('cards/qrcode/qrcode.js') }}"></script>
    @stack('js')
</body>

</html>
