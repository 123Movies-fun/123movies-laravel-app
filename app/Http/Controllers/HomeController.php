<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Movie;
use \App\Upload;
use \App\Server;
use Log;
use App\Http\Controllers\IRCController;
use Illuminate\Support\Facades\Redis;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::where("id", ">=", "1")
            ->where("seasons", "=", "n/A")
            ->OrderBy("player_status", "DESC")
            ->OrderBy("updated_at", "DESC")->Limit(15)->get();

        $tvs = Movie::where("id", ">=", "1")
            ->where("seasons", "!=", "n/A")
            ->OrderBy("player_status", "DESC")
            ->OrderBy("updated_at", "DESC")->Limit(15)->get();

        return view('home', ["movies"=>$movies, "tvs"=>$tvs]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function donate()
    {
        return view('donate');
    }

        /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function movieSearch($keyword)
    {
        $keyword = str_replace("_", " ", $keyword);
        $movies = Movie::where("title", "LIKE", "%".$keyword."%")->get();
        return view('movieSearch', ["movies"=>$movies, 'keyword'=>$keyword]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function watch($title)
    {
        $id = explode("-", $title);
        $id = end($id);
        
        $movie = Movie::where("id", "=", $id)->first();
        if(!$movie) return response()->json(['error' => 'Movie not found.']);
        $uploads = $movie->Uploads();

        if(!isset($_GET["ep"])) {
            $preferredUpload = $movie->Uploads()
            ->where("imdb_id", "=", $movie->id)
            ->where("referral_url", "LIKE", "%yadi%")
            ->where("status", "=", "success")
            ->first();
        } else {
            $preferredUpload = $movie->Uploads()
            ->where("id", "=", $_GET["ep"])
            ->where("status", "=", "success")
            ->first();
        }

        if(!$preferredUpload) $preferredUpload = $movie->Uploads()->first();

        /* Related titles */
        $movies = Movie::where('id', '>', 1)
            ->OrderBy("player_status", "DESC")
            ->OrderBy("title", "ASC")->Limit(10)->get();


        return view('watch.index', ["movie"=>$movie, "uploads"=>$uploads->get(), "upload"=>$preferredUpload, "movies"=>$movies]);
    }


}




/*
    Yandex account import
    public function dbImport() {

        $txt = (\File::get("/var/www/harsh/public/c5a414a53ac733e9f801aeaa20001657.txt")); 

        $arr = explode("\n", $txt);
        array_pop($arr);

        foreach($arr as $row) {
            $elements = explode(":", $row);
            $username = $elements[0];
            $password = $elements[1];
            $phone = $elements[2];

            echo "<b>Username:</b> ".$username;
            echo "<b>password:</b> ".$password;
            echo "<b>phone:</b> ".$phone;

            $server = new Server;
            $server->type = "yandex";
            $server->username = $username;
            $server->password = $password;
            $server->api_data = json_encode(Array("phone"=>$phone));
            $server->ip = "";
            $server->hostname = "";
            $server->http_url = "";
            $server->save();
        }

    }
*/


function curl($url)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}