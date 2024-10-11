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
                        <th scope="col" class="px-4 py-1 text-2xl ">
                            ثبت ګنه:
                        </th>
                        <td class="px-6 py-1">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->registare_no }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
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
                        <th scope="col" class="px-4 py-1  text-2xl">
                            د پلارنوم:
                        </th>
                        <td class="px-4 py-1  text-2xl">
                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->father_name }}
                            </p>
                        </td>

                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1   text-2xl">
                            دنده:

                        </th>


                        <td class="px-4 py-1   text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->job_structure }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            پیل نیته:
                        </th>


                        <td class="px-4 py-1  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->main_card ? verta($employee->main_card?->card_perform)->format('Y/m/d') : '' }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            ختمیدو نیته:
                        </th>


                        <td class="px-4  py-1 text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">

                                {{ $employee->main_card ? verta($employee->main_card?->card_expired_date)->format('Y/m/d') : '' }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-2xl">
                            اروند اداره:
                        </th>


                        <td class="px-4 py-1  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->orginization?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-2xl">
                            اروند دروازه:
                        </th>


                        <td class="px-4 py-1  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->gate?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-2xl">
                            حاضری امروز:
                        </th>


                        <td class="px-4 py-1  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ trans(
                                    match ($employee->today_attendance?->state) {
                                        'U' => 'Upsent',
                                        'P' => 'Present',
                                        default=>"حاضری نداده است",
                                    },
                                ) }}
                            </p>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>


        <div class="border-gray-600 border py-1 px-2">
            <div class="text-3xl font-bold text-blue-700">شرایط:</div>
            @foreach ($employee->employeeOptions as $option)
                <div class="text-blue-600  text-xl">{{ $option->name }}</div>
            @endforeach
        </div>

        <div>

            <img style="height: 400px" class="rounded-lg block" src="{{ asset("storage/{$employee->photo}") }}" />

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

    @include('sqemployee::employee.attendance')
    @include('sqemployee::employee.gun_card')
    @include('sqemployee::employee.employee_vehical')
</div>
