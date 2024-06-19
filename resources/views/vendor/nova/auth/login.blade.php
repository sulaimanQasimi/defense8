<html>
<head>

    <meta name="theme-color" content="#fff">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width"/>
    <meta name="locale" content="{{ app()->getLocale() }}"/>
    <meta name="robots" content="noindex">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #a3a07c;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: -20px 0 50px;
        }

        .title,
        h3 {
            font-weight: bold;
            margin: 0;
            margin-top: 10px;
            color: #287918;
            padding: 10px;
            border-radius: 10px;
            background-color: white;
        }

        p {
            font-size: 14px;
            font-weight: 100;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
        }

        button {
            border-radius: 20px;
            border: none;
            background-color: #449f4b;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s;
        }

        button:hover {
            background-color: #0c3b10;
        }

        form {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-image: url(military.png);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        input {
            background-color: #fff;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 5px;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
        }

        .log-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }


        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
        }


        .overlay {
            background-image: url(military.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
        }


        .overlay-right {
            right: 0;
        }


        .social-container {
            margin: 50px 0;
        }

        .social-container a {
            border: 1px solid #DDDDDD;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
        }

        .title {
            margin-bottom: 20px;
        }

        .logo {
            width: 300px;
            background-color: white;
            border-radius: 50%;
            animation: logo 2s infinite alternate;
        }

        @keyframes logo {
            0% {}

            100% {
                transform: translateY(20px);
            }
        }

        .error {
            color: red;
            text-align: left
        }

        @font-face {
            font-family: 'persian-font';
            /* This is the name you will use to reference the custom font */
            src: url("{{ asset('mod_font.ttf') }}") format('truetype');
            /* Specify the path to your font file */
        }

        body {
            font-family: 'persian-font';
            /* Change 'Arial' to the desired font family */
        }

        .font-sans {
            font-family: "persian-font", sans-serif;
        }

        * {
            font-family: 'persian-font';
            /* Change 'Arial' to the desired font family */
        }
    </style>

</head>

<body>
    <div class="container" id="container">
        <div class="form-container log-in-container">
            <form action="/login" method="POST"> @csrf
                <h1 class="title">د ملي دفاع وزارت</h1>
                <h3>سیستم ته د ننوتلو پاڼه</h3>
                <input type="email" placeholder="Email" name="email" />
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
                <input type="password" placeholder="Password" name="password" />
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
                <button type="submit">ننوتل</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1></h1>
                    <img class="logo" src="{{ asset('logo.png') }}" alt="logo">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
