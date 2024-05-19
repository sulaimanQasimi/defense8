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
                <div class="sm:flex items-center justify-between">
                    <div class=" flex ">
                        <form action="">
                            <input name="code" autofocus type="text" dir="ltr"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </form>
                        @if ($guest)
                            <a class="mx-3 px-7  pt-2 bg-gradient-to-t from-green-600 to-green-700 text-white rounded-lg"
                                href="{{ route('guest.generate', $guest) }}"> @lang('Print')</a>
                        @endif
                    </div>
                    <div>
                        @can('see-other-website-data')
                            <a href="{{ route('employee.check.other-website-employee') }}"
                                class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-indigo-700 to-indigo-600"
                                style="">@lang('Other Orginization')</a>
                        @endcan
                        <a href="/"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-blue-600 to-blue-500"
                            style="">@lang('Home')</a>

                    </div>

                </div>

                @includeWhen($employee, 'employee.employee')
                @includeWhen($guest, 'employee.guest')
            </div>
        </div>
    </div>
</body>

</html>
