@props(['card', 'details', 'cardInfo'])

<div>

    <div class="bg-white  h-[2.2in] w-[3.44in] block relative  bg-cover bg-center bg-local bg-no-repeat"
        style="background-image: url('{{ $card->ip_address }}/storage/{{ $card->attr['content']['background'] }}');">
        <div class=""
            style="background-color: {{ $card->attr['header']['backgroundColor'] }}; color:{{ $card->attr['content']['fontColor'] }}">
            <div class="text-center" style="font-size: {{ $card->attr['government']['fontSize'] }}px">
                {{ $card->attr['government']['title'] }}</div>

            <div class="text-center" style="font-size: {{ $card->attr['ministry']['fontSize'] }}px">
                {{ $card->attr['ministry']['title'] }}
            </div>

            <img src="{{ $card->ip_address }}/storage/{{ $card->attr['government']['path'] }}" class="h-12 absolute rounded-full"
                style="
                                top: {{ $card->attr['government']['y'] }}px;
                                left:{{ $card->attr['government']['x'] }}px;
                                height: {{ $card->attr['government']['size'] }}px" />
            <img src="{{ $card->ip_address }}/storage/{{ $card->attr['ministry']['path'] }}" class="h-12 absolute rounded-full"
                style="
                                top: {{ $card->attr['ministry']['y'] }}px;
                                left: {{ $card->attr['ministry']['x'] }}px;
                                height: {{ $card->attr['ministry']['size'] }}px;
                                " />
        </div>

        <div style="" class="bg-cover bg-center bg-local bg-no-repeat  h-[1.6in]">
            {{-- Diffrent Cards component --}}

            <div class="px-2">
                {{ $slot }}
            </div>
        </div>

        <div class="h-2" style="background-color: {{ $card->attr['header']['backgroundColor'] }}"></div>
        <div>
            <img src="{{ $cardInfo->image_path }}" class="h-16 absolute"
                style=" top: {{ $card->attr['profile']['y'] }}px;left:{{ $card->attr['profile']['x'] }}px;height:{{ $card->attr['profile']['size'] }}px " />
        </div>
        <div id="qrcode"
            style="position: absolute; top: {{ $card->attr['qrcode']['y'] }}px; left: {{ $card->attr['qrcode']['x'] }}px ;">
        </div>
    </div>
    <div class=" h-[2.1in] w-[3.44in] max-h-[2.13in] max-w-[3.44in]  block  relative bg-cover bg-center bg-local bg-no-repeat "
        style="background-image: url('{{ $card->ip_address }}/storage/{{ $card->attr['content']['background'] }}');">
        <div class="px-2 py-3">
            <div class="text-sm font-medium">{!! $remark !!}</div>
        </div>
    </div>
    @push('js')
        <script type="text/javascript">
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                width: {{ $card->attr['qrcode']['size'] }},
                height: {{ $card->attr['qrcode']['size'] }}
            });
            qrcode.makeCode("{{ $cardInfo->registare_no }}");
        </script>
    @endpush
</div>
