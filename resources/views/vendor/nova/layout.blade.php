<!DOCTYPE html>
<html lang="{{ $locale = \Laravel\Nova\Nova::resolveUserLocale(request()) }}"
    dir="{{ \Laravel\Nova\Nova::rtlEnabled() ? 'rtl' : 'ltr' }}" class="h-full font-sans antialiased">

<head>
    <meta name="theme-color" content="#fff">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width" />
    <meta name="locale" content="{{ $locale }}" />
    <meta name="robots" content="noindex">

    <link rel="icon" href="{{ asset('logo 32X32.png') }}">

    @include('nova::partials.meta')

    <!-- Styles cnkxlmcvkl-->
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">

    @if ($styles = \Laravel\Nova\Nova::availableStyles(request()))
        <!-- Tool Styles -->
        @foreach ($styles as $asset)
            <link rel="stylesheet" href="{!! $asset->url() !!}">
        @endforeach
    @endif

    <script>
        if (localStorage.novaTheme === 'dark' || (!('novaTheme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="{{ asset('fontawesom/all.min.css') }}" />
</head>

<body class="min-w-site text-sm font-medium min-h-full text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900">
    @inertia

    <!-- Scripts -->
    <script src="{{ mix('manifest.js', 'vendor/nova') }}"></script>
    <script src="{{ mix('vendor.js', 'vendor/nova') }}"></script>
    <script src="{{ mix('app.js', 'vendor/nova') }}"></script>

    <!-- Build Nova Instance -->
    <script>
        const config = @json(\Laravel\Nova\Nova::jsonVariables(request()));
        window.Nova = createNovaApp(config)
        Nova.countdown()
    </script>

    @if ($scripts = \Laravel\Nova\Nova::availableScripts(request()))
        <!-- Tool Scripts -->
        @foreach ($scripts as $asset)
            <script src="{!! $asset->url() !!}"></script>
        @endforeach
    @endif

    <script src="{{ asset('hijri/build/datepicker-hijri.js') }}"></script>
    <!-- Start Nova -->
    <script defer>
        Nova.liftOff()
    </script>

</body>

</html>
