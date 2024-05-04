<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('style.css') }}" />
</head>

<body dir="rtl">
    <div class="px-32 py-6">

        <table class="w-full rtl:text-right border border-gray-300">

            <tr class="bg-blue-300">
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl text-center text-gray-800 font-semibold "
                    colspan="4"> د ملي دفاع وزارت د ورځنیو ميلمنو نوملړ</td>
            </tr>
            <tr class="border-b border-gray-300">
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl text-center font-semibold" colspan="2">د
                    ميلمه پېژند پاڼه</td>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl text-center font-semibold" colspan="2">د
                    کوربه پېژند پاڼه
                </td>
            </tr>
            <tr class="border-b border-gray-300">
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">نوم او تخلص:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border border-gray-300">
                    {{ $guest->name }} {{ $guest->last_name }}</td>
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">بلونکې اداره:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->name }}</td>
            </tr>


            <tr class="border-b border-gray-300">

                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">شهرت:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                    {{ $guest->career }}</td>
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">بلونکی شخص:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->head_name }}</td>
            </tr>


            <tr class="border-b border-gray-300">
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د راتلونېټه:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                    {{ $guest->jalali_come_date }}</td>
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">دنده:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->job }}</td>
            </tr>


            <tr class="border-b border-gray-300">
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د راتلو وخت:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                    {{ $guest->jalali_come_time }}</td>

                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">ادرس:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->address }}</td>
            </tr>
            <tr class="border-b border-gray-300">
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د راتلو دروازه:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                    {{ $guest->gate_translation }}</td>
                <td></td>
                <td></td>
            </tr>

            <tr class="border-b border-gray-300">
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">ادرس:</th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                    {{ $guest->address }}</td>
                <th></th>
                <td></td>
            </tr>

            <tr class="border-b border-gray-300">
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl pr-6  border-l border-r border-gray-300"
                    colspan="2"> <span>پاملرنه:</span>
                    <div class="mr-14">
                        @foreach ($guest->Guestoptions as $option)
                            <div class="mx-3">
                                <p class="text-green-600 font-semibold text-xl">{{ $option->name }}</p>
                            </div>
                        @endforeach
                    </div>

                    </td>
                <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl"></th>
                <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl"></td>
            </tr>

        </table>

    </div>
</body>

</html>
