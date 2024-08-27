<div dir="rtl">
    <div class="grid md:grid-cols-6 sm:grid-cols-1 gap-x-6 gap-y-3">
        <div class="bg-blue-400 bg-opacity-50 rounded-lg shadow-lg p-6 relative overflow-hidden row-span-2 col-span-3">
            @include('sqcard::livewire.guest.components.controlPanel')
        </div>

        <div class="col-span-3 flex justify-items-end">

            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-7">
                <div class="bg-white h-[2.2in] w-[3.44in] block  rounded-xl relative  bg-cover bg-center bg-local bg-no-repeat"
                    :style="{
                        'background-image': 'url('+'{{ $cardFrame->ip_address }}/storage/' + attr.content.background + ')'
                    }">
                    <div class=" border-t rounded-t-xl" :style="{ 'background-color': attr.header.backgroundColor }">
                        <div class="text-center"
                            :style="{ 'font-size': attr.government.fontSize + 'px', color: attr.content.fontColor }"
                            x-text="attr.government.title">
                        </div>
                        <div class="text-center"
                            :style="{ 'font-size': attr.ministry.fontSize + 'px', color: attr.content.fontColor }"
                            x-text="attr.ministry.title">
                        </div>
                        <img :src="'{{ $cardFrame->ip_address }}/storage/' + attr.government.path"
                            class="absolute rounded-full"
                            :style="{
                                top: attr.government.y + 'px',
                                left: attr.government.x + 'px',
                                height: attr.government.size + 'px'
                            }" />

                        <img :src="'{{ $cardFrame->ip_address }}/storage/' + attr.ministry.path"
                            class="absolute rounded-full"
                            :style="{
                                top: attr.ministry.y + 'px',
                                left: attr.ministry.x + 'px',
                                height: attr.ministry.size +
                                    'px'
                            }" />
                    </div>
                    <div :style="{
                        // 'background-color': color,
                        // 'background-image': 'url(\'/storage/' + background_path + '\')'
                    }"
                        class="bg-cover bg-center bg-local bg-no-repeat h-{201 px} max-h-{201 px}"
                        style="height: 85px;max-height:85px">
                        <div class="px-2" x-html="details"></div>

                    </div>
                    <div class="h-4 border-b rounded-b-xl" style="margin-top:65px;"
                        :style="{ 'background-color': attr.header.backgroundColor }">
                    </div>
                    @include('sqcard::livewire.guest.components.contentFile')
                </div>
                <div class="bg-white h-[2.2in] w-[3.44in] block  rounded-xl relative  bg-cover bg-center bg-local bg-no-repeat"
                    :style="{ 'background-image': 'url(' + '/storage/' + attr.content.background + ')' }">

                    <div class="px-2" x-html="remark"></div>
                </div>
            </div>
        </div>
    </div>
</div>
