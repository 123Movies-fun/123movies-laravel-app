<link href="https://vjs.zencdn.net/5.19.1/video-js.css" rel="stylesheet">

<!-- If you'd like to support IE8 -->
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

<video id="video_player" class="video-js vjs-big-play-centered" controls preload="auto" style="width: 100%;" poster="/cdn/movie_player_covers/{{ $movie->id }}.jpg" data-setup="{}">
<source src="{{$file_url}}" type='video/mp4'>
<p class="vjs-no-js">
To view this video please enable JavaScript, and consider upgrading to a web browser that
<a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
</p>
</video>

<script src="https://vjs.zencdn.net/5.19.1/video.js"></script>