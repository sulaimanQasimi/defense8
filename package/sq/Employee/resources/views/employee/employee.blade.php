@php
    $date1 = \Carbon\Carbon::make(\Alkoumi\LaravelHijriDate\Hijri::Date('Y-m-d'));

    // Create a \Carbon\Carbon instance from the card's expiration date
    $date2 = ($employee->current_id_card?->card_expired_date) ? \Carbon\Carbon::make($employee->current_id_card?->card_expired_date) : null;
    $state = false;
    if ($date2) {
        $state = $date1->gt($date2);
    }

@endphp
<div class="mt-4" dir="rtl">
    <div
        class="mt-5 border-4 border-white rounded-lg p-5 shadow-lg shadow-blue-300 grid md:grid-cols-3 sm:grid-cols-1 gap-2">
        <div class="rightside bg-gray-100 p-4 rounded-lg border border-white shadow-md">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="">

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-3 text-center  text-4xl" colspan="5">
                            د کارمند مشخصات
                        </th>

                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-xl ">
                            ثبت ګنه:
                        </th>
                        <td class="px-6 py-1">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->registare_no }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-xl">
                            نوم او تخلص:
                        </th>
                        <td class="px-6 py-4">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->name }}
                                {{ $employee->last_name }}
                            </p>
                        </td>
                    </tr>

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-xl">
                            د پلارنوم:
                        </th>
                        <td class="px-4 py-1  text-xl">
                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->father_name }}
                            </p>
                        </td>
                        {{-- <p class="hidden text-red-50"></p> --}}
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1   text-xl">
                            دنده:

                        </th>


                        <td class="px-4 py-1   text-xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->job_structure }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1   text-xl">
                            @lang('Category')
                        </th>


                        <td class="px-4 py-1   text-xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->category }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-xl">
                            پیل نیته:
                        </th>


                        <td class="px-4 py-1  text-xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">

                                {{ ($employee->current_id_card?->card_perform) ? \Carbon\Carbon::make($employee->current_id_card?->card_perform)->format("Y/m/d") : 'ندارد' }}

                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-xl">
                            ختمیدو نیته:
                        </th>


                        <td class="px-4  py-1 text-xl">


                            <p @class(['font-medium leading-none text-gray-700 mr-2 text-xl', 'text-red-700' => $state])>
                                {{ ($employee->current_id_card?->card_expired_date) ? \Carbon\Carbon::make($employee->current_id_card?->card_expired_date)->format("Y/m/d") : 'ندارد' }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-xl">
                            اروند اداره:
                        </th>


                        <td class="px-4 py-1  text-xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->orginization?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-xl">
                            اروند دروازه:
                        </th>


                        <td class="px-4 py-1  text-xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ $employee->gate?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-xl">
                            حاضری امروز:
                        </th>


                        <td class="px-4 py-1  text-xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-xl">
                                {{ trans(
    match ($attendance?->state) {
        'U' => 'Upsent',
        'P' => 'Present',
        default => 'حاضری نداده است',
    },
) }}
                            </p>

                        </td>
                    </tr>
                    {{-- Department Timer --}}
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-xl">
                            {{ (is_null($employee->orginization->start) || $employee->orginization->start == "") ? (new \App\Settings\AttendanceTimer())->start : $employee->orginization->start}}
                        </th>
                        <th scope="col" class="px-4 py-1  text-xl">
                            {{ (is_null($employee->orginization->end) || $employee->orginization->end == "") ? (new \App\Settings\AttendanceTimer())->end : $employee->orginization->end}}
                        </th>
                    </tr>
                    {{-- Today Attendance --}}
                    <tr class="border border-gray-600">

                        <th scope="col" class="px-4 py-1  text-xl">
                            {{ $attendance?->enter ? verta($attendance->enter)->format('Y/m/d h:i') : '' }}
                        </th>

                        <th scope="col" class="px-4 py-1  text-xl">
                            {{ $attendance?->exit ? verta($attendance?->exit)->format('Y/m/d h:i') : '' }}
                        </th>

                    </tr>
                </thead>
            </table>
        </div>


        <div class="text-right bg-gradient-to-r from-yellow-200 to-yellow-400 p-4 rounded-lg shadow-md">
            <div class="text-red-500 font-bold">شرایط:</div>
            @foreach ($employee->employeeOptions as $option)
                <div class="text-blue-600  text-xl">{{ $option->name }}</div>
            @endforeach
        </div>
        <div class="leftside bg-white rounded-lg shadow-md relative">
            <img style="height: 400px" class="rounded-lg block" src="{{ asset("storage/{$employee->photo}") }}" />
          
            @if($state)
                <div
                    class="absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center bg-black bg-opacity-50">
                    <h1 class="text-white text-2xl font-bold mb-4">این کارت باطل است</h1>
                    <h1 class="text-white text-2xl font-bold mb-4"> این شخص اجازه داخل شدن را ندارد </h1>
                    <h4 class="text-white text-xl font-bold text-center">لطفاً این کارت را از شخص مذکور بگيريد و به شماره 0202660424 تماس بگیرید.
                    </h4>
                </div>
            @endif
        </div>

        <div class="cursor-no-drop col-span-3">
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="text-xl border-l-2 pl-2 ml-3 border-red-900 font-bold">پاملرنه</span>
                <div>
                    <span class="font-medium text-xl">{!! $employee->remark !!}</span>
                </div>
            </div>
        </div>
        <div class="rounded-md text-center text-lg mt-4 bg-gray-50 w-full col-span-3">
            <h2>جهت معلومات بیشتر به این شماره به تماس شوید 2660788</h2>
        </div>

    </div>


    @include('sqemployee::employee.gun_card')
    @include('sqemployee::employee.employee_vehical')
</div>
