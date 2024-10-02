@props(['card', 'details', 'cardInfo'])
@php
    $heightStyle = 'height: 2.16in; width: 3.41in;';
    $wholeSize = 'height: 4.32in;width: 3.41in;';
@endphp
<div class="relative" style="{{ $wholeSize }}">
    <div class="bg-white block bg-cover bg-center bg-local bg-no-repeat"
        style="background-image: url('{{ $card->ip_address }}/storage/{{ $card->attr['content']['background'] }}');{{ $heightStyle }}">
        <div class="text-center">
            {!! $card->attr['government']['title'] !!}</div>
        <img src="{{ $card->ip_address }}/storage/{{ $card->attr['government']['path'] }}"
            class="h-12 absolute"
            style="
                                top: {{ $card->attr['government']['y'] }}px;
                                left:{{ $card->attr['government']['x'] }}px;
                                height: {{ $card->attr['government']['size'] }}px" />
        <img src="{{ $card->ip_address }}/storage/{{ $card->attr['ministry']['path'] }}"
            class="h-12 absolute"
            style="
                                top: {{ $card->attr['ministry']['y'] }}px;
                                left: {{ $card->attr['ministry']['x'] }}px;
                                height: {{ $card->attr['ministry']['size'] }}px;
                                " />
        {{-- Diffrent Cards component --}}
        <div class="px-2">
            {{ $slot }}
        </div>
        <img src="{{ $cardInfo->image_path }}" class="h-16 absolute"
            style=" top: {{ $card->attr['profile']['y'] }}px;left:{{ $card->attr['profile']['x'] }}px;height:{{ $card->attr['profile']['size'] }}px " />

        <div id="qrcode"
            style="position: absolute; top: {{ $card->attr['qrcode']['y'] }}px; left: {{ $card->attr['qrcode']['x'] }}px ;">
        </div>


        <img id="barcode"
            style="position: absolute; top: {{ $card->attr['barCode']['y'] }}px;left:{{ $card->attr['barCode']['x'] }}px;rotate:{{ $card->attr['barCode']['z'] }}deg " />

    </div>


    <div class="block bg-cover bg-center bg-local bg-no-repeat "
        style="background-image: url('{{ $card->ip_address }}/storage/{{ $card->attr['backImage'] }}');
    {{ $heightStyle }}">
        <div class="px-2 py-3">
            <div class="text-sm font-medium">{!! $remark !!}</div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">
            JsBarcode('#barcode', "{{ $cardInfo->registare_no }}", {
                format: "CODE128",
                // background: "#000000/",
                width: 2.5,
                height: 40,
                displayValue: false
            });
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                width: {{ $card->attr['qrcode']['size'] }},
                height: {{ $card->attr['qrcode']['size'] }}
            });
            qrcode.makeCode("{{ $cardInfo->registare_no }}");
        </script>
    @endpush
</div>
