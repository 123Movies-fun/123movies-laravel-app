@extends('layouts.app')


@section("title", "Watch $movie->title online free without downloading - 123movies.fun")

@section("description", "$movie->plot")

@php
    $tags = strip_tags($movie->tagLinks($str = true, $limit = 3));
    $cover = "https://123movies.fun/cdn/movie_player_covers/$movie->id.jpg";
@endphp
@section("keywords", "Watch $movie->title - $movie->plot $tags")
@section("image", "$cover")


@section('content')

<div id="main" class="" style="padding-top: 70px;">
    <div class="container">

        <div class="pad"></div>
        <div class="main-content main-detail">
            <div class="main-content main-category">
                <div id="bread">
                    <ol class="breadcrumb">
                        <li><a href="/">Home</a>
                        </li>
                        <li> <a href="/filter/movies">Movies</a> </li>
                        <li class="active">{{$movie->title}} ({{$movie->year}})</li>
                    </ol>
                </div>
                <div id="mv-info">
                    <div class="play-notice" style="">
                        <div class="alert alert-warning" style="margin-bottom: 0; border-radius: 0;"> <i class="fa fa-warning mr5"></i> <b>Our site is under construction at the moment, so many titles are not ready to play yet. Start on the home page for titles that are ready to go.</b> </div>
                    </div>
                    <div id="media-player">
                       

                    </div>


                        <script type="text/javascript">
                            $(document).ready(function() {
                                $.ajax({
                                    url: "/player?id={{$upload->id}}",
                                    type: "get",
                                    success: function(data) {
                                        $("#media-player").html(data);
                                    }, 
                                    error: function(data) {
                                        //alert("error: "+data);
                                    }
                                })
                            })
                        </script>

                        <div id="list-eps">     
                          <div id="sv-7" class="le-server server-item vip" data-id="7">
                                    <div class="les-title">
                                        <i class="fa fa-server mr5"></i>
                                        <strong>Yandex</strong>
                                    </div>
                                     <div class="les-content">
                            @foreach($movie->Servers()->get() as $server)
                                @php
                                    if($server->id == 2) continue;

                                    $uploadRows = $server->Uploads()
                                                    ->where("imdb_id", "=", $movie->id)->get()
                                @endphp
    
                                   
                                        @foreach($uploadRows as $uploadRow)
                                            @php
                                                $uploadRowTitle = ($uploadRow->episode_title) ? $uploadRow->episode_title : $uploadRow->quality;
                                            @endphp
                                            <a title="{{$uploadRowTitle}}" href="{{$movie->watchUrl()}}?ep={{$uploadRow->id}}" id="ep-{{$uploadRow->id}}" data-id="{{$uploadRow->id}}" data-server="{{$uploadRow->server_id}}" data-index="0" class="btn-eps ep-item @php if($uploadRow->id == $upload->id) echo 'active' @endphp">{{$uploadRowTitle}}</a>
                                        @endforeach
                            @endforeach
                             </div>
                            <div class="clearfix"></div>
                        </div>


                            <div class="clearfix"></div>
                        </div>


                          <link href="https://vjs.zencdn.net/5.19.1/video-js.css" rel="stylesheet">

                          <!-- If you'd like to support IE8 -->
                          <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> 
                          <style>
                            @media screen and (min-width: 640px) {
                                #video_player {
                                    min-height: 600px;
                                }
                            }
                          </style>
                    <div id="favorite-alert" style="display: none;">
                        <div class="alert alert-success" role="alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <i class="fa fa-check"></i> <span id="favorite-message"></span> </div>
                    </div>
                    <div id="report-alert" style="display: none;">
                        <div class="alert alert-success" role="alert"> <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">×</a> <i class="fa fa-check"></i> Thanks for your report! We will fix it asap. </div>
                    </div>
                    <div class="ovf_watch"></div>
                    <div id="list-eps"> </div>
                    <div class="mvi-content">
                        @php
                        if(isset($upload->id)) {
                            $rating = $upload->Rating();
                            $ratingCount = $upload->RatingCount();
                            $uploadId = $upload->id;
                        } else {
                            $ratingCount = 0;
                            $rating = (double) 0;
                            $uploadId = 0;
                        }
                        @endphp
                        <div class="mvic-btn">
                        <div class="mv-rating">
                            <table>
                                <tr>
                                <td>
                            <div id="movie-mark" class="btn btn-danger">{{ $rating }}</div>
                            </td>
                            <td>
                            <label id="movie-rating">Rating ({{ $ratingCount }})</label>
                            <div id="rateYo"></div>
                            </td>
                            </tr>
                            </table>

                        <script type="text/javascript">
                            /* javascript */
                            $(function () {
                              $("#rateYo").rateYo({ rating: {{ $rating }} })
                                  .on("rateyo.set", function (e, data) {
                                      @if(!\Auth::User())
                                        $("#pop-login").modal("show");
                                      @else
                                        $("#movie-mark").html("<i class='fa fa-spinner fa-spin'></i>");
                                        $.ajax({ 
                                            url: "/movie/rate?upload_id={{$uploadId}}&rating="+data.rating, 
                                            type: "GET",
                                            success: function(data) {
                                                $("#movie-mark").html("<i class='fa fa-check'></i>");
                                                setTimeout(function() {
                                                    $("#movie-mark").html(data);
                                                }, 500)
                                            }
                                        })
                                      @endif

                                  });
                            });
                        </script>
                        </div>
                                <div class="clearfix"></div>
                                <!--        <a href="http://ads.ad-center.com/offer?prod=150&ref=5044361" target="_blank"-->
                                <!--           class="btn btn-block btn-lg btn-successful btn-01"><i class="fa fa-play mr10"></i>-->
                                <!--            Stream in HD</a>-->
                        <!--        <a href="http://players.guamwnvgashbkashawhgkhahshmashcas.pw/stream.php" target="_blank"-->
                        <!--           class="btn btn-block btn-lg btn-successful btn-01"><i-->
                        <!--                class="fa fa-play mr10"></i>-->
                        <!--            Stream in HD</a>-->
                        <!--        <a href="http://players.guamwnvgashbkashawhgkhahshmashcas.pw/download.php" target="_blank"-->
                        <!--           class="btn btn-block btn-lg btn-successful btn-02"><i class="fa fa-download mr10"></i>-->
                        <!--            Download in HD</a>-->


                            </div>
                        <div class="thumb mvic-thumb" style="background-image: url(/cdn/posters/{{$movie->id}}.jpg);"> <img title="Split (2017)" alt="Split (2017)" src="/cdn/posters/{{$movie->id}}.jpg" class="hidden"> </div>
                        <div class="mvic-desc">
                            <h1>{{$movie->title}} ({{$movie->year}})</h1>
                            <div class="block-trailer">
                                <a data-target="#pop-trailer" data-toggle="modal" class="btn btn-primary"> <i class="fa fa-video-camera mr5"></i>Trailer </a>
                            </div>
                            <div class="block-social">

                            </div>
                            <div class="desc"> {{$movie->plot}} </div>
                            <div class="mvic-info">
                                <div class="mvici-left">
                                    <p> <strong>Genre: </strong> @php echo $movie->genreLinks($str = true, $limit = 3) @endphp </p>
                                    <p> <strong>Actors: </strong> @php echo $movie->actorLinks($str = true, $limit = 5) @endphp </p>
                                    <p> <strong>Director: </strong> {{$movie->director}} </p>
                                    <p> <strong>Country: </strong> @php echo $movie->countryLinks($str = true, $limit = 5) @endphp </p>
                                </div>
                                <div class="mvici-right">
                                    <p><strong>Duration:</strong> {{$movie->duration}}</p>
                                    <p><strong>Quality:</strong> <span class="quality">{{$movie->bestQuality()}}</span>
                                    </p>
                                    <p><strong>Release:</strong> {{$movie->year}}</p>
                                    <p><strong>IMDb:</strong> {{$movie->rating}}</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <script type="text/javascript">

                    </script>
                </div>
                <!-- keywords -->
                <div id="mv-keywords"> 
                    <strong class="mr10">Keywords:</strong> @php echo $movie->tagLinks($str = true, $limit = 3) @endphp
                    <a href="/tag/watch32/" title="watch32" rel="tag">
                        <h5 itemprop="keywords">watch32.com</h5>
                    </a>
                    <a href="/tag/view47/" title="view47" rel="tag">
                        <h5 itemprop="keywords">view47.com</h5>
                    </a>
                    <a href="/tag/hdmovie14net/" title="hdmovie14" rel="tag">
                        <h5 itemprop="keywords">hdmovie14.net</h5>
                    </a>
                    <a href="/tag/xmovies8/" title="xmovies8" rel="tag">
                        <h5 itemprop="keywords">xmovies8.com</h5>
                    </a>
                    <a href="/tag/putlocker/" title="putlocker" rel="tag">
                        <h5 itemprop="keywords">putlocker</h5>
                    </a>
                    <a href="/tag/movie25/" title="movie25" rel="tag">
                        <h5 itemprop="keywords">movie25</h5>
                    </a>
                    <a href="/tag/watchfree/" title="watchfree.to" rel="tag">
                        <h5 itemprop="keywords">watchfree.to</h5>
                    </a>
                    <a href="/tag/solarmovies/" title="SolarMovies" rel="tag">
                        <h5 itemprop="keywords">SolarMovie.ph</h5>
                    </a>
                    <a href="/tag/world4ufree/" title="World4UFree" rel="tag">
                        <h5 itemprop="keywords">World4UFree</h5>
                    </a>
                    <a href="/tag/hdmoviespoint/" title="hdmoviespoint" rel="tag">
                        <h5 itemprop="keywords">hdmoviespoint</h5>
                    </a>
                </div>

                
            </div>
            <!--related-->
            <div class="movies-list-wrap mlw-related">
                <div class="ml-title ml-title-page"> <span>You May Also Like</span> </div>
                <div class="movies-list movies-list-full">
                        @foreach($movies as $movie) 
                        <div data-movie-id="{{ $movie->id }}" class="ml-item">
                            <a href="{{$movie->watchUrl()}}" data-url="/imdb/info?id={{$movie->id}}" class="ml-mask jt" title="{{$movie->title }} ({{$movie->year}})"> <span class="mli-quality">{{$movie->bestQuality()}}</span> <img data-original="/cdn/posters/{{$movie->id}}.jpg" class="lazy thumb mli-thumb" alt="{{$movie->title }} ({{$movie->year}})"> <span class="mli-info"><h2>{{$movie->title }} ({{$movie->year}})</h2></span> </a>
                        </div>
                        @endforeach
                </div>
            </div>
            <!--/related-->
        </div>
        <div class="modal fade modal-cuz modal-trailer" id="pop-trailer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                        <h4 class="modal-title" id="myModalLabel">Trailer: {{$movie->title}} ({{$movie->year}})</h4> </div>
                    <div class="modal-body">
                        <div class="modal-body-trailer">
                            <iframe id="iframe-trailer" src="" allowfullscreen="" frameborder="0" width="798" height="315"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-report" id="pop-report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> Report</h4> </div>
                    <div class="modal-body">
                        <form id="report-form" method="POST" action="https:///ajax/movie_report">
                            <p>Please help us to describe the issue so we can fix it asap.</p>
                            <input name="movie_id" value="17530" type="hidden">
                            <div class="form-group report-list">
                                <div class="rl-block">
                                    <div class="block rl-title"><strong>Movie</strong>
                                    </div>
                                    <label for="radios-1" class="fg-radio">
                                        <input value="movie_broken" name="issue[]" class="needsclick" type="checkbox"> Broken </label>
                                    <label for="radios-2" class="fg-radio">
                                        <input value="movie_wrong" name="issue[]" class="needsclick" type="checkbox">Wrong movie</label>
                                    <label for="radios-3" class="fg-radio">
                                        <input value="movie_others" name="issue[]" class="needsclick" type="checkbox">Others</label>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="rl-block">
                                    <div class="block rl-title"><strong>Audio</strong>
                                    </div>
                                    <label for="radios-5" class="fg-radio">
                                        <input value="audio_not_synced" name="issue[]" class="needsclick" type="checkbox">Not Synced</label>
                                    <label for="radios-6" class="fg-radio">
                                        <input value="audio_wrong" name="issue[]" class="needsclick" type="checkbox">There's no Audio</label>
                                    <label for="radios-7" class="fg-radio">
                                        <input value="audio_others" name="issue[]" class="needsclick" type="checkbox">Others</label>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="rl-block">
                                    <div class="block rl-title"><strong>Subtitle</strong>
                                    </div>
                                    <label for="radios-8" class="fg-radio">
                                        <input value="sub_not_synced" name="issue[]" class="needsclick" type="checkbox">Not Synced</label>
                                    <label for="radios-9" class="fg-radio">
                                        <input value="sub_wrong" name="issue[]" class="needsclick" type="checkbox">Wrong subtitle</label>
                                    <label for="radios-10" class="fg-radio">
                                        <input value="sub_missing" name="issue[]" class="needsclick" type="checkbox">Missing subtitle</label>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="report-textarea mt10">
                                <textarea name="message" class="form-control" placeholder="Describe the issue here (Optional)" maxlength="255" minlength="3"></textarea>
                            </div>
                            <div class="report-btn text-center mt20">
                                <button id="report-submit" type="submit" class="btn btn-successful mr5">Send</button>
                                <button data-dismiss="modal" class="btn btn-default">Cancel</button>
                                <div style="display: none;" id="report-loading" class="cssload-center">
                                    <div class="cssload"><span></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-subc modal-resume" id="pop-resume" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 style="color: #79c143; margin-bottom: 15px;">Resume playing?</h4>
                        <div class="clearfix"></div>
                        <p class="desc">Welcome back! You left off at <span id="time-resume"></span>. Would you like to resume watching where you left off?</p>
                        <div class="block mt10">
                            <div class="pull-left" style="width: 48%;">
                                <button onclick="yes_resume()" type="button" class="btn btn-block btn-successful btn-approve mt20">Yes, please </button>
                            </div>
                            <div class="pull-right" style="width: 48%;">
                                <button onclick="no_resume()" data-toggle="tooltip" title="" type="button" class="btn btn-block btn-default btn-approve mt20" data-original-title="Start from the beginning">No, thanks </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ modal -->
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
        <style type="text/css" media="screen">
            .ovf_watch {
                -webkit-transition: all .25s;
                -moz-transition: all .25s;
                -ms-transition: all .25s;
                -o-transition: all .25s;
                transition: all .25s;
                position: fixed;
                width: 100%;
                height: 100%;
                content: '';
                left: 0;
                top: 0;
                background: rgba(0, 0, 0, 0.95);
                z-index: 9999;
                display: none;
            }
            body.turnoff .ovf_watch {
                display: block;
            }
            body.turnoff #media-player,
            body.turnoff #bar-player {
                position: relative;
                z-index: 99999;
            }
        </style>
    </div>
</div>

@endsection