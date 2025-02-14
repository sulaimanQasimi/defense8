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
            body {
                margin: 0;
                padding: 0;
            }

            .printable {
                left: 0;
                top: 0;
            }
        }

        @page {
            size:
                {{ $attr['page']['width'] }}
                mm
                {{ $attr['page']['height'] }}
                mm;
            margin: 0;
        }
    </style>
</head>

<body>
    <div id="printable"
        style="width: {{ $attr['page']['width'] }}mm; height: {{ $attr['page']['height'] }}mm; background-image: url('{{ $cardFrame->ip_address }}/storage/{{ $attr['content']['background'] }}'); background-size: contain; background-repeat: no-repeat;"
        class="bg-gray-200">
        <div class="text-center">{!! $attr['government']['title'] !!}</div>
        {{-- Government Logo --}}
        <img src="{{ $cardFrame->ip_address }}/storage/{{ $attr['government']['path'] }}" class="absolute cursor-move"
            tabindex="0"
            style="top: {{ $attr['government']['y'] }}px; left: {{ $attr['government']['x'] }}px; height: {{ $attr['government']['size'] }}px;" />
        {{-- Ministry Logo --}}
        <img src="{{ $cardFrame->ip_address }}/storage/{{ $attr['ministry']['path'] }}" class="absolute cursor-move"
            tabindex="0"
            style="top: {{ $attr['ministry']['y'] }}px; left: {{ $attr['ministry']['x'] }}px; height: {{ $attr['ministry']['size'] }}px;" />
        <div dir="rtl">{!! $details !!}</div>
        {{-- Profile Image --}}
        <img src="{{ asset('logo.png') }}" class="absolute cursor-move" tabindex="0"
            style="top: {{ $attr['profile']['y'] }}px; left: {{ $attr['profile']['x'] }}px; height: {{ $attr['profile']['size'] }}px;" />
        {{-- Signature --}}
        <img src="/storage/{{ $attr['signature']['path'] }}" class="absolute cursor-move" tabindex="0"
            style="z-index: 100; top: {{ $attr['signature']['y'] }}px; left: {{ $attr['signature']['x'] }}px; height: {{ $attr['signature']['size'] }}px;" />
        {{-- QR Code --}}
        <div id="qrcode"
            style="position: absolute; top: {{ $attr['qrcode']['y'] }}px; left: {{ $attr['qrcode']['x'] }}px; height: {{ $attr['qrcode']['size'] }}px;"
            class="cursor-move" tabindex="0"></div>
        {{-- Barcode --}}
        <div style="position: absolute; top: {{ $attr['barCode']['y'] }}px; left: {{ $attr['barCode']['x'] }}px;"
            class="cursor-move" tabindex="0">
            <svg id="barcode"></svg>
        </div>
    </div>

    <div dir="rtl" class="printable bg-white"
        style="width: {{ $attr['page']['width'] }}mm; height: {{ $attr['page']['height'] }}mm; max-width: {{ $attr['page']['width'] }}mm; max-height: {{ $attr['page']['height'] }}mm;">
        <div>{!! $remark !!}</div>
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
            width: {{ $attr['qrcode']['size'] }},
            height: {{ $attr['qrcode']['size'] }}
        });
        qrcode.makeCode("G2-000000");
    </script>

</body>

</html>
