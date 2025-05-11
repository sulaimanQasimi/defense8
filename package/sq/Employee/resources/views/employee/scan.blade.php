<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <style>
        @font-face {
            font-family: "persian-font";
            src: url("/mod_font.ttf") format("truetype");
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'persian-font', Arial, sans-serif;
            background: linear-gradient(to bottom, #ebf3ff, #dae8ff);
            padding: 10px 20px;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #d7d2e9;
            border-radius: 0;
        }

        ::-webkit-scrollbar-track {
            background-color: #ffffff;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to right, #6c64ff, #0095ff);
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        h1 {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .print-btn, .home-btn {
            display: inline-block;
            margin: 0 12px;
            padding: 8px 28px;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        .print-btn {
            background: linear-gradient(to top, #22c55e, #16a34a);
        }

        .home-btn {
            background: linear-gradient(to top, #5046e5, #6366f1);
            transition: transform 0.2s;
        }

        .home-btn:hover {
            transform: scale(0.95);
        }

        form {
            display: flex;
            align-items: center;
        }

        input[type="text"] {
            border: 1px solid #d1d5db;
            text-align: center;
            padding: 8px;
            border-radius: 6px 0 0 6px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: transparent;
            box-shadow: 0 0 0 2px #FF6F61;
        }

        .content-container {
            padding: 8px 4px;
        }

        .content-wrapper {
            width: auto;
        }

        @media (min-width: 640px) {
            .content-wrapper {
                padding: 0 24px;
            }
        }

        .content-inner {
            padding: 8px;
        }

        @media (min-width: 768px) {
            .content-inner {
                padding: 8px 32px;
            }
        }

        @media (min-width: 1280px) {
            .content-inner {
                padding: 8px 40px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div>
            @if ($guest)
                <a class="print-btn" href="{{ route('sqguest.guest.generate', $guest) }}">
                    @lang('Print')
                </a>
            @elseif($patient)
                <a class="print-btn" href="{{ route('sqguest.patient.generate', $patient) }}">
                    @lang('Print')
                </a>
            @else
                <a href="/" class="home-btn">
                    @lang('Home')
                </a>
            @endif
        </div>
        <h1>د ملی دفاع وزارت</h1>

        <form action="">
            <input name="code" autofocus type="text" id="scanner" dir="ltr" placeholder="د کارت نمبر" required />
        </form>
    </header>

    <div class="content-container">
        <div class="content-wrapper">
            <div class="content-inner">
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
