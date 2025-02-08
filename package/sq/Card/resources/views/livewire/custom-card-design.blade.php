<div>
    @once
        @push('css')
            <link rel="stylesheet" href="{{ asset('cards/loader.css') }}">
            <script type="text/javascript" src="{{ asset('cards/qrcode/jquery.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('cards/qrcode/qrcode.js') }}"></script>
            <script type="text/javascript" src="{{ asset('cards/ckeditor/ckeditor.js') }}"></script>
            <script type="text/javascript" src="{{ asset('cards/JsBarcode/dist/JsBarcode.all.min.js') }}"></script>
            <style>
                body {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    /* Center align the dropdown and container */
                }

                .container {
                    padding: 0;
                    border: 2px solid black;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;
                    background-image: url("aa.png");
                }
            </style>
        @endpush
    @endonce

    {{-- Be like water. --}}
    {{-- Loading Component --}}
    @teleport('body')
    @include('sqcard::livewire.guest.components.loadingBanner')
    @endteleport
    <div id="printable" class="pt-6 pb-3" wire:ignore x-init="
    let qrcode =
    new QRCode(document.getElementById('qrcode'), {
        width: attr.qrcode.size,
        height: attr.qrcode.size
    });


qrcode.clear();
qrcode.makeCode('123');

JsBarcode('#barcode', 'G5-00000', {
    format: 'CODE128',
     {{-- background: '#000000/', --}}
    width: 1.2,
    height: 30,
    displayValue: true
});

" x-data="{
    card: @entangle('cardFrame').live,
    attr: @entangle('attr').live,
    details: @entangle('details').live,
    remark: @entangle('remark').live,
    isDragging: false,
    startX: 0,
    startY: 0,
    left: 0,
    top: 18,
    width: 400,
    scale: 0.5,
    requestId : null,
    state: {
        show: true
    },
    startDrag(event) {
        if (event.target.classList.contains('cursor-move')) {
            this.isDragging = true;
            this.startX = event.clientX - this.left;
            this.startY = event.clientY - this.top;
        }
    },
    stopDrag() {
        this.isDragging = false;
        cancelAnimationFrame(this.requestId)
    },
    drag(event) {
        if (this.isDragging) {
            this.requestId = requestAnmiationFrame(()=>{
                this.left = event.clientX - this.startX;
            this.top = event.clientY - this.startY;
            })

        }
    },
    scaleFactor: 0.6,
    isPortrait: true,
    containerWidth: '210mm',
    containerHeight: '297mm',
    updateSize(event) {
        const sizes = {
            A0: [841, 1189], A1: [594, 841], A2: [420, 594], A3: [297, 420], A4: [210, 297], A5: [148, 210], A6: [105, 148], A7: [74, 105], A8: [52, 74], A9: [37, 52], A10: [26, 37],
            B0: [1000, 1414], B1: [707, 1000], B2: [500, 707], B3: [353, 500], B4: [250, 353], B5: [176, 250], B6: [125, 176], B7: [88, 125], B8: [62, 88], B9: [44, 62], B10: [31, 44],
            C0: [917, 1297], C1: [648, 917], C2: [458, 648], C3: [324, 458], C4: [229, 324], C5: [162, 229], C6: [114, 162], C7: [81, 114], C8: [57, 81], C9: [40, 57], C10: [28, 40]
        };
        const [width, height] = sizes[event.target.value];
        this.containerWidth = width * this.scaleFactor;
        this.containerHeight = height * this.scaleFactor;
        this.isPortrait = true;
        this.attr.page.height = this.containerHeight;
        this.attr.page.width = this.containerWidth;
    },
    toggleOrientation() {
        const currentWidth = this.containerWidth;
        const currentHeight = this.containerHeight;
        this.containerWidth = currentHeight;
        this.containerHeight = currentWidth;
        this.attr.page.height = this.containerWidth;
        this.attr.page.width = this.containerHeight;
        this.isPortrait = !this.isPortrait;
    }
}" x-show="state.show" x-cloak>



        <div id="container" x-bind:style="{ width: attr.page.width+'mm', height: attr.page.height+'mm','background-image': 'url(' + '{{ $cardFrame->ip_address }}/storage/' + attr.content.background +')',
        'background-size': 'contain',

'background-repeat': 'no-repeat',
'transform':    'translate(' + left + 'px, ' + top + 'px) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scale(' + scale + ')'

}" class="bg-gray-200 ">

<div class="text-center" x-html="attr.government.title"></div>

{{-- Government Logo --}}
<img :src="'{{ $cardFrame->ip_address }}/storage/' + attr.government.path" class="absolute cursor-move" tabindex="0"
@keydown="(event) => { if (event.key === 'ArrowUp' && event.shiftKey) {
        attr.government.size += 1;
    } else if (event.key === 'ArrowDown' && event.shiftKey) {
        attr.government.size -= 1;
    }else
    if (event.key === 'ArrowUp') {
        attr.government.y -= 1;
    } else if (event.key === 'ArrowDown') {
        attr.government.y += 1;
    } else if (event.key === 'ArrowLeft') {
        attr.government.x -= 1;
    } else if (event.key === 'ArrowRight') {
        attr.government.x += 1;
    }
}"
:style="{ top: attr.government.y + 'px', left: attr.government.x + 'px', height: attr.government.size + 'px' }" />

{{-- Ministry Logo --}}
<img :src="'{{ $cardFrame->ip_address }}/storage/' + attr.ministry.path" class="absolute cursor-move" tabindex="0"
@keydown="(event) => {
if (event.key === 'ArrowUp' && event.shiftKey) {
        attr.ministry.size += 1;
    } else if (event.key === 'ArrowDown' && event.shiftKey) {
        attr.ministry.size -= 1;
    }else
if (event.key === 'ArrowUp') {
        attr.ministry.y -= 1;
    } else if (event.key === 'ArrowDown') {
        attr.ministry.y += 1;
    } else if (event.key === 'ArrowLeft') {
        attr.ministry.x -= 1;
    } else if (event.key === 'ArrowRight') {
        attr.ministry.x += 1;
    }
}"
:style="{ top: attr.ministry.y + 'px', left: attr.ministry.x + 'px', height: attr.ministry.size + 'px' }" />


<div dir="rtl" x-html="details"></div>

{{-- Profile Image --}}
<img src="{{ asset('logo.png') }}" class="absolute cursor-move" tabindex="0"
@keydown="(event) => {if (event.key === 'ArrowUp' && event.shiftKey) {
        attr.profile.size += 1;
    } else if (event.key === 'ArrowDown' && event.shiftKey) {
        attr.profile.size -= 1;
    }else
    if (event.key === 'ArrowUp') {
        attr.profile.y -= 1;
    } else if (event.key === 'ArrowDown') {
        attr.profile.y += 1;
    } else if (event.key === 'ArrowLeft') {
        attr.profile.x -= 1;
    } else if (event.key === 'ArrowRight') {
        attr.profile.x += 1;
    }
}"
:style="{ top: attr.profile.y + 'px', left: attr.profile.x + 'px', height: attr.profile.size + 'px' }" />

{{-- Signature --}}
<img :src="'/storage/' + attr.signature.path" class="absolute cursor-move" tabindex="0" style="z-index: 100"
@keydown="(event) => {if (event.key === 'ArrowUp' && event.shiftKey) {
        attr.signature.size += 1;
    } else if (event.key === 'ArrowDown' && event.shiftKey) {
        attr.signature.size -= 1;
    }else
    if (event.key === 'ArrowUp') {
        attr.signature.y -= 1;
    } else if (event.key === 'ArrowDown') {
        attr.signature.y += 1;
    } else if (event.key === 'ArrowLeft') {
        attr.signature.x -= 1;
    } else if (event.key === 'ArrowRight') {
        attr.signature.x += 1;
    }
}"
:style="{ top: attr.signature.y + 'px', left: attr.signature.x + 'px', height: attr.signature.size + 'px' }" />

{{-- QR Code --}}
<div id="qrcode" style="position: absolute;" x-ref="qrcode" class="cursor-move" tabindex="0"
@keydown="(event) => {
if (event.key === 'ArrowUp' && event.shiftKey) {
        attr.qrcode.size += 1;
    } else if (event.key === 'ArrowDown' && event.shiftKey) {
        attr.qrcode.size -= 1;
    }else
if (event.key === 'ArrowUp') {
        attr.qrcode.y -= 1;
    } else if (event.key === 'ArrowDown') {
        attr.qrcode.y += 1;
    } else if (event.key === 'ArrowLeft') {
        attr.qrcode.x -= 1;
    } else if (event.key === 'ArrowRight') {
        attr.qrcode.x += 1;
    }
}"
:style="{ top: attr.qrcode.y + 'px', left: attr.qrcode.x + 'px', height: attr.qrcode.size + 'px' }"></div>

{{-- Barcode --}}
<div style="position: absolute;" class="cursor-move" tabindex="0"
@keydown="(event) => {
 if (event.key === 'ArrowUp' && event.shiftKey) {
        attr.barCode.size += 1;
    } else if (event.key === 'ArrowDown' && event.shiftKey) {
        attr.barCode.size -= 1;
    }
 else if (event.key === 'ArrowUp') {
        attr.barCode.y -= 1;
    } else if (event.key === 'ArrowDown') {
        attr.barCode.y += 1;
    } else if (event.key === 'ArrowLeft') {
        attr.barCode.x -= 1;
    } else if (event.key === 'ArrowRight') {
        attr.barCode.x += 1;
    }
}"
:style="{ top: attr.barCode.y + 'px', left: attr.barCode.x + 'px' }">
<svg id="barcode"></svg>
</div>



        </div>


        <div x-bind:style="{ top: top + 'px', left: left + 'px' }" class="absolute z-40">
            <div x-bind:class="{'bg-blue-200 bg-opacity-50 rounded-lg shadow-lg p-6 overflow-hidden': true}"
                x-bind:style="{ 'width': width + 'px' }">
                <div class="scale-110 cursor-move absolute " @keydown="(event) => {
                        if (event.key === 'ArrowUp') {
                            top -= 1;
                        } else if (event.key === 'ArrowDown') {
                            top += 1;
                        } else if (event.key === 'ArrowLeft') {
                           right -= 1;
                        } else if (event.key === 'ArrowRight') {
                           right += 1;
                        }
                    }" style="top: -8px; right: -11px;">
                    <button type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 text-gray-500">
                            <path
                                d="M256 464a208 208 0 1 1 0-416 208 208 0 1 1 0 416zM256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM376.9 294.6c4.5-4.2 7.1-10.1 7.1-16.3c0-12.3-10-22.3-22.3-22.3L304 256l0-96c0-17.7-14.3-32-32-32l-32 0c-17.7 0-32 14.3-32 32l0 96-57.7 0C138 256 128 266 128 278.3c0 6.2 2.6 12.1 7.1 16.3l107.1 99.9c3.8 3.5 8.7 5.5 13.8 5.5s10.1-2 13.8-5.5l107.1-99.9z" />
                        </svg>
                    </button>
                </div>
                <div class="mb-5">
                    <div id="accordion-collapse" data-accordion="collapse">


                        {{-- #accordion-collapse-body-1 --}}
                        <h2 id="accordion-collapse-heading-1">
                            <button type="button"
                                class="flex items-center justify-between w-full p-1 font-medium rtl:text-right text-gray-500  "
                                data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                                aria-controls="accordion-collapse-body-1"> <svg data-accordion-icon
                                    class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                                <label class="block mb-2 text-sm font-medium text-sky-500">@lang('Card Header')</label>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-1" class="hidden p-2"
                            aria-labelledby="accordion-collapse-heading-1">
                            <textarea type="text" id="header" x-model="attr.government.title"></textarea>
                        </div>


                        {{-- #accordion-collapse-body-1 --}}
                        <h2 id="accordion-collapse-heading-4">
                            <button type="button"
                                class="flex items-center justify-between w-full p-1 font-medium rtl:text-right text-gray-500  "
                                data-accordion-target="#accordion-collapse-body-4" aria-expanded="true"
                                aria-controls="accordion-collapse-body-4"> <svg data-accordion-icon
                                    class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                                <label class="block mb-2 text-sm font-medium text-sky-500">@lang('Remark')</label>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-4" class="hidden p-2"
                            aria-labelledby="accordion-collapse-heading-4">
                            <div class="my-2 col-span-2">
                                <div dir="rtl">
                                    <div>{{ \Sq\Card\Support\PrintCardField::info_allowed_field() }}</div>

                                    @if ($cardFrame->type == \App\Support\Defense\Print\PrintTypeEnum::Employee)
                                        <div>{{ \Sq\Card\Support\PrintCardField::main_allowed_field() }}</div>
                                    @endif
                                    @if ($cardFrame->type == \App\Support\Defense\Print\PrintTypeEnum::EmployeeCar)
                                        <div>{{ \Sq\Card\Support\PrintCardField::vehical_allowed_field() }}</div>
                                    @endif
                                    @if ($cardFrame->type == \App\Support\Defense\Print\PrintTypeEnum::Gun)
                                        <div>{{ \Sq\Card\Support\PrintCardField::gun_allowed_field() }}</div>
                                    @endif
                                </div>
                                <label for="font-size" class="block mb-2 text-sm font-medium text-gray-900">
                                    @lang(':resource Details', ['resource' => '']) </label>
                                <textarea type="text" id="details" x-model="details" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                            </div>

                        </div>
                        {{-- #accordion-collapse-body-2 --}}
                        <h2 id="accordion-collapse-heading-2">
                            <button type="button"
                                class="flex items-center justify-between w-full p-1 font-medium rtl:text-right text-gray-500  "
                                data-accordion-target="#accordion-collapse-body-2" aria-expanded="true"
                                aria-controls="accordion-collapse-body-2">
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                                <label class="block mb-2 text-sm font-medium text-sky-500">@lang('Card Header')</label>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-2" class="hidden p-2"
                            aria-labelledby="accordion-collapse-heading-2">
                            {{-- QR Code Dimensions --}}
                            <x-sqcard::form.dimention-slider label="QR code Dimensions" xModel="attr.qrcode.x"
                                yModel="attr.qrcode.y" zModel="attr.qrcode.size" xMax="270" yMax="900" zMax="250" />

                            {{-- Bar Code Dimensions --}}
                            <x-sqcard::form.dimention-slider label="Bar code Dimensions" xModel="attr.barCode.x"
                                yModel="attr.barCode.y" zModel="attr.barCode.z" xMax="500" yMax="900" zMax="90" />

                            {{-- Image Dimensions --}}
                            <x-sqcard::form.dimention-slider label="Image Dimensions" xModel="attr.profile.x"
                                yModel="attr.profile.y" zModel="attr.profile.size" xMax="270" yMax="900" zMax="250" />

                            {{-- Minister Signature --}}
                            <x-sqcard::form.dimention-slider label="Minister Signature" xModel="attr.signature.x"
                                yModel="attr.signature.y" zModel="attr.signature.size" xMax="270" yMax="900"
                                zMax="250" />

                            {{-- Ministry Logo Dimensions --}}
                            <x-sqcard::form.dimention-slider label="Ministry Logo Dimensions" xModel="attr.ministry.x"
                                yModel="attr.ministry.y" zModel="attr.ministry.size" xMax="270" yMax="900" zMax="250" />

                            {{-- Government Logo Dimensions --}}
                            <x-sqcard::form.dimention-slider label="Government Logo Dimensions"
                                xModel="attr.government.x" yModel="attr.government.y" zModel="attr.government.size"
                                xMax="270" yMax="500" zMax="250" />
                        </div>
                        {{-- #accordion-collapse-body-1 --}}
                        <h2 id="accordion-collapse-heading-3">
                            <button type="button"
                                class="flex items-center justify-between w-full p-1 font-medium rtl:text-right text-gray-500  "
                                data-accordion-target="#accordion-collapse-body-3" aria-expanded="true"
                                aria-controls="accordion-collapse-body-3"> <svg data-accordion-icon
                                    class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                                <label
                                    class="block mb-2 text-sm font-medium text-sky-500">@lang('Paper Settings')</label>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-3" class="hidden p-2"
                            aria-labelledby="accordion-collapse-heading-3">

                            <x-sqcard::form.dimention-slider label="Panel Movement" xModel="top" yModel="left"
                                zModel="width" xMax="270" yMax="900" zMax="1000" />



                            <x-sqcard::form.dimention-slider label="Page Setup" xModel="scale" yModel="left"
                                zModel="width" xMax="270" yMax="900" zMax="1000" />

                            <select x-on:change="updateSize($event)"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                <option value="A0">A0 - 841 x 1189 mm</option>
                                <option value="A1">A1 - 594 x 841 mm</option>
                                <option value="A2">A2 - 420 x 594 mm</option>
                                <option value="A3">A3 - 297 x 420 mm</option>
                                <option value="A4">A4 - 210 x 297 mm</option>
                                <option value="A5">A5 - 148 x 210 mm</option>
                                <option value="A6">A6 - 105 x 148 mm</option>
                                <option value="A7">A7 - 74 x 105 mm</option>
                                <option value="A8">A8 - 52 x 74 mm</option>
                                <option value="A9">A9 - 37 x 52 mm</option>
                                <option value="A10">A10 - 26 x 37 mm</option>

                                <option value="B0">B0 - 1000 x 1414 mm</option>
                                <option value="B1">B1 - 707 x 1000 mm</option>
                                <option value="B2">B2 - 500 x 707 mm</option>
                                <option value="B3">B3 - 353 x 500 mm</option>
                                <option value="B4">B4 - 250 x 353 mm</option>
                                <option value="B5">B5 - 176 x 250 mm</option>
                                <option value="B6">B6 - 125 x 176 mm</option>
                                <option value="B7">B7 - 88 x 125 mm</option>
                                <option value="B8">B8 - 62 x 88 mm</option>
                                <option value="B9">B9 - 44 x 62 mm</option>
                                <option value="B10">B10 - 31 x 44 mm</option>

                                <option value="C0">C0 - 917 x 1297 mm</option>
                                <option value="C1">C1 - 648 x 917 mm</option>
                                <option value="C2">C2 - 458 x 648 mm</option>
                                <option value="C3">C3 - 324 x 458 mm</option>
                                <option value="C4">C4 - 229 x 324 mm</option>
                                <option value="C5">C5 - 162 x 229 mm</option>
                                <option value="C6">C6 - 114 x 162 mm</option>
                                <option value="C7">C7 - 81 x 114 mm</option>
                                <option value="C8">C8 - 57 x 81 mm</option>
                                <option value="C9">C9 - 40 x 57 mm</option>
                                <option value="C10">C10 - 28 x 40 mm</option>
                            </select>
                            <button x-on:click="toggleOrientation" type="button" x-bind:class="{
                                    'mt-4 font-medium rounded-sm text-sm px-6 py-3 text-center mb-2 transition-all duration-200': true,
                                    'text-white bg-blue-500 hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-md transform hover:scale-105': !isPortrait,
                                    'text-black bg-blue-200 hover:bg-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-md transform hover:scale-105': isPortrait
                                }">
                                @lang("Rotate")
                            </button>
                            <div class="grid">
                                {{-- Background of Card --}}
                                <div class="mb-2 flex items-center justify-center w-full">
                                    <label for="background-logo-file-upload"
                                        class="flex flex-col items-center justify-center w-full h-12 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-4 h-4 mb-2 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>

                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                @lang('Background of Card')
                                            </p>
                                        </div>
                                        <input id="background-logo-file-upload" type="file" class="hidden"
                                            wire:model.live="attr.content.background" />
                                    </label>
                                </div>


                                <div>
                                    <div class="mb-2 flex items-center justify-center w-full">
                                        <label for="gov-logo-file-upload"
                                            class="flex flex-col items-center justify-center w-full h-12 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-4 h-4 mb-2 text-gray-500 dark:text-gray-400"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    @lang('Government Logo')
                                                </p>
                                            </div>
                                            <input id="gov-logo-file-upload" type="file" class="hidden"
                                                wire:model.live="attr.government.path" />
                                        </label>
                                    </div>
                                </div>


                                <div>
                                    <div class="mb-2 flex items-center justify-center w-full">
                                        <label for="ministry-logo-file-upload"
                                            class="flex flex-col items-center justify-center w-full h-12 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-4 h-4 mb-2 text-gray-500 dark:text-gray-400"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    @lang('Ministry Logo')
                                                </p>
                                            </div>
                                            <input id="ministry-logo-file-upload" type="file"
                                                wire:model.live="attr.ministry.path" class="hidden" />
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-2 flex items-center justify-center w-full">
                                        <label for="card-back-logo-file-upload"
                                            class="flex flex-col items-center justify-center w-full h-12 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-4 h-4 mb-2 text-gray-500 dark:text-gray-400"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    @lang('Back of Card Background')
                                                </p>
                                            </div>
                                            <input id="card-back-logo-file-upload" type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>


                                <div>
                                    <div class="mb-2 flex items-center justify-center w-full">
                                        <label for="card-signature-file-upload"
                                            class="flex flex-col items-center justify-center w-full h-12 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-4 h-4 mb-2 text-gray-500 dark:text-gray-400"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    @lang('Minister Signature')
                                                </p>
                                            </div>
                                            <input id="card-signature-file-upload" wire:model.live="attr.signature.path"
                                                type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    // Remark Field

    CKEDITOR.replace('details').on('change', function (e) {
        $wire.set('details', this.getData());
    });

    // CKEDITOR.replace('remark').on('change', function(e) {
    //     $wire.set('remark', this.getData());
    // });

    CKEDITOR.replace('header').on('change', function (e) {
        $wire.set('attr.government.title', this.getData());
    });
</script>
@endscript
</div>
