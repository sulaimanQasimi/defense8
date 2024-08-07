<div class="grid grid-cols-2 gap-x-2 gap-y-3">

    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 ">@lang('Government Name')</label>
        <input type="text" x-model="attr.government.title"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900">@lang('Ministry Name')</label>

        <input type="text" x-model="attr.ministry.title"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
    </div>
    <div class="my-2">
        <label for="font-size" class="block mb-2 text-sm font-medium text-gray-900">
            @lang('Government Font Size')
        </label>
        <label class="slider">
            <input type="range" class="level" x-model="attr.government.fontSize" max="15">
        </label>
    </div>
    <div class="my-2">
        <label for="font-size" class="block mb-2 text-sm font-medium text-gray-900">
            @lang('Ministry Font Size')
        </label>
        <label class="slider">
            <input type="range" class="level" x-model="attr.ministry.fontSize" max="15">
        </label>
    </div>
    {{-- Card Info Text Size --}}
    <input type="color" x-model="attr.header.backgroundColor" />
    <input type="color" x-model="attr.content.fontColor" />

    {{-- QR Code Dimentions --}}

    <x-sqcard::form.dimention-slider label="QR code Dimentions" xModel="attr.qrcode.x" yModel="attr.qrcode.y"
        zModel="attr.qrcode.size" xMax="270" yMax="270" zMax="250" />

    {{-- Image Dimentions --}}
    <x-sqcard::form.dimention-slider label="Image Dimentions" xModel="attr.profile.x" yModel="attr.profile.y"
        zModel="attr.profile.size" xMax="270" yMax="270" zMax="250" />

    {{-- Ministry Logo Dimentions --}}
    <x-sqcard::form.dimention-slider label="Ministry Logo Dimentions" xModel="attr.ministry.x" yModel="attr.ministry.y"
        zModel="attr.ministry.size" xMax="270" yMax="270" zMax="250" />

    {{-- Ministry Logo Dimentions --}}
    <x-sqcard::form.dimention-slider label="Government Logo Dimentions" xModel="attr.government.x"
        yModel="attr.government.y" zModel="attr.government.size" xMax="270" yMax="270" zMax="250" />

    <div class="my-2 col-span-2">
        <div>
            <div>{{ \Sq\Card\Support\PrintCardField::info_allowed_field() }}</div>
            <div>{{ \Sq\Card\Support\PrintCardField::main_allowed_field() }}</div>
            <div>{{ \Sq\Card\Support\PrintCardField::gun_allowed_field() }}</div>
            @if ($cardFrame->type == \App\Support\Defense\Print\PrintTypeEnum::EmployeeCar)
                <div>{{ \Sq\Card\Support\PrintCardField::vehical_allowed_field() }}</div>
            @endif
        </div>
        <label for="font-size" class="block mb-2 text-sm font-medium text-gray-900">
            @lang(':resource Details', ['resource' => '']) </label>
        <textarea type="text" id="details" x-model="details" rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
    </div>

    <div class="my-2 col-span-2">
        <label for="font-size" class="block mb-2 text-sm font-medium text-gray-900 ">
            @lang('Remark')</label>
        <textarea type="text" id="remark" x-model="remark" rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
    </div>
</div>
