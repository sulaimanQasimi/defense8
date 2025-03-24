<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}" />

    <style>
        @font-face {
            font-family: "persian-font";
            /* This is the name you will use to reference the custom font */
            src: url("/mod_font.ttf") format("truetype");
            /* Specify the path to your font file */
        }

        body {
            font-family: 'persian-font';
            /* Change 'Arial' to the desired font family */
        }

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

<body class="bg-gradient-to-b from-blue-50 to-blue-100 px-5 pt-2">
    <!-- Header -->
    <header
        class="flex justify-between items-center bg-gradient-to-r from-[#6c64ff] to-[#0095ff] p-4 rounded-lg shadow-lg">
        <div>

            @if ($guest)
                <a class="mx-3 px-7  pt-2 bg-gradient-to-t from-green-600 to-green-700 text-white rounded-lg"
                    href="{{ route('sqguest.guest.generate', $guest) }}">
                    @lang('Print')
                </a>
            @elseif($patient)
                <a class="mx-3 px-7  pt-2 bg-gradient-to-t from-green-600 to-green-700 text-white rounded-lg"
                    href="{{ route('sqguest.patient.generate', $patient) }}">
                    @lang('Print')
                </a>
            @else
                <a href="/"
                    class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-indigo-600 to-indigo-500"
                    style="">
                    @lang('Home')
                </a>
            @endif
        </div>
        <h1 class="text-white text-2xl font-bold">د ملی دفاع وزارت</h1>

        <form action="" class="flex items-center">
            <input name="code" autofocus type="text" id="scanner" dir="ltr" placeholder="د کارت نمبر"
                class="border text-center border-gray-300 p-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-[#FF6F61] focus:border-transparent"
                required />
        </form>
    </header>

    <div class="px-2 py-1">
        <div class="sm:px-6 w-auto">
            <div class="py-2 md:py-2 px-2 md:px-8 xl:px-10">
                @includeWhen($employee, 'sqemployee::employee.employee')
                @includeWhen($guest, 'sqemployee::employee.guest')
                @includeWhen($patient, 'sqemployee::employee.patient')
            </div>
        </div>
    </div>
    @unless ($guest)
        <script>
            const field = document.getElementById('scanner');

            function keepFocus() {
                field.focus();
            }

            field.addEventListener('blur', keepFocus)

            field.focus()
        </script>

    @endunless
</body>

</html>