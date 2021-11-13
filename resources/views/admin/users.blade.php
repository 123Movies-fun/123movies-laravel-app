@extends('layouts.app')

@section('title', '123Movies.io Clone')

@section('content')
<div id="main" class="" style="padding-top: 70px;">
    <div class="container">
        <div class="pad"></div>
        <div class="main-content main-category">
            <!--category-->
            <div class="movies-list-wrap mlw-category">
                <div class="ml-title ml-title-page">
                    <h1 style="margin:0;"><span>User List ({{$count}} results)</span></h1>
                    <div class="clearfix"></div>
                </div>
                <div class="letter-movies-lits">
                    <table class="table table-striped">
                        <tbody>
                            <tr class="mlnew-head">
                                <td class="mlnh-letter"></td>
                                <td class="mlnh-2">Username</td>
                                <td class="mlnh-3">Email</td>
                                <td class="mlnh-4">Created At</td>
                                <td class="mlnh-5">Last Logged In</td>
                                <td class="mlnh-6">Class</td>
                            </tr>

                            @foreach($users as $user)
                            <tr class="mlnew">
                                <td class="mlnh-thumb">
                                    <img class="avatar" style="width: 50px; height: 50px;border-radius: 50%;" src="@php echo $user->Avatar() ? $user->Avatar() : '/images/default_avatar.jpg' @endphp">
                                </td>
                                <td class="mlnh-2">
                                    {{$user->name}}
                                </td>
                                <td>{{$user->email}}</td>
                                <td class="mlnh-3">{{$user->created_at}}</td>
                                <td class="mlnh-4">
                                    @php
                                        $dt     = \Carbon\Carbon::now();
                                        $past = \Carbon\Carbon::createFromTimestamp(strtotime($user->created_at));
                                        $time_ago = $dt->diffForHumans($past); 
                                    @endphp
                                   {{$time_ago}} 
                                </td>
                                <td class="mlnh-5"> <span class="label @php if($user->class == 'user') echo 'label-warning'; else echo 'label-danger'; @endphp">{{$user->class}}</span> </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="pagination" style="margin: 0;">
                    <nav>
                        {{ $users->links() }}
                    </nav>
                </div>
            </div>
            <!--/category-->
        </div>
    </div>
</div>
@endsection
