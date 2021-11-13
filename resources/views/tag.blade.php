@extends('layouts.app')

@section("title", "Watch $tagTitle online free without downloading - 123movies.fun")

@section("description", "$tagTitle, Free movies $tagTitle Online. Watch and Download Free Movies 2017. Watch thousands of free movies starring your favorite actors. You can find them all on this channel powered by 123movies.fun. Content is updated Daily and always free!")


@section("keywords", "Watch {{$tagTitle}}")

@section('content')
    <div id="main" class="">
        <div class="container">
            <div class="main-content">
                <div class="block_title title_cat">
                    <h1 class="title" style="font-size: 18px;">Watch {{$tagTitle}}, Free movies {{$tagTitle}} Online</h1>
                    <p>{{$tagTitle}}, Free movies {{$tagTitle}} Online. Watch and Download Free Movies 2017. Watch thousands of <a href="https://123movies.fun" title="free movies">Free Movies</a> starring your favorite actors. 
                    <br>You can find them all on this channel powered by 123movies.fun. Content is updated Daily and always free!</p>
                </div>
                <div class="movies-list-wrap mlw-topview mt20">
                    <!--search movies-->
                        <div class="movies-list movies-list-full tab-pane in fade active">
                            @foreach($movies as $movie) 
                            <div data-movie-id="{{ $movie->id }}" class="ml-item">
                                <a href="/watch/{{str_slug($movie->title, '-')}}/{{$movie->id}}" data-url="/imdb/info?id={{$movie->id}}" class="ml-mask jt" title="{{$movie->title }} ({{$movie->year}})"> <span class="mli-quality">{{$movie->bestQuality()}}</span> <img data-original="/cdn/posters/{{$movie->id}}.jpg" class="lazy thumb mli-thumb" alt="{{$movie->title }} ({{$movie->year}})"> <span class="mli-info"><h2>{{$movie->title }} ({{$movie->year}})</h2></span> </a>
                            </div>
                            @endforeach
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!--/search movies-->
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        if (!jQuery.browser.mobile) {
            $('.jt').qtip({
                content: {
                    text: function(event, api) {
                        $.ajax({
                            url: api.elements.target.attr('data-url'),
                            type: 'GET',
                            success: function(data, status) {
                                api.set('content.text', data);
                            }
                        });
                    },
                    title: function(event, api) {
                        return $(this).attr('title');
                    }
                },
                position: {
                    my: 'top left',
                    at: 'top right',
                    viewport: $(window),
                    effect: false,
                    target: 'mouse',
                    adjust: {
                        mouse: false
                    },
                    show: {
                        effect: false
                    }
                },
                hide: {
                    fixed: true
                },
                style: {
                    classes: 'qtip-light qtip-bootstrap',
                    width: 320
                }
            });
        }
        $("img.lazy").lazyload({
            effect: "fadeIn"
        });
    </script>
@endsection
