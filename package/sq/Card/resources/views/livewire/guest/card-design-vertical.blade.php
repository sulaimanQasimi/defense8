<div dir="rtl">

    @php
        $heightStyle = ' width: 2.16in; height: 3.41in;';
        $wholeSize = 'width: 2.16in;height: 6.82in;';
    @endphp
    {{-- Stop trying to control. --}}
    <div class="grid grid-cols-6 gap-x-6">
        <div class="bg-white bg-opacity-50 rounded-lg shadow-lg p-6 relative overflow-hidden col-span-4 row-span-6">
            @include('sqcard::livewire.guest.components.controlPanel')
        </div>
        <div class="col-span-2 relative" style="{{ $wholeSize }}">
            <div class="bg-white  block  rounded-xl  bg-cover bg-center bg-local bg-no-repeat"
                style=" {{ $heightStyle }}"
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
            <div class="bg-white block  rounded-xl bg-cover bg-center bg-local bg-no-repeat"
                style=" {{ $heightStyle }}"
                :style="{ 'background-image': 'url(' + '/storage/' + attr.backImage + ')' }">
                <div class="px-2" x-html="remark"></div>
            </div>
        </div>
    </div>
</div>
