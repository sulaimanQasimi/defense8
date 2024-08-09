<html>

<head>
    <title> @lang('Educational Videos of System')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('fontawesom/all.min.css') }}" />

</head>

<body dir="rtl" class="bg-gray-300 px-24 py-10 ">

    <div class="block">
        <a href="/"
            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-blue-600 to-blue-500"
            style="">@lang('Home')</a>
    </div>
    <div class="bg-white text-center text-blue-500 px-3 py-4 text-xl font-medium rounded-l my-6">
        @lang('Educational Videos of System')
    </div>
    @foreach ($videos as $video)
        <div class="bg-white px-5 py-3 rounded-xl shadow-xl shadow-blue-200 hover:bg-gray-200 my-3">
            <div>

                <div class="text-blue-900 font-medium hover:font-thin"> <a
                        class="fas fa-play mx-3 fa-xl text-blue-700 hover:scale-105"
                        href="{{ route('youtube.preview', ['video' => $video->id]) }}"
                        target="_blank"></a>{{ $video->title }}
                </div>
            </div>
        </div>
    @endforeach

</body>

</html>
