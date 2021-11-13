@extends('layouts.app')

@section('content')

<div id="main" class="">
    <div class="container">
        <div class="pad"></div>
        <div class="main-content main-detail">
            <div id="bread">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li>User</li>
                    <li class="active">Profile</li>
                </ol>
            </div>
            <div class="profiles-wrap">
                <div class="sidebar">
                    <div class="sidebar-menu">
                        <div class="sb-title"><i class="fa fa-navicon mr5"></i> Menu</div>
                        <ul>
                            <li class="">
                                <a href="/user/profile"> <i class="fa fa-user mr5"></i> Profile </a>
                            </li>
                            <li class="active">
                                <a href="/movies/favorites"> <i class="fa fa-heart mr5"></i> My movies </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pp-main">
                    <div class="ppm-head">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a href="/movies/favorites"><i class="fa fa-bookmark mr5"></i>
                                    Favourites</a></li>
                            <li class=""><a href="/movies/rated"><i class="fa fa-star mr5"></i>
                                    Rated</a></li>
                        </ul>
                    </div>
                    <div class="ppm-content user-content">
                       
                    <div class="movies-list-wrap mlw-profiles" id="favorites_list">
                        <div class="movies-list movies-list-full">
                            @foreach($movies as $movie) 
                                <div data-movie-id="{{ $movie->id }}" class="ml-item" style="height: 160px; border-radius: 4px;">
                                    <a href="/watch/{{$movie->id}}/{{str_slug($movie->title, '-')}}" data-url="/imdb/info?id={{$movie->id}}" class="ml-mask jt" data-hasqtip="0" title="{{$movie->title }}"></a>
                                    <span class="mli-quality">{{$movie->bestQuality()}}</span>
                                    
                                    <img data-original="/cdn/posters/{{$movie->id}}.jpg" class="lazy thumb mli-thumb" alt="{{$movie->title }}" src="/cdn/posters/{{$movie->id}}.jpg" style="display: inline-block;">
                                    <span class="mli-info"><h2>{{$movie->title }}</h2></span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
 </div>
</div>
</div>

    <script type="text/javascript">
    if (!jQuery.browser.mobile) {
        $('.jt').qtip({
            content: {
                text: function (event, api) {
                    $.ajax({
                        url: api.elements.target.attr('data-url'),
                        type: 'GET',
                        success: function (data, status) {
                            // Process the data

                            // Set the content manually (required!)
                            api.set('content.text', data);
                        }
                    });
                }, // The text to use whilst the AJAX request is loading
                title: function (event, api) {
                    return $(this).attr('title');
                }
            },
            position: {
                my: 'top left',  // Position my top left...
                at: 'top right', // at the bottom right of...
                viewport: $(window),
                effect: false,
                target: 'mouse',
                adjust: {
                    mouse: false  // Can be omitted (e.g. default behaviour),
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