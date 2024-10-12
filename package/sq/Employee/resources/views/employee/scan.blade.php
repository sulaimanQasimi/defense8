<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('single.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}" />

    <style>
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #d7d2e9;
            border-radius: 0;
        }

        ::-webkit-scrollbar-track {
            background-color: hsl(0, 0%, 100%);
        }
    </style>
</head>

<body dir="rtl">
    <div class="px-2 py-1">
        <div class="sm:px-6 w-auto">
            <div class="py-2 md:py-2 px-2 md:px-8 xl:px-10">
                <div class="sm:flex items-center justify-between">
                    <div class="flex ">
                        <form action="">
                            <input name="code" autofocus type="text" id="scanner" dir="ltr"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                required>
                        </form>
                        @if ($guest)
                            <a class="mx-3 px-7  pt-2 bg-gradient-to-t from-green-600 to-green-700 text-white rounded-lg"
                                href="{{ route('sqguest.guest.generate', $guest) }}">
                                @lang('Print')
                            </a>
                        @endif
                    </div>
                    <div>
                        <a href="/"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-indigo-600 to-indigo-500"
                            style="">
                            @lang('Home')
                        </a>
                    </div>
                </div>
                @includeWhen($employee, 'sqemployee::employee.employee')
                @includeWhen($guest, 'sqemployee::employee.guest')
            </div>
        </div>
    </div>
    <script>
        const field = document.getElementById('scanner');

        function keepFocus() {
            field.focus();
        }

        field.addEventListener('blur', keepFocus)

        field.focus()
    </script>
</body>

</html>
