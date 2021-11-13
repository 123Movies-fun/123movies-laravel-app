@extends('layouts.app')


@section('content')
<div id="main" class="" style="padding-top: 70px;">
    <div class="container">
        <div class="pad"></div>
        <div class="main-content main-category">
            <!--category-->
            <div class="movies-list-wrap mlw-category">
                <div class="ml-title ml-title-page">
                    <h1 style="margin:0;"><span>Movie Library</span></h1>
                    <div class="clearfix"></div>
                </div>
                <div class="ml-alphabet">
                    <div class="movies-letter"> 
                        <a class="btn btn-letter @if($activeLetter == '[0-9]') active @endif" title="0-9" href="/movies/library/0-9">0-9</a> 
                        @foreach(range('a','z') as $i) 
                          <a class="btn btn-letter @if($activeLetter == $i) active @endif" title="{{$i}}" href="/movies/library/{{$i}}">{{strtoupper($i)}}</a>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="letter-movies-lits">
                    <table class="table table-striped">
                        <tbody>
                            <tr class="mlnew-head">
                                <td colspan="2" class="mlnh-letter">{{$count}} results</td>
                                <td class="mlnh-3">Year</td>
                                <td class="mlnh-3">Quality</td>
                                <td class="mlnh-5">Country</td>
                                <td class="mlnh-4">Genre</td>
                                <td class="mlnh-6">IMDb</td>
                            </tr>

                            @foreach($movies as $movie)
                            <tr class="mlnew">
                                <td class="mlnh-thumb">
                                    <a class="thumb" title="{{$movie->title}} ({{$movie->year}})" href="{{$movie->watchUrl()}}"> <img alt="{{$movie->title}} ({{$movie->year}})" title="{{$movie->title}} ({{$movie->year}})" src="/cdn/posters/{{$movie->id}}.jpg"> </a>
                                </td>
                                <td class="mlnh-2">
                                    <h2><a title="{{$movie->title}} ({{$movie->year}})" href="{{$movie->watchUrl()}}">
                                        {{$movie->title}}
                                    </a></h2> </td>
                                <td>{{$movie->year}}</td>
                                <td class="mlnh-3">{{$movie->bestQuality()}}</td>
                                <td class="mlnh-4">
                                    @php echo $movie->countryLinks($str = true, $limit = 3) @endphp
                                </td>
                                <td class="mlnh-5">
                                    @php echo $movie->genreLinks($str = true, $limit = 3) @endphp

                                </td>
                                <td class="mlnh-6"> <span class="label label-warning">{{$movie->rating}}</span> </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="pagination" style="margin: 0;">
                    <nav>
                        {{ $movies->links() }}
                    </nav>
                </div>
            </div>
            <!--/category-->
        </div>
    </div>
</div>
@endsection
