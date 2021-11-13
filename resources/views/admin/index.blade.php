@extends('layouts.app')

@section('title', '123Movies.io Clone')

@section('content')
    <div id="main" class="">
<div class="container">
        <div class="pad"></div>
        <div class="main-content main-detail">
            <div id="bread">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="active">Admin</li>
                </ol>
            </div>
            <div class="profiles-wrap donate" style="padding: 10px;">
                
                

                <h3 style="margin-top: 3px;"><i class="fa fa-bar-chart"></i> Some Stats</h3>
                <p>Imdb: {{number_format($stats->imdbCount)}} ({{number_format($stats->movies)}} movies & {{number_format($stats->tv)}} tv)</p>
                <p>Uploads: {{number_format($stats->uploads)}}</p>
                <p>Users: {{number_format($stats->users)}} [<a href="/admin/users">View users list</a>]</p>


                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    </div>
@endsection
