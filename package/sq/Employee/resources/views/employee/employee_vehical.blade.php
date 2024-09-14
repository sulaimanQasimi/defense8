<div class="mt-7 overflow-x-auto" dir="rtl">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">

                <tr>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3 text-center text-[32px]" colspan="7">
                        @lang('Employee Vehical Card')
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                        @lang('Vehical Palete')
                    </th>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                        @lang('Vehical Colour')
                    </th>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                        @lang('Vehical Chassis')
                    </th>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                        @lang('Vehical Model')
                    </th>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                        @lang('Driver')
                    </th>
                    <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                        @lang('Remark')
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employee->employee_vehical_card as  $vehical)
                    <tr tabindex="0" class="bg-white border-b">

                        <td class="px-6  border-1 border-gray-600 py-4">
                            {{ $vehical?->vehical_palete }}

                        </td>
                        <td class="px-6  border-1 border-gray-600 py-4">
                            {{ $vehical?->vehical_colour }}
                        </td>
                        <td class="px-6  border-1 border-gray-600 py-4">
                            {{ $vehical?->vehical_chassis }}
                        </td>
                        <td class="px-6  border-1 border-gray-600 py-4">
                            {{ $vehical?->vehical_model }}
                        </td>
                        <td class="px-6  border-1 border-gray-600 py-4">
                            <a href="{{ route('sqemployee.employee.check.card', ['code' => $vehical->driver?->registare_no]) }}"
                                class="text-blue-600 text-lg"> {{ $vehical->driver?->full_name }}</a>
                        </td>
                        <td class="px-6  border-1 border-gray-600 py-4">
                            {!! $vehical?->remark !!}
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b">
                        <td class="px-6  border-1 border-gray-600 py-4 text-center text-pretty" colspan="7">
                            @lang('Not Found')

                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
