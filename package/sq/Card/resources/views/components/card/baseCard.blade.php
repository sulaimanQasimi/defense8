@props(['card', 'field', 'cardInfo', 'heightStyle', 'wholeSize', 'barcode' => true,'v'=>true])
<div class="relative" style="{{ $wholeSize }}">
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
    <div class="bg-white block bg-cover bg-center bg-local bg-no-repeat"
        style="background-image: url('{{ $card->ip_address }}/storage/{{ $card->attr['content']['background'] }}'); {{ $heightStyle }}">
        <div class="text-center">
            {!! $field->header !!}
        </div>
        <img src="{{ $card->ip_address }}/storage/{{ $card->attr['government']['path'] }}" class="h-12 absolute"
            style="
                                top: {{ $card->attr['government']['y'] }}px;
                                left:{{ $card->attr['government']['x'] }}px;
                                height: {{ $card->attr['government']['size'] }}px" />
        <img src="{{ $card->ip_address }}/storage/{{ $card->attr['ministry']['path'] }}" class="h-12 absolute"
            style="
                                top: {{ $card->attr['ministry']['y'] }}px;
                                left: {{ $card->attr['ministry']['x'] }}px;
                                height: {{ $card->attr['ministry']['size'] }}px;" />
        <img src="{{ $card->ip_address }}/storage/{{ $card->attr['signature']['path'] }}" class="h-12 absolute"
            style="z-index: 100;
                                                                                     top: {{ $card->attr['signature']['y'] }}px;
                                                                                     left: {{ $card->attr['signature']['x'] }}px;
                                                                                     height: {{ $card->attr['signature']['size'] }}px;
                                                                                     " />
        <div class="px-2">
            {!! $field->details !!}
        </div>
        <img src="{{ $cardInfo->image_path }}" class="h-16 absolute"
            style=" top: {{ $card->attr['profile']['y'] }}px;left:{{ $card->attr['profile']['x'] }}px;height:{{ $card->attr['profile']['size'] }}px " />

        <div id="{{ $attributes->get('id') }}"
            style="position: absolute; top: {{ $card->attr['qrcode']['y'] }}px; left: {{ $card->attr['qrcode']['x'] }}px ;">
        </div>

        @if ($barcode)
            <div
                style="position: absolute; top: {{ $card->attr['barCode']['y'] }}px;left:{{ $card->attr['barCode']['x'] }}px;">
                <svg id="{{ $attributes->get('id') }}-barcode"></svg>
            </div>
        @endif

    </div>

    <div class="block  bg-cover bg-center bg-local bg-no-repeat"
        style="background-image: url('{{ $card->ip_address }}/storage/{{ $card->attr['backImage'] }}');
    {{ $heightStyle }}">
        <div class="px-2 py-3">
            <div class="text-sm font-medium">
                {!! $field->remark !!}</div>
        </div>
    </div>
</div>
@push('js')
    <script type="text/javascript">
        @if ($barcode)
            JsBarcode('#{{ $attributes->get('id') }}-barcode', "{{ $cardInfo->registare_no }}", {
                format: "CODE128",
                // background: "#000000/",
                width: 0.6,
                height: 13,
                displayValue: false
            });
        @endif
        var qrcode = new QRCode(document.getElementById("{{ $attributes->get('id') }}"), {
            width: {{ $card->attr['qrcode']['size'] }},
            height: {{ $card->attr['qrcode']['size'] }}
        });
        qrcode.makeCode("{{ $cardInfo->registare_no }}");
    </script>
@endpush
</div>
