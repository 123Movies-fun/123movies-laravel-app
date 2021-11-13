<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
@section("title", "Watch Movies Online Free - 123movies.fun")
@section("description", "Watch HD Movies Online For Free and Download the latest movies without Registration at 123movies.fun")
@section("keywords", "123movies, 123movies.fun, watch hd movies, watch HD films, Hot new movies")
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="content-language" content="en" />
    <meta name="description" content="@yield('description')" />
    @php /* <meta name="keywords" content="@yield('keywords')" /> */ @endphp
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="/images/favicon2.png" type="image/x-icon" />
    <link rel="canonical" href="@php echo Request::url(); @endphp" />
    <meta property="og:type" content="website" />
    <meta property="og:image:width" content="364" />
    <meta property="og:image:height" content="500" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="article:publisher" content="https://www.facebook.com/123movies.to" />
    <meta property="og:url" content="@php echo Request::url(); @endphp" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:site_name" content="123movies.fun" />
    <meta property="og:updated_time" content="" />
    <meta property="fb:app_id" content="" />
    <meta name="google-site-verification" content="" />
    <link rel="stylesheet" href="/bootstrap-3.3.7-dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css"> 
    
    <link rel="stylesheet" href="/css/main.css" type="text/css" />
    <link rel="stylesheet" href="/css/jquery.cluetip.css" type="text/css" />
    <link rel="stylesheet" href="/css/jquery.qtip.min.css" type="text/css" />
    <link rel="stylesheet" href="/css/custom.css?v=1.1" type="text/css" />
    <link rel="stylesheet" href="/css/slide.css" type="text/css" />
    <link rel="stylesheet" href="/css/psbar.css" type="text/css" />
    <link rel="stylesheet" href="/css/star-rating.css" type="text/css" />
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery.lazyload.js"></script>
    <script type="text/javascript" src="/js/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="/js/md5.min.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/123movies.v0.2.min.js?v=0.8"></script>
    <script type="text/javascript" src="/js/psbar.jquery.min.js"></script>
    <script type="text/javascript" src="/js/star-rating.js"></script>
    <script src="/js/detectmobilebrowser.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script> 

</head>

<body>
    <div id="switch-mode">
        <div class="sm-icon"><i class="fa fa-moon-o"></i>
        </div>
        <div class="sm-text">Night mode</div>
        <div class="sm-button"><span></span>
        </div>
    </div>
    <script type="text/javascript">
        if ($.cookie("night-mode")) {
            $("#switch-mode").addClass("active");
            $("head").append("<link href='/css/main-dark.css?v=0.5' type='text/css' rel='stylesheet' />");
        } else {
            $("#switch-mode").removeClass("active");
        }
        $('#switch-mode').click(function() {
            if ($.cookie("night-mode")) {
                $.removeCookie("night-mode", {
                    path: '/'
                });
            } else {
                $.cookie("night-mode", 1, {
                    expires: 365,
                    path: '/'
                });
            }
            location.reload();
        });
    </script>
    <!--header-->
    <header>
        <div class="container">
            <div class="header-logo">
                <a title="Watch Your Favorite Movies Online" href="https://123movies.fun" id="logo"></a>
            </div>
            <div class="mobile-menu"><i class="fa fa-reorder"></i>
            </div>
            <div class="mobile-search"><i class="fa fa-search"></i>
            </div>
            <div id="menu">
                <ul class="top-menu">
                    <li class=""> <a href="https://123movies.fun" title="Home">HOME</a> </li>
                    <li class=""> <a href="#" title="Genre">GENRE</a>
                        <div class="sub-container" style="display: none">
                            <ul class="sub-menu">
                                <li> <a href="https://123movies.fun/genre/action/">Action</a> </li>
                                <li> <a href="https://123movies.fun/genre/adventure/">Adventure</a> </li>
                                <li> <a href="https://123movies.fun/genre/animation/">Animation</a> </li>
                                <li> <a href="https://123movies.fun/genre/biography/">Biography</a> </li>
                                <li> <a href="https://123movies.fun/genre/comedy/">Comedy</a> </li>
                                <li> <a href="https://123movies.fun/genre/crime/">Crime</a> </li>
                                <li> <a href="https://123movies.fun/genre/documentary/">Documentary</a> </li>
                                <li> <a href="https://123movies.fun/genre/drama/">Drama</a> </li>
                                <li> <a href="https://123movies.fun/genre/family/">Family</a> </li>
                                <li> <a href="https://123movies.fun/genre/fantasy/">Fantasy</a> </li>
                                <li> <a href="https://123movies.fun/genre/history/">History</a> </li>
                                <li> <a href="https://123movies.fun/genre/horror/">Horror</a> </li>
                                <li> <a href="https://123movies.fun/genre/musical/">Musical</a> </li>
                                <li> <a href="https://123movies.fun/genre/mystery/">Mystery</a> </li>
                                <li> <a href="https://123movies.fun/genre/romance/">Romance</a> </li>
                                <li> <a href="https://123movies.fun/genre/sci-fi/">Sci-Fi</a> </li>
                                <li> <a href="https://123movies.fun/genre/sport/">Sport</a> </li>
                                <li> <a href="https://123movies.fun/genre/thriller/">Thriller</a> </li>
                                <li> <a href="https://123movies.fun/genre/reality-tv/">TV Show</a> </li>
                                <li> <a href="https://123movies.fun/genre/war/">War</a> </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                    <li class=""> <a href="#" title="Country">COUNTRY</a>
                        <div class="sub-container" style="display: none">
                            <ul class="sub-menu">
                                <li> <a href="https://123movies.fun/country/south-korea">South Korea</a> </li>
                                <li> <a href="https://123movies.fun/country/china">China</a> </li>
                                <li> <a href="https://123movies.fun/country/france">France</a> </li>
                                <li> <a href="https://123movies.fun/country/russia">Russia</a> </li>
                                <li> <a href="https://123movies.fun/country/india">India</a> </li>
                                <li> <a href="https://123movies.fun/country/canada">Canada</a> </li>
                                <li> <a href="https://123movies.fun/country/japan">Japan</a> </li>
                                <li> <a href="https://123movies.fun/country/korea">Korea</a> </li>
                                <li> <a href="https://123movies.fun/country/tw">Taiwan</a> </li>
                                <li> <a href="https://123movies.fun/country/thailand">Thailand</a> </li>
                                <li> <a href="https://123movies.fun/country/uk">United Kingdom</a> </li>
                                <li> <a href="https://123movies.fun/country/usa">United States</a> </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                    <li> <a href="https://123movies.fun/tv-series" title="TV - Series">TV - SERIES</a> </li>
                    <li class=""> <a href="/movies/imdbtop" title="Top IMDb">TOP IMDb</a> </li>
                    <li class=""> <a href="https://123movies.fun/movies/library" title="A-Z List">A - Z LIST</a> </li>
                    <li class=""> <a href="https://123movies.fun/articles/news" title="News">NEWS</a> </li>
                    <li onclick="goRequestPage('https://123movies.fun/user/request')" class=""> <a href="#" title="Request movies">REQUEST</a> </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            @if(!\Auth::User())
                <div id="top-user"><div class="top-user-content guest"><a href="#" class="btn btn-successful btn-login" title="Login" data-target="#pop-login" data-toggle="modal">LOGIN</a></div></div>
            @else 
                <div id="top-user"><div class="top-user-content logged">
                 <div class="logged-feed" style="display: none;"> 
                 <a onclick="loadNotify()" href="#" class="btn btn-logged btn-feed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fa fa-bell-o"></i><span class="feed-number"></span>
                 </a>
                 <ul class="dropdown-menu" id="list-notify">
                 <li id="loading-notify" class="more cssload-center">
                 <div class="cssload"><span></span></div>
                 </li>
                 </ul>
                 </div>
                 <div class="logged-user">
                 <a href="#" class="avatar user-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                 <img class="my_avatar" src="@php echo Auth::User()->Avatar() ? Auth::User()->Avatar() : '/images/default_avatar.jpg' @endphp"> <i class="fa fa-chevron-down"></i>
                 </a>
                 <ul class="dropdown-menu">
                 <li> <a href="/user/profile"><i class="fa fa-user mr5"></i> Profile</a> </li>
                 <li><a href="/movies/favorites"><i class="fa fa-heart mr5"></i> My movies</a></li>
                 <li> <a href="/donate"><i class="fa fa-gift mr5"></i> Donate</a> </li>
                 @if(\Auth::user()->isAdmin() == true) 
                    <li> <a href="/admin"><i class="fa fa-cubes mr5"></i> Admin</a> </li>
                 @endif
                 <li><a href="/logout"><i class="fa fa-power-off mr5"></i> Logout</a></li>
                 </ul>
                 </div>
                </div></div>
            @endif
            @php
                if(!isset($keyword)) $keyword = "";
            @endphp
            <div id="search">
                <div class="search-content">
                    <input maxlength="100" autocomplete="off" name="keyword" type="text" class="form-control search-input" placeholder="Searching..." value="{{$keyword}}" /> <a onclick="searchMovie()" class="search-submit" href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a>
                    <div class="search-suggest" style="display: none;"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </header>
    <!--/header-->
    <div class="header-pad"></div>

    @yield("content")

    <!--footer-->
    <footer>
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 footer-one">
                        <div class="footer-link">
                            <h3 class="footer-link-head">123movies</h3>
                            <p><a title="Movies" href="https://123movies.fun/movie/filter">Movies</a>
                            </p>
                            <p><a title="Top IMDb" href="https://123movies.fun/movie/topimdb">Top IMDb</a>
                            </p>
                            <p><a title="DMCA" href="https://123movies.fun/site/dmca-policy">DMCA</a>
                            </p>
                            <p><a title="FAQ" href="https://123movies.fun/site/faqs">FAQ</a>
                            </p>
                        </div>
                        <div class="footer-link">
                            <h3 class="footer-link-head">Movies</h3>
                            <p><a title="Action" href="https://123movies.fun/genre/action/">Action</a>
                            </p>
                            <p><a title="History" href="https://123movies.fun/genre/history/">History</a>
                            </p>
                            <p><a title="Thriller" href="https://123movies.fun/genre/thriller/">Thriller</a>
                            </p>
                            <p><a title="Sci-Fi" href="https://123movies.fun/genre/sci-fi/">Sci-Fi</a>
                            </p>
                        </div>
                        <div class="footer-link end">
                            <h3 class="footer-link-head">TV-Series</h3>
                            <p><a title="United States" href="https://123movies.fun/movie/filter/series">United States</a>
                            </p>
                            <p><a title="Korea" href="https://123movies.fun/movie/filter/series">Korea</a>
                            </p>
                            <p><a title="China" href="https://123movies.fun/movie/filter/series">China</a>
                            </p>
                            <p><a title="Taiwan" href="https://123movies.fun/movie/filter/series">Taiwan</a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-4 footer-subs">
                        <h3 class="footer-link-head">Subscribe</h3>
                        <p class="desc">Subscribe to <strong>123Movies</strong> mailing list to receive updates on movies, tv-series and news</p>
                        <div class="form-subs mt20">
                            <div class="subc-input pull-left" style="width:65%; margin-right: 5%;">
                                <input type="email" placeholder="Enter your email" id="Email" name="email-footer" class="form-control"> </div>
                            <div class="subc-submit pull-left" style="width:30%;">
                                <button id="subscribe-submit-footer" class="btn btn-block btn-successful btn-approve" type="button" onclick="subscribe_footer()">Subscribe </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="error-email-subs-footer" class="alert alert-danger error-block"></div>
                        <div id="success-subs-footer" class="alert alert-success error-block"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-4 footer-copyright">
                        <p><img border="0" src="/images/logo.png" class="mv-ft-logo">
                        </p>
                        <p>Copyleft <span class="copyleft">&copy;</span> <strong>123movies.fun</strong>. No Rights Reserved</p>
                        <p style="font-size: 11px; line-height: 14px; color: rgba(255,255,255,0.4)">Disclaimer: This site does not store any files on its server. All contents are provided by non-affiliated third parties.</p> <a href="https://123movies.fun/sitemap.html" title="">Sitemaps</a> </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </footer>
    <style>
    .copyleft {
      display:inline-block;
      transform: rotate(180deg);
      font-size: 14px;
      position: relative;
    }
    </style>
    <!--/footer-->
    <!-- Modal -->
    <div class="modal fade modal-cuz" id="pop-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                    <h4 class="modal-title" id="myModalLabel">MEMBER LOGIN AREA</h4> </div>
                <div class="modal-body">
                    <p class="desc">Watch HD Movies Online For Free and Download the latest movies. For everybody, everywhere, everydevice, and everything ;)</p>
                    <form id="login-form" method="POST" action="/user/login">
                        {{ csrf_field() }}
                        <div class="block">
                            <input required type="text" class="form-control" name="email" id="email" placeholder="Username or Email"> </div>
                        <div class="block mt10">
                            <input required type="password" class="form-control" name="password" id="password" placeholder="Password"> </div>
                        <div style="display: none;" id="error-message" class="alert alert-danger"></div>
                        <div class="block mt10 small">
                            <label>
                                <input name="remember" type="checkbox" style="vertical-align: sub; margin-right: 3px;"> Remember me</label>
                            <div class="pull-right"> <a id="open-forgot" data-dismiss="modal" data-target="#pop-forgot" data-toggle="modal" title="Forgot password?">Forgot password?</a> </div>
                        </div>
                        <button id="login-submit" type="submit" class="btn btn-block btn-successful btn-approve mt10"> Login </button>
                        <div style="display: none;" id="login-loading" class="cssload-center">
                            <div class="cssload"><span></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center"> Not a member yet? <a id="open-register" data-dismiss="modal" data-target="#pop-register" data-toggle="modal" title="">Join now!</a> </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-cuz" id="pop-register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                    <h4 class="modal-title" id="myModalLabel">You are welcome</h4> </div>
                <div class="modal-body">
                    <p class="desc">When becoming members of the site, you could use the full range of functions and enjoy the most exciting films.</p>
                    <form id="register-form" method="POST" action="/user/register">
                        {{ csrf_field() }}

                        <div id="register-error-message" class="alert alert-danger error-block"></div>


                        <div class="block mt10">
                            <input required type="text" class="form-control" name="username" id="username" placeholder="Username"> </div>
                        <div id="error-username" class="alert alert-danger error-block"></div>
                        <div class="block mt10">
                            <input required type="email" class="form-control" name="email" id="email" placeholder="Email"> </div>
                        <div id="error-email" class="alert alert-danger error-block"></div>
                        <div class="block mt10">
                            <input required type="password" class="form-control" name="password" id="password" placeholder="Password"> </div>
                        <div id="error-password" class="alert alert-danger error-block"></div>
                        <div class="block mt10">
                            <input required type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Confirm Password"> </div>
                        <button id="register-submit" type="submit" class="btn btn-block btn-successful btn-approve mt20"> Register </button>
                        <div style="display: none;" id="register-loading" class="cssload-center">
                            <div class="cssload"><span></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center"> <a id="open-register" style="color: #888" data-dismiss="modal" data-target="#pop-login" data-toggle="modal" title=""><i class="fa fa-chevron-left mr10"></i> Back to login</a> </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-cuz" id="pop-forgot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                    <h4 class="modal-title" id="myModalLabel">Forgot Password</h4> </div>
                <div class="modal-body">
                    <p class="desc">We will send a new password to your email. Please fill your email to form below.</p>
                    <form id="forgot-form">
                    {{ csrf_field() }}
                        <div class="block mt10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your email" required> </div>
                        <div style="display: none;" id="forgot-success-message" class="alert alert-success"></div>
                        <div style="display: none;" id="forgot-error-message" class="alert alert-danger"></div>
                        <button id="forgot-submit" type="submit" class="btn btn-block btn-successful btn-approve mt20"> Submit </button>
                        <div style="display: none;" id="forgot-loading" class="cssload-center">
                            <div class="cssload"><span></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center"> <a id="open-register" style="color: #888" data-dismiss="modal" data-target="#pop-login" data-toggle="modal" title=""><i class="fa fa-chevron-left mr10"></i> Back to login</a> </div>
            </div>
        </div>
    </div>
    <!--/ modal -->
    <div class="modal fade modal-cuz" id="pop-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> </button>
                </div>
                <div class="modal-body" id="message-content" style="text-align: center"></div>
            </div>
        </div>
    </div>
    <div class="alert-bottom" style="display: none;">
        <div class="container">
            <div class="alert-bottom-content">
                <p class="desc">Please Follow us on <strong>Twitter/Facebook</strong> to receive latest news about 123Movies</p>
            </div>
            <div class="ab-follow"> <span class="abf-text">Follow Us</span>
                <div class="abf-btn">
                    <div class="fb-like" data-href="https://www.facebook.com/123movies.UK/" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div> <a class="twitter-follow-button" data-show-count="false" href="https://twitter.com/123MoviesUK">Follow @123moviesUK</a>
                    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                    <style type="text/css">
                        .ab-follow {
                            float: left;
                            width: 360px;
                            max-width: 100%;
                            padding: 12px 15px;
                            background: #fff;
                            height: 44px;
                            color: #333;
                            border-radius: 3px;
                            margin-top: 3px;
                        }
                        .abf-text {
                            float: left;
                            font-size: 12px;
                            margin-right: 15px;
                            line-height: 20px;
                        }
                        .abf-btn .fb-like {
                            float: left;
                            margin-right: 10px;
                        }
                        .abf-btn {
                            font-size: 0;
                        }
                    </style>
                </div>
            </div>
            <div title="Close" class="alert-bottom-close" id="alert-bottom-close"> <i class="fa fa-close"></i> </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div id="alert-cookie" role="alert" class="alert alert-warning alert-cookie" style="display: none;">
        <button type="button" class="close ml10" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button> <i class="fa fa-warning mr5" style="color:#C30;"></i> You need to enable browser's cookie to stream. <a href="https://123movies.fun/how-to-enable-browser-cookie" title="">Click here for instruction.</a>
    </div>
    <script>


        $("body").on("click", ".favorite-btn", function() {

            @if(!\Auth::User())
                $("#pop-login").modal("show")
            @else
                var intitialState = $(this).text().trim();
                var that = this;
                var movie_id = $(this).data("id");
                var title = $(this).data("title");

                $(this).html("<i class='fa fa-spinner fa-spin'></i> Loading")
                $.ajax({
                    url: "/movie/favorite?movie_id="+movie_id,
                    type: "get",
                    success: function(data) {
                        
                        $(that).html("<i class='fa fa-check'></i> Success");
                        setTimeout(function() {

                            $("#favorites_list").find("[data-movie-id='" + movie_id + "']").fadeOut("fast");

                            if(intitialState == "Favorite") {
                                var action = "added to";
                                $(that).html("<i class='fa fa-close'></i> Remove Favorite");
                            }
                            else {
                                var action = "removed from";
                                $(that).html("<i class='fa fa-heart'></i> Favorite");
                            }

                            $(".qtip-content").hide();
                            $("#message-content").html('<strong>'+title+'</strong> has been '+action+' <a title="Your favorite list" href="/movies/favorites">your favorite list.</a>').click();
                            $("#pop-alert").modal("show");

                        }, 500);



                    }
                })
            @endif
        });

        if (!isCookieEnabled()) {
            $('#alert-cookie').css('display', 'block');
            $('body').addClass('off-cookie');
        }
    </script>
    <script type="text/javascript" src="/bootstrap-3.3.7-dist/js/bootstrap.min.js?v=0.1"></script>
    <script type="text/javascript" src="/js/bootstrap-select.js?v=0.1"></script>
    <script type="text/javascript" src="/js/slider.min.js"></script>
    <script type="text/javascript" src="/js/dropzone.js"></script>

</body>

</html>