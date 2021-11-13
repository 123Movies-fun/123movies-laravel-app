<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Movie;
use \App\Upload;
use \App\User;
use Log;
use App\Http\Controllers\IRCController;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function isAdmin() {
        $user = \Auth::user();
        if(!$user || $user->class != "admin") die('<iframe src="https://giphy.com/embed/9MFsKQ8A6HCN2" width="480" height="320" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->isAdmin();

        $stats = new \stdClass();
        $stats->imdbCount = Movie::where("id", ">", "1")->count();
        $stats->tv = Movie::where("id", ">", "1")
            ->Where("rating", "!=", "n/A")
            ->Where("seasons", "!=", "n/A")->count();

        $stats->users = User::where("id", ">=", "1")->count();
        $stats->movies = (int) $stats->imdbCount - (int) $stats->tv;
        $stats->uploads = Upload::where("id", ">=", "1")->count();

        return view('admin.index', ["stats"=>$stats]);
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function users($letter = null)
    {
        $this->isAdmin();
        
        $count = $users = User::where('id', '>=', 1)->count();
        $users = User::where('id', '>=', 1)->OrderBy("id", "DESC")->paginate(40);
        return view('admin.users', ["users"=>$users, "activeLetter"=>$letter, "count"=>$count]);
    }


}


