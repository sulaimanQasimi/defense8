        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
            <tbody class="text-xs text-gray-700 uppercase bg-gray-50  ">

                <tr>
                    <th colspan="2" class="px-6 py-3 text-4xl text-center">@lang('Gun Card')</th>
                </tr>
                <tr>
                    <th scope="col" class="px-6 py-1 text-2xl">
                        د وسلی دول:
                    </th>
                    <th scope="col" class="px-6 py-1 text-2xl">
                        د وسلی شمیره:
                    </th>
                </tr>
                @foreach ($employee->gun_card as $gun )


                <tr class="border border-gray-600">



                    <td class="px-6  py-1 text-2xl">
                        {{ $gun?->gun_type }}
                    </td>

                    <td class="px-6 py-1 text-2xl">
                        {{ $gun?->gun_no }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
