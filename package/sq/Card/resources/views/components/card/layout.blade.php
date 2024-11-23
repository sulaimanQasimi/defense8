<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} || @lang('Print Card Frame')</title>
    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('cards/font.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('build/assets/app.css') }}" rel="stylesheet" />
    <script src="{{ asset('alpine.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cards/JsBarcode/dist/JsBarcode.all.min.js') }}"></script>
<style>
    body{
        margin: 0;
        padding: 0;
    }
</style>
</head>

<body class="persian-font antialiased">
    {{-- Print Context --}}
    {{ $slot }}
    <script type="text/javascript" src="{{ asset('cards/qrcode/qrcode.js') }}"></script>
    @stack('js')
</body>

</html>
