<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} " dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/js/app.js'])
    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
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

<body class="font-sans antialiased">
    <div class="flex justify-end" x-data="{
        back: false
    }" x-cloak>
        <button class="print-none" x-on:click="back=true"  x-show="!back">Back</button>
        <button class="print-none" x-on:click="back=false"  x-show="back">Front</button>
        <div x-show="!back" class="bg-white  h-[2.13in] w-[3.34in] block  rounded-xl relative ">
            <div class=" border-t rounded-t-xl" style="background-color: {{ $card->color }}">
                <div class="text-center" style="font-size: {{ $card->gov_name_font_size }}px">{{ $card->gov_name }}
                </div>
                <div class="text-center" style="font-size: {{ $card->ministry_name_font_size }}px">
                    {{ $card->ministry_name }}</div>
                <img src="/storage/{{ $card->gov_logo }}" class="h-12 absolute rounded-full"
                    style="top: {{ $card->gov_logo_y }}px; left: {{ $card->gov_logo_x }}px" />
                <img src="/storage/{{ $card->ministry_logo }}" class="h-12 absolute rounded-full"
                    style="top: {{ $card->ministry_logo_y }}px; left: {{ $card->ministry_logo_x }}px" />
            </div>

            <div style="font-size: {{ $card->info_font_size }}px; background-image: url('/storage/{{ $card->background_logo }}')"
                class="px-2 bg-contain bg-center bg-local bg-no-repeat ">
                @include('employee.print.employee')
            </div>
            <div class="h-3 border-b rounded-b-xl" style="background-color: {{ $card->color }}"></div>
            <div>
                <img src="{{ $cardInfo->image_path }}" class="h-16 absolute"
                    style=" top: {{ $card->profile_logo_y }}px;left: {{ $card->profile_logo_x }}px;" />
            </div>
            <div id="qrcode"
                style="width:30px; height:30px;position: absolute;top: {{ $card->qr_code_logo_y }}px; left: {{ $card->qr_code_logo_x }}px;">
            </div>
        </div>

        <div x-show="back" class="bg-white h-[2.13in] w-[3.34in] block  rounded-xl relative ">
            <div class="h-20" style="background-color: {{$card->color}}"></div>
            <div class="mx-3 my-2 text-sm font-medium" >{{$card->remark}}</div>
            <div class="h-3 border-b rounded-b-xl" style="background-color: color }"></div>
        </div>

    </div>

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
