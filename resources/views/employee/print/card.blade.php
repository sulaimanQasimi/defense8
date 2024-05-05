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

<body class="persian-font antialiased">
    {{-- Print Context --}}
    <div>

        <div class="bg-white  h-[2.13in] w-[3.42in] block relative ">
            <div class=" border-t " style="background-color: {{ $card->color }}">
                <div class="text-center" style="font-size: {{ $card->gov_name_font_size }}px">{{ $card->gov_name }}
                </div>
                <div class="text-center" style="font-size: {{ $card->ministry_name_font_size }}px">
                    {{ $card->ministry_name }}</div>
                <img src="/storage/{{ $card->gov_logo }}" class="h-12 absolute rounded-full"
                    style="top: {{ $card->gov_logo_y }}px; left: {{ $card->gov_logo_x }}px" />
                <img src="/storage/{{ $card->ministry_logo }}" class="h-12 absolute rounded-full"
                    style="top: {{ $card->ministry_logo_y }}px; left: {{ $card->ministry_logo_x }}px" />
            </div>

            <div style="font-size: {{ $card->info_font_size }}px; background-image: url('/storage/{{ $card->background_logo }}');color:{{ $card->font_color }}"
                class="bg-cover bg-center bg-local bg-no-repeat ">
                {{-- Diffrent Cards component --}}
                <div class="px-2">

                    @includeWhen(
                        $card->type == \App\Support\Defense\Print\PrintTypeEnum::Employee,
                        'employee.print.employee')

                    @includeWhen(
                        $card->type == \App\Support\Defense\Print\PrintTypeEnum::Gun,
                        'employee.print.gun')
                    @includeWhen(
                        $card->type == \App\Support\Defense\Print\PrintTypeEnum::EmployeeCar,
                        'employee.print.employeeCar')

                    @includeWhen(
                        $card->type == \App\Support\Defense\Print\PrintTypeEnum::BlackMirrorCar,
                        'employee.print.blackMirrorCar')

                    @includeWhen(
                        $card->type == \App\Support\Defense\Print\PrintTypeEnum::ArmorCar,
                        'employee.print.ArmorCar')
                </div>
            </div>
            <div class="h-3 border-b " style="background-color: {{ $card->color }}"></div>
            <div>
                <img src="{{ $cardInfo->image_path }}" class="h-16 absolute"
                    style=" top: {{ $card->profile_logo_y }}px;left: {{ $card->profile_logo_x }}px;" />
            </div>
            <div id="qrcode"
                style="width:30px; height:30px;position: absolute;top: {{ $card->qr_code_logo_y }}px; left: {{ $card->qr_code_logo_x }}px;">
            </div>
        </div>

        <div class=" h-[2.13in] w-[3.5in] max-h-[2.13in] max-w-[3.5in]  block rounded-xl relative bg-contain bg-center bg-local bg-no-repeat "
            style="background-image: url('/storage/{{ $card->background_logo }}');color:{{ $card->font_color }}">
            <div class="h-[1.75rem]" style="background-color: {{ $card->color }}"></div>
            <div class="px-2 py-3">
                <div class="text-sm font-medium">{!! $card->remark !!}</div>
            </div>
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
