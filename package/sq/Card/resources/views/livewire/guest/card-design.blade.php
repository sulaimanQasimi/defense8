<div>
    {{-- Be like water. --}}
    <div>
        @once
            @push('css')
                <link rel="stylesheet" href="{{ asset('cards/loader.css') }}">
                </script>
                <script type="text/javascript" src="{{ asset('cards/qrcode/jquery.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('cards/qrcode/qrcode.js') }}"></script>
                <script type="text/javascript" src="{{ asset('cards/ckeditor/ckeditor.js') }}"></script>
                <script type="text/javascript" src="{{ asset('cards/JsBarcode/dist/JsBarcode.all.min.js') }}"></script>
            @endpush
        @endonce

        <div>

            {{-- Loading Component --}}
            @teleport('body')
                @include('sqcard::livewire.guest.components.loadingBanner')
            @endteleport
            {{-- File Upload Component --}}
            @include('sqcard::livewire.guest.components.fileUpload')
        </div>
        <div id="printable" class="pt-6 pb-3" wire:ignore x-data="{

            state: {
                show: true
            },
            card: @entangle('cardFrame').live,
            attr: @entangle('attr').live,
            details: @entangle('details').live,
            remark: @entangle('remark').live,
        }" x-init="let qrcode =
            new QRCode(document.getElementById('qrcode'), {
                width: attr.qrcode.size,
                height: attr.qrcode.size
            });
        qrcode.clear();
        qrcode.makeCode('123');" x-show="state.show"
            x-cloak>
            @includeWhen($cardFrame->dim === 'horizontal', 'sqcard::livewire.guest.card-design-horizontal')
            @includeWhen($cardFrame->dim == 'vertical', 'sqcard::livewire.guest.card-design-vertical')
        </div>
    </div>
    <script>
        // JsBarcode('#barcode', "G5-00000", {
        //     format: "CODE128",
        //     // background: "#000000/",
        //     width: {{ config('sq-card.barcode-size') }},
        //     height: 10,
        //     displayValue: false
        });
    </script>
    @script
        <script>
            // Remark Field

            CKEDITOR.replace('details').on('change', function(e) {
                $wire.set('details', this.getData());
            });

            CKEDITOR.replace('remark').on('change', function(e) {
                $wire.set('remark', this.getData());
            });

            CKEDITOR.replace('header').on('change', function(e) {
                $wire.set('attr.government.title', this.getData());
            });
        </script>
    @endscript
</div>
