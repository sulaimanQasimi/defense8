<html>
<head>

    <link rel="stylesheet" href="{{ asset('login.css') }}" />
    <link rel="stylesheet" href="{{ asset('single.css') }}" />
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
