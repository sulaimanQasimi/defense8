<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/js/app.js', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('single.css') }}" />

</head>

<body dir="rtl">
    <div class="px-2 py-1">
        <div class="sm:px-6 w-auto">
            <div class="py-2 md:py-2 px-2 md:px-8 xl:px-10">
                <div
                    class="sm:flex items-center justify-between bg-gradient-to-t from-gray-800 to-gray-600 rounded-xl px-3 py-4 shadow-lg shadow-blue-100 sh">
                    <div class=" flex ">
                        <form class="max-w-sm mx-auto flex " action="">
                            <input name="code" autofocus type="text" dir="ltr"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                            <select id="countries" name="website"
                                class="mx-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">@lang('Other Orginization')</option>
                                @foreach ($websites as $website)
                                    <option value="{{ $website->id }}">{{ $website->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-indigo-700 to-indigo-600">{{ trans('Search') }}</button>
                        </form>
                    </div>
                    <div>
                        <a href="{{ route('employee.check.card') }}"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-indigo-700 to-indigo-600"
                            style="">@lang('My Orginization')</a>

                        <a href="/"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-blue-600 to-blue-500"
                            style="">@lang('Home')</a>

                    </div>

                </div>
                @if ($message)
                    <div class="mt-8 text-center text-7xl block font-medium text-red-600">
                        {{ $message }}
                    </div>
                @endif
                @if ($employee)
                    <div class="mt-7" dir="rtl">
                        <div class="grid grid-cols-3 gap-x-6">
                            <div class="">
                                <table
                                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
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
                                                    {{ $employee['card_no'] }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-4 py-2 text-2xl">
                                                نوم او تخلص:
                                            </th>
                                            <td class="px-6 py-4">

                                                <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                                    {{ $employee['name'] }}
                                                </p>
                                            </td>
                                        </tr>

                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-4 py-2  text-2xl">
                                                د پلارنوم:
                                            </th>
                                            <td class="px-4 py-2  text-2xl">
                                                <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                                    {{ $employee['father_name'] }}
                                                </p>
                                            </td>

                                        </tr>
                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-4 py-2   text-2xl">
                                                دنده:

                                            </th>
                                            <td class="px-4 py-2   text-2xl">
                                                <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                                    {{ $employee['job'] }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-4 py-2 text-2xl">
                                                پیل نیته:
                                            </th>
                                            <td class="px-4 py-2  text-2xl">
                                                <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                                    {{ $employee['card_perform'] }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-4 py-2 text-2xl">
                                                ختمیدو نیته:
                                            </th>


                                            <td class="px-4  py-2 text-2xl">

                                                <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">

                                                    {{ $employee['card_expired_date'] }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-4 py-2  text-2xl">
                                                اروند اداره:
                                            </th>


                                            <td class="px-4 py-2  text-2xl">

                                                <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                                    {{ $employee['department'] }}
                                                </p>
                                            </td>
                                        </tr>

                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-6 py-2 text-2xl">
                                                د وسلی دول:
                                            </th>
                                            <td class="px-6  py-2 text-2xl">
                                                {{ $employee['gun_type'] }}
                                            </td>
                                        </tr>
                                        <tr class="border border-gray-600">
                                            <th scope="col" class="px-6 py-2 text-2xl">
                                                د وسلی شمیره:
                                            </th>
                                            <td class="px-6 py-2 text-2xl">
                                                {{ $employee['gun_no'] }}
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class=" border-gray-600 border py-2 px-2">
                                <div class="text-3xl font-bold text-blue-700">شرایط:</div>
                                @foreach ($employee['employeeOptions'] as $option)
                                    <div class="text-blue-600  text-xl">{{ $option['name'] }}</div>
                                @endforeach
                            </div>
                            <div>
                                <img style="height: 500px" class=" w-auto  rounded-lg block"
                                    src="{{ $employee['photo'] }}" />
                            </div>
                        </div>
                        <div class="">
                            <div class="text-4xl m-5"> </div>
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <span class="text-2xl border-l-2 pl-2 ml-3 border-red-900 font-bold">پاملرنه</span>
                                <div>
                                    <span class="font-medium text-2xl">{!! $employee['remark'] !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
