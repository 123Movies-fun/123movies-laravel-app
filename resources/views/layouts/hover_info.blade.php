<div class="jtip-quality">{{$movie->bestQuality()}}</div>
<div class="jtip-top">
    <div class="jt-info jt-imdb">IMDb: {{$movie->rating}}</div>
    <div class="jt-info">{{$movie->year}}</div>
    <div class="jt-info">{{$movie->duration}}</div>
    <div class="clearfix"></div>
</div>
<p class="f-desc">{{$movie->plot}}</p>

    <div class="block">Country:
        @php echo $movie->countryLinks($str = true, $limit = 3) @endphp    </div>
    <div class="block">Genre:
        @php echo $movie->genreLinks($str = true, $limit = 3) @endphp   </div>
<div class="jtip-bottom">
    <a href="{{$movie->watchUrl()}}"
       class="btn btn-block btn-successful"><i
            class="fa fa-play-circle mr10"></i>Watch movie</a>

    @if(!$movie->isFavorited()) 
        <button data-id='{{$movie->id}}' data-title='{{$movie->title}}'
                class="btn btn-block btn-default mt10 favorite-btn">
            <i class="fa fa-heart mr10"></i>Favorite
        </button>
    @else
        <button data-id='{{$movie->id}}' data-title='{{$movie->title}}'
                class="btn btn-block btn-default mt10 favorite-btn">
            <i class="fa fa-close mr10"></i>Remove Favorite
        </button>
    @endif

</div>
