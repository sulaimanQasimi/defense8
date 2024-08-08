<html>

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="theme-color" content="#fff">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width" />
    <meta name="locale" content="{{ app()->getLocale() }}" />
    <meta name="robots" content="noindex">
    <link rel="icon" href="{{ asset('logo 32X32.png') }}">
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    <section class="min-h-screen flex items-stretch text-white">
        <div class="lg:flex w-1/2 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center"
            style="background-image: url({{ asset('bg1.jpg') }})">
            <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            <div class="w-full px-24 z-10">
                <h1 class="text-3xl font-bold text-center tracking-wide">
                    د افغانستان اسلامی امارت
                </h1>
                <p class="text-center text-2xl mt-2">د ملی دفاع وزارت</p>
            </div>
        </div>
        <div class="lg:w-1/2 w-full flex items-center justify-center text-center md:px-16 px-0 z-0"
            style="
            background: linear-gradient(
              to bottom,
              #000000,
              rgba(21, 0, 249, 0.867)
            );
          ">
            <div class="absolute lg:hidden z-10 inset-0 bg-gray-500 bg-no-repeat bg-cover items-center"
                style="background-image: url({{ asset('bg1.jpg') }})">
                <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            </div>
            <div class="w-full py-6 z-20">
                <h1 class="my-6 text-3xl">Welcome to System</h1>
                <p class="text-gray-100">Login account</p>
                <form action="/login" method="POST" class="sm:w-2/3 w-full px-4 lg:px-0 mx-auto">
                    @csrf
                    <div class="pb-2 pt-4">
                        <input type="email" name="email" id="email" placeholder="Email"
                            class="block w-full p-4 text-lg rounded-sm bg-transparent border border-white" />
                            @error('email')
                            <span class="text-red-500 font-semibold">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="pb-2 pt-4">
                        <input class="block w-full p-4 text-lg rounded-sm bg-transparent border border-white"
                            type="password" name="password" id="password" placeholder="Password" />
                            @error('password')
                            <span class="text-red-500 font-semibold">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="px-4 pb-2 pt-4">
                        <button
                            class="uppercase block w-full p-4 text-lg rounded-full bg-indigo-500 hover:bg-indigo-600 focus:outline-none">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
