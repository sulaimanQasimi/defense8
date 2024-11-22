@php
    $heightStyle = ' height: 2.4in; width: 3.41in;';
    $wholeSize = 'height: 4.8in;width: 3.41in;';
@endphp
<div dir="rtl">
    <div class="grid md:grid-cols-6 sm:grid-cols-1 gap-x-6 gap-y-3">
        <div class="bg-blue-400 bg-opacity-50 rounded-lg shadow-lg p-6 relative overflow-hidden row-span-2 col-span-3">
            @include('sqcard::livewire.guest.components.controlPanel')
        </div>
        <div class=" relative" style="{{ $wholeSize }}">
            <div class="bg-white block bg-cover bg-center bg-local bg-no-repeat"
            style="{{ $heightStyle }}"
                :style="{
                    'background-image': 'url(' + '{{ $cardFrame->ip_address }}/storage/' + attr.content.background +
                        ')'
                }">

                <div class="text-center" x-html="attr.government.title"></div>

                {{-- Government Logo --}}
                <img :src="'{{ $cardFrame->ip_address }}/storage/' + attr.government.path" class="absolute"
                    :style="{
                        top: attr.government.y + 'px',
                        left: attr.government.x + 'px',
                        height: attr.government.size + 'px'
                    }" />

                {{-- Ministry Logo --}}
                <img :src="'{{ $cardFrame->ip_address }}/storage/' + attr.ministry.path" class="absolute"
                    :style="{
                        top: attr.ministry.y + 'px',
                        left: attr.ministry.x + 'px',
                        height: attr.ministry.size +
                            'px'
                    }" />
                <div class="px-2" x-html="details"></div>
                @include('sqcard::livewire.guest.components.contentFile')
            </div>
            <div class="bg-white block bg-cover bg-center bg-local bg-no-repeat" style="{{ $heightStyle }}"
                :style="{ 'background-image': 'url(' + '/storage/' + attr.backImage + ')' }">
                <div class="px-2" x-html="remark"></div>
            </div>

        </div>
    </div>
</div>
