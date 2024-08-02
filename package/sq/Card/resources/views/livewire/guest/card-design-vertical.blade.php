<div dir="rtl">
    {{-- Stop trying to control. --}}
    <div class="grid grid-cols-6 gap-x-6">
        <div class="bg-white bg-opacity-50 rounded-lg shadow-lg p-6 relative overflow-hidden col-span-4 row-span-6">
            @include('sqcard::livewire.guest.components.controlPanel')
        </div>
        <div class="col-span-2">
            <div class="grid grid-cols-2">
                <div class="bg-white max-h-[3.44in] h-[3.44in] w-[2.2in] block  rounded-xl relative  bg-cover bg-center bg-local bg-no-repeat"
                    :style="{ 'background-image': 'url(' + '/storage/' + attr.content.background + ')' }">
                    <div class="h-[3rem] border-t rounded-t-xl"
                        :style="{ 'background-color': attr.header.backgroundColor,
                        'color': attr.content.fontColor
                      }">
                        <div class="text-center" :style="{ 'font-size': attr.government.fontSize + 'px' }" x-text="attr.government.title">
                        </div>
                        <div class="text-center" :style="{ 'font-size': attr.ministry.fontSize + 'px' }"
                            x-text="attr.ministry.title">
                        </div>
                        <img :src="'/storage/' + attr.government.path" class="absolute rounded-full"
                            :style="{
                                top: attr.government.y + 'px',
                                left: attr.government.x + 'px',
                                height: attr.government.size + 'px'
                            }" />

                        <img :src="'/storage/' + attr.ministry.path" class="absolute rounded-full"
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
                        style="height: 201px;max-height: 201px">
                        <div class="px-2" x-html="details"></div>

                    </div>
                    <div class="h-4 border-b rounded-b-xl" style="margin-top:65px;"
                        :style="{ 'background-color': attr.header.backgroundColor }">
                    </div>
                    @include('sqcard::livewire.guest.components.contentFile')
                </div>
            </div>
        </div>
    </div>
</div>
