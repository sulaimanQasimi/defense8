<div class="grid grid-cols-2 gap-x-2 gap-y-3">

    <a target="_blank" href="{{route('sq.employee.pvc-test-card', ['printCardFrame' => $cardFrame->id])}}"
        class="mt-4 font-medium rounded-sm text-sm px-6 py-3 text-center mb-2 transition-all duration-200">
        @lang("Preview")
    </a>

    <div class="mb-5 col-span-2">
        <label class="block mb-2 text-sm font-medium text-gray-900 ">@lang('Card Header')</label>
        <textarea type="text" id="header" x-model="attr.government.title"></textarea>
    </div>

    {{-- QR Code Dimentions --}}
    <x-sqcard::form.dimention-slider label="QR code Dimentions" xModel="attr.qrcode.x" yModel="attr.qrcode.y"
        zModel="attr.qrcode.size" xMax="270" yMax="900" zMax="250" />

    {{-- QR Code Dimentions --}}
    <x-sqcard::form.dimention-slider label="Bar code Dimentions" xModel="attr.barCode.x" yModel="attr.barCode.y"
        zModel="attr.barCode.z" xMax="500" yMax="900" zMax="90" />

    {{-- Image Dimentions --}}
    <x-sqcard::form.dimention-slider label="Image Dimentions" xModel="attr.profile.x" yModel="attr.profile.y"
        zModel="attr.profile.size" xMax="270" yMax="900" zMax="250" />

    {{-- Image Dimentions --}}
    <x-sqcard::form.dimention-slider label="Minister Signature" xModel="attr.signature.x" yModel="attr.signature.y"
        zModel="attr.signature.size" xMax="270" yMax="900" zMax="250" />

    {{-- Ministry Logo Dimentions --}}
    <x-sqcard::form.dimention-slider label="Ministry Logo Dimentions" xModel="attr.ministry.x" yModel="attr.ministry.y"
        zModel="attr.ministry.size" xMax="270" yMax="900" zMax="250" />

    {{-- Ministry Logo Dimentions --}}
    <x-sqcard::form.dimention-slider label="Government Logo Dimentions" xModel="attr.government.x"
        yModel="attr.government.y" zModel="attr.government.size" xMax="270" yMax="500" zMax="250" />

    <div class="my-2 col-span-2">
        <div>
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

    <div class="my-2 col-span-2">
        <label for="font-size" class="block mb-2 text-sm font-medium text-gray-900 ">
            @lang('Remark')</label>
        <textarea type="text" id="remark" x-model="remark" rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
    </div>
</div>
