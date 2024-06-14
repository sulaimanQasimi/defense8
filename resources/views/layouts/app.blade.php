<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />
    @vite(['resources/js/app.js'])

    @stack('css')
    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
</head>
<body class="persian-font antialiased bg-sky-300">
    <div class="px-4 py-2">
        <main>
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
    <!-- jQuery -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('date/js/persian-datepicker.js') }}"></script>
    @stack('js')
</body>

</html>
