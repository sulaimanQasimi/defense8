
<div class="mt-7 overflow-x-auto" dir="rtl">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                <tr>
                    <th scope="col" class="px-6 py-3 text-center" colspan="5">
                        @lang('Black Mirror Vehical Card')
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="px-6 py-3">
                        @lang('Vehical Palete')
                    </th>
                    <th scope="col" class="px-6 py-3">
                        @lang('Vehical Colour')
                    </th>
                    <th scope="col" class="px-6 py-3">
                        @lang('Vehical Model')
                    </th>
                    <th scope="col" class="px-6 py-3">
                        @lang('Driver')
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employee->card_info->black_mirror_vehical_card as  $bmvc)
                    <tr tabindex="0"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                        <td class="px-6 py-4">
                            <div class="flex items-center pl-5">
                                <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                    {{ $bmvc->vehical_palete }}</p>

                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center pl-5">
                                <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                    {{ $bmvc->vehical_colour }}</p>

                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center pl-5">
                                <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                    {{ $bmvc->vehical_model }}</p>

                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center pl-5">
                                <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                    {{ $bmvc->name }}
                                    {{ $bmvc->last_name }}
                                </p>

                            </div>
                        </td>
                    </tr>
                @empty


                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 text-center text-pretty" colspan="4">
                            @lang('Not Found')

                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
