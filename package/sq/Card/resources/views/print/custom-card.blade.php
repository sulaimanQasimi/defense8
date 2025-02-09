<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Card Test Page</title>

    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('cards/font.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('build/assets/app.css') }}" rel="stylesheet" />
    <script src="{{ asset('alpine.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cards/JsBarcode/dist/JsBarcode.all.min.js') }}"></script>
    <style>
        @media print {
            body * {
                visibility: hidden;
                margin: 0;
                padding: 0;
            }

            #printable,
            #printable * {
                visibility: visible;
            }

            #printable {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        @page {
            size:
                {{ $card?->attr['page']['width'] }}
                mm
                {{ $card?->attr['page']['height'] }}
                mm;
            margin: 0;
        }
    </style>
</head>

<body>
    <div id="printable"
        style="width: {{ $card?->attr['page']['width'] }}mm; height: {{ $card?->attr['page']['height'] }}mm; background-image: url('{{ $card->ip_address }}/storage/{{ $card?->attr['content']['background'] }}'); background-size: contain; background-repeat: no-repeat;"
        class="bg-gray-200">
        <div class="text-center">{!! $card?->attr['government']['title'] !!}</div>
        {{-- Government Logo --}}
        <img src="{{ $card->ip_address }}/storage/{{ $card?->attr['government']['path'] }}" class="absolute cursor-move"
            tabindex="0"
            style="top: {{ $card?->attr['government']['y'] }}px; left: {{ $card?->attr['government']['x'] }}px; height: {{ $card?->attr['government']['size'] }}px;" />
        {{-- Ministry Logo --}}
        <img src="{{ $card->ip_address }}/storage/{{ $card?->attr['ministry']['path'] }}" class="absolute cursor-move"
            tabindex="0"
            style="top: {{ $card?->attr['ministry']['y'] }}px; left: {{ $card?->attr['ministry']['x'] }}px; height: {{ $card?->attr['ministry']['size'] }}px;" />
        <div dir="rtl">{!! $field->details !!}</div>
        {{-- Profile Image --}}
        <img src="{{ asset('logo.png') }}" class="absolute cursor-move" tabindex="0"
            style="top: {{ $card?->attr['profile']['y'] }}px; left: {{ $card?->attr['profile']['x'] }}px; height: {{ $card?->attr['profile']['size'] }}px;" />
        {{-- Signature --}}
        <img src="/storage/{{ $card?->attr['signature']['path'] }}" class="absolute cursor-move" tabindex="0"
            style="z-index: 100; top: {{ $card?->attr['signature']['y'] }}px; left: {{ $card?->attr['signature']['x'] }}px; height: {{ $card?->attr['signature']['size'] }}px;" />
        {{-- QR Code --}}
        <div id="qrcode"
            style="position: absolute; top: {{ $card?->attr['qrcode']['y'] }}px; left: {{ $card?->attr['qrcode']['x'] }}px; height: {{ $card?->attr['qrcode']['size'] }}px;"
            class="cursor-move" tabindex="0"></div>
        {{-- Barcode --}}
        <div style="position: absolute; top: {{ $card?->attr['barCode']['y'] }}px; left: {{ $card?->attr['barCode']['x'] }}px;"
            class="cursor-move" tabindex="0">
            <svg id="barcode"></svg>
        </div>
    </div>

    <div dir="rtl" class="printable bg-white"
        style="width: {{ $card?->attr['page']['width'] }}mm; height: {{ $card?->attr['page']['height'] }}mm; max-width: {{ $card?->attr['page']['width'] }}mm; max-height: {{ $card?->attr['page']['height'] }}mm;">
        <div>{!! $field->remark !!}</div>
    </div>
    <script type="text/javascript" src="{{ asset('cards/qrcode/qrcode.js') }}"></script>
    <script>
        JsBarcode("#barcode", "G2-000000", {
            format: "CODE128",
            // background: "#000000/",
            width: 1.2,
            height: 30,
            displayValue: true
        });

        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: {{ $card?->attr['qrcode']['size'] }},
            height: {{ $card?->attr['qrcode']['size'] }}
        });
        qrcode.makeCode("G2-000000");
    </script>

</body>

</html>
