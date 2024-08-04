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
    <style>
             <style>
            @media print {
                body {
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }

                #printable {
                    position: absolute;
                    top: 0;
                    left: 0;
                }

            }

            body {
                background-color: white
            }

            /* level settings 👇 */

            .slider {
                /* slider */
                --slider-width: 100%;
                --slider-height: 6px;
                --slider-bg: rgb(82, 82, 82);
                --slider-border-radius: 999px;
                /* level */
                --level-color: #fff;
                --level-transition-duration: .1s;
                /* icon */
                --icon-margin: 15px;
                --icon-color: var(--slider-bg);
                --icon-size: 25px;
            }

            .slider {
                cursor: pointer;
                display: -webkit-inline-box;
                display: -ms-inline-flexbox;
                display: inline-flex;
                -webkit-box-orient: horizontal;
                -webkit-box-direction: reverse;
                -ms-flex-direction: row-reverse;
                flex-direction: row-reverse;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
            }

            .slider .volume {
                display: inline-block;
                vertical-align: top;
                margin-right: var(--icon-margin);
                color: var(--icon-color);
                width: var(--icon-size);
                height: auto;
            }

            .slider .level {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                width: var(--slider-width);
                height: var(--slider-height);
                background: var(--slider-bg);
                overflow: hidden;
                border-radius: var(--slider-border-radius);
                -webkit-transition: height var(--level-transition-duration);
                -o-transition: height var(--level-transition-duration);
                transition: height var(--level-transition-duration);
                cursor: inherit;
            }

            .slider .level::-webkit-slider-thumb {
                -webkit-appearance: none;
                width: 0;
                height: 0;
                -webkit-box-shadow: -200px 0 0 200px var(--level-color);
                box-shadow: -200px 0 0 200px var(--level-color);
            }

            .slider:hover .level {
                height: calc(var(--slider-height) * 2);
            }

            .svg-frame {
                position: relative;
                width: 300px;
                height: 300px;
                transform-style: preserve-3d;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .svg-frame svg {
                position: absolute;
                transition: .5s;
                z-index: calc(1 - (0.2 * var(--j)));
                transform-origin: center;
                width: 344px;
                height: 344px;
                fill: none;
            }

            .svg-frame:hover svg {
                transform: rotate(-80deg) skew(30deg) translateX(calc(45px * var(--i))) translateY(calc(-35px * var(--i)));
            }

            .svg-frame svg #center {
                transition: .5s;
                transform-origin: center;
            }

            .svg-frame:hover svg #center {
                transform: rotate(-30deg) translateX(45px) translateY(-3px);
            }

            #out2 {
                animation: rotate16 7s ease-in-out infinite alternate;
                transform-origin: center;
            }

            #out3 {
                animation: rotate16 3s ease-in-out infinite alternate;
                transform-origin: center;
                stroke: #ff0;
            }

            #inner3,
            #inner1 {
                animation: rotate16 4s ease-in-out infinite alternate;
                transform-origin: center;
            }

            #center1 {
                fill: #ff0;
                animation: rotate16 2s ease-in-out infinite alternate;
                transform-origin: center;
            }

            @keyframes rotate16 {
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
   
    </style>

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
