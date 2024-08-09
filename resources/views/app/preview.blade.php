<html>

<head>
    <title> @lang('Educational Videos of System')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('video.js/video-js.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #video-preview {
            height: 100vh;
            width: 100vw;
        }

        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body dir="rtl">
    <video id="video-preview" class="video-js vjs-default-skin" controls loop>
        <source src="{{ asset("app/video/{$video->link}") }}">
    </video>
    <script src="{{ asset('video.js/video.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('video.js/videojs-contrib-hls.min.js') }}" type="text/javascript"></script>
    @stack('js')
    <script>
        var player = videojs('video-preview');
        player.play();
    </script>
</body>

</html>
