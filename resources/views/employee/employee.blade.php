<div class="mt-7" dir="rtl">
    <div class="grid grid-cols-3 gap-x-6">
        <div class="">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                <thead class="">

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-3 text-center  text-4xl" colspan="5">
                            د کارمند مشخصات
                        </th>

                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2 text-2xl ">
                            ثبت ګنه:
                        </th>
                        <td class="px-6 py-2">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->registare_no }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2 text-2xl">
                            نوم او تخلص:
                        </th>
                        <td class="px-6 py-4">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->name }}
                                {{ $employee->last_name }}
                            </p>
                        </td>
                    </tr>

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2  text-2xl">
                            د پلارنوم:
                        </th>
                        <td class="px-4 py-2  text-2xl">
                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->father_name }}
                            </p>
                        </td>

                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2   text-2xl">
                            دنده:

                        </th>


                        <td class="px-4 py-2   text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->job_structure }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2 text-2xl">
                            پیل نیته:
                        </th>


                        <td class="px-4 py-2  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ verta($employee->card_perform)->format('Y/m/d') }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2 text-2xl">
                            ختمیدو نیته:
                        </th>


                        <td class="px-4  py-2 text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">

                                {{ verta($employee->card_expired_date)->format('Y/m/d') }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-2  text-2xl">
                            اروند اداره:
                        </th>


                        <td class="px-4 py-2  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->orginization?->name }}
                            </p>
                        </td>
                    </tr>

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-6 py-2 text-2xl">
                            د وسلی دول:
                        </th>
                        <td class="px-6  py-2 text-2xl">
                            {{ $employee->gun_card?->gun_type }}
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-6 py-2 text-2xl">
                            د وسلی شمیره:
                        </th>
                        <td class="px-6 py-2 text-2xl">
                            {{ $employee->gun_card?->gun_no }}
                        </td>
                    </tr>
                </thead>
            </table>

        </div>


        <div class=" border-gray-600 border py-2 px-2">
            <div class="text-3xl font-bold text-blue-700">شرایط:</div>
            @foreach ($employee->employeeOptions as $option)
                <div class="text-blue-600  text-xl">{{ $option->name }}</div>
            @endforeach
        </div>

        <div>

            <img style="height: 500px" class=" w-auto  rounded-lg block"
                src="{{ asset("storage/{$employee->photo}") }}" />

        </div>
    </div>


    <div class="">
        <div class="text-4xl m-5"> </div>
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <span class="text-2xl border-l-2 pl-2 ml-3 border-red-900 font-bold">پاملرنه</span>
            <div>
                <span class="font-medium text-2xl">{!! $employee->remark !!}</span>
            </div>
        </div>
    </div>

    <div class="flex justify-around mt-10">

        {{--  IF Current Gate is Main Gate And Enter Gate is empty --}}

        @if (auth()->user()->gate->id === $employee->gate?->id)

        @if (!$employee->current_gate_attendance?->enter && $employee->current_gate_attendance?->state !="U")
                <a href="{{ route('employee.check', ['cardInfo' => $employee->id, 'state' => 'enter']) }}"
                    class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-green-600 to-green-500"
                    style="">@lang('Present')</a>
            @endif

            @if (!is_null($employee->current_gate_attendance?->enter) && is_null($employee->current_gate_attendance?->exit) && $employee->current_gate_attendance?->state !="U")
                <a href="{{ route('employee.check', ['cardInfo' => $employee->id, 'state' => 'exit']) }}"
                    class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-red-600 to-red-500"
                    style="">@lang('Exited')</a>
            @endif
            @if ($employee->current_gate_attendance?->state !="P" &&is_null( $employee->current_gate_attendance?->state))
                <a href="{{ route('employee.check', ['cardInfo' => $employee->id, 'state' => 'upsent']) }}"
                    class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-red-600 to-red-500"
                    style="">@lang('Upsent')</a>
            @endif
        @endif
    </div>
</div>
