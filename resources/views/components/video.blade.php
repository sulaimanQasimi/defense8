@props(['link','poster','create'])
<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    <video id="{{$create}}" width=600 height=300 class="video-js vjs-default-skin" controls poster="{{$poster}}">
        <source src="{{$link}}">
    </video>
    @push('js')
    <script>
        var player = videojs('{{$create}}');
        player.play();
    </script>
    @endpush
</div>
