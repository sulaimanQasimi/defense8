<html>

<head>
    @vite(['resources/js/app.js', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('style.css') }}" />

</head>

<body>

    <div class="text-9xl text-center text-red-500 mt-[50vh]">مهمان مربوط این جز تام نیست</div>
    <a class="mx-3 px-7  pt-2 bg-gradient-to-t from-sky-300 to-sky-400 text-white rounded-lg"
        href="{{ route('sqemployee.employee.check.card') }}"> @lang('Home')</a>
</body>

</html>
