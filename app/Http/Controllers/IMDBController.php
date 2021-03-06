<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

use auth;
use Redirect;
use App\Movie;
use App\Cast;
use App\Tag;
use \App\Genre;
use App\Certification;
use DB;
use View;
use Log;
use Input;
use App\Http\Controllers\IRCController;
use App\Rating;
use App\Upload;
use App\Favorite;

class IMDBController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
    }


    public function userRating(Request $request) {
        $upload = Upload::find($request->upload_id);
        $rating = Rating::where("upload_id", "=", $upload->id)->Where("user_id", "=", Auth::User()->id)->first();
        if($rating) {
            $rating->rating = doubleval($request->rating);
            $rating->save();
        } else {
            $rating = new Rating;
            $rating->rating = doubleval($request->rating);
            $rating->user_id = Auth::user()->id;
            $rating->upload_id = $request->upload_id;
            $rating->save();
        }
        die($upload->Rating());
    }


    public function userFavorite(Request $request) {
        $movie = Movie::find($request->movie_id);
        $favorite = Favorite::where("imdb_id", "=", $movie->id)->Where("user_id", "=", Auth::User()->id)->first();
        if($favorite) {
            $favorite->delete();
        } else {
            $rating = new Favorite;
            $rating->user_id = Auth::user()->id;
            $rating->imdb_id = $request->movie_id;
            $rating->save();
        }
    }

    /**
        * Index view for community listing table.
        *
        * @param  Request $request
        * @return Response
    */
    public function insertNew($title)
    {
        $oIMDB = new \IMDB($title);
        if ($oIMDB->isReady) {
            $data = $oIMDB->getAll();
            $count = Movie::where("url", $data["Url"]["value"])->count();
            if(!$count) {
                $dt = explode("(", $data["ReleaseDate"]["value"]);

                $movie = new Movie;
                $movie->title = $data["Title"]["value"];
                $movie->akas = $data["Akas"]["value"];
                $movie->aspect_ratio = $data["AspectRatio"]["value"];
                $movie->awards = $data["Awards"]["value"];
                $movie->company = $data["Company"]["value"];
                $movie->country = $data["Country"]["value"];
                $movie->creator = $data["Creator"]["value"];
                $movie->director = $data["Director"]["value"];
                $movie->is_released = $data["IsReleased"]["value"];
                $movie->language = $data["Language"]["value"];
                $movie->location = $data["Location"]["value"];
                $movie->mpaa = $data["MPAA"]["value"];
                $movie->plot = $data["Plot"]["value"];
                $movie->tagline = $data["Tagline"]["value"];
                $movie->poster = $data["Poster"]["value"];
                $movie->rating = $data["Rating"]["value"];
                $movie->runtime = $data["Runtime"]["value"];
                if($dt[0] != "n/A") $movie->release_date = Carbon::parse($dt[0]);
                    else $movie->release_date = Carbon::now();

                $movie->seasons = $data["Seasons"]["value"];
                $movie->soundmix = $data["SoundMix"]["value"];
                $movie->trailer_link = $data["TrailerLinked"]["value"];
                $movie->url = $data["Url"]["value"];
                $movie->user_review = $data["UserReview"]["value"];
                $movie->votes = intval($data["Votes"]["value"]);
                $movie->year = intval($data["Year"]["value"]);
                $movie->save();

                /* Download the movie poster to local CDN */
                $this->getPoster($data, $movie);

                /* Insert Cast & Characters into DB */
                $this->insertCast($data, $movie);

                /* Loop Plot Keywords & Insert into DB */
                $this->insertTags($data, $movie);

                /* Loop Genre & Insert into DB */
                $this->insertGenre($data, $movie);

                /* Loop Certifications & Insert into DB */
                $this->insertCertifications($data, $movie);
            } else return false;
        } else {
            return false;
        }
        Log::info('[IMDB] New IMDB Title: '.$movie->title." (".$movie->year.")");
        $colors = IRCController::colors();
        IRCController::alert($colors["red"].'[New IMDB]'.$colors["nc"].' Movie Created - '.$movie->title." (".$movie->year.")", "#pre");

        return $movie;
    }


    /**
        * Index view for community listing table.
        *
        * @param  Request $request
        * @return Response
    */
    public function insertTVSeason($data)
    {

        $data = json_decode(Input::get('data'));
        $count = Movie::where("url", $data->theTitle)->count();
        if(!$count) {
            $movie = new Movie;
            $movie->title = $data->theTitle;
            $movie->country = $data->theCountry;
            $movie->director = $data->theDirectors; 
            $movie->plot = $data->thePlot;
            $movie->poster = $data->coverPhoto;
            $movie->rating = $data->imdbRating;
            $movie->runtime = $data->theDuration;
            if($data->theDuration != "n/A") $movie->release_date = Carbon::parse($data->theYear);
                else $movie->release_date = Carbon::now();
            $movie->seasons = $data->theSeason;
            $movie->trailer_link = $data->theTrailer;
            $movie->year = intval($data->theYear);
            $movie->save();

            /* Download the movie poster to local CDN */
            $this->getPoster($data, $movie);

            /* Insert Cast & Characters into DB */
            $this->insertCast($data, $movie);

            /* Loop Plot Keywords & Insert into DB */
            $this->insertTags($data, $movie);

            /* Loop Genre & Insert into DB */
            $this->insertGenre($data, $movie);

            Log::info('[IMDB] New IMDB Title: '.$movie->title." (".$movie->year.")");
            $colors = IRCController::colors();
            IRCController::alert($colors["red"].'[New IMDB]'.$colors["nc"].' TV Created: - '.$movie->title." (".$movie->year.")", "#pre");

            return $movie;
        }
    }


    public function getPoster($data, $movie) {
        $img = '/var/www/harsh/public/cdn/posters/'.$movie->id.".jpg";
        if(file_put_contents($img, file_get_contents($movie->poster)))  return true;
    }

    /**
        * Insert Cast DB Data from imdb $data and $movie object;
        *
        * @param  (Array) $data, (Object) $movie 
        * @return null
    */
    public function InsertCast($data, $movie) {

        if(is_object($data)) {
            $castLinks = explode(",", $data->theActors);
            foreach($castLinks as $row) {
                $actor = trim($row);

                $cast = new Cast;
                $cast->actor = $actor;
                $cast->character = "";
                $cast->imdb_id = $movie->id;
                $cast->save();
            }
        } else {
            $castLinks = explode(" / <", $data["CastAndCharacterLinked"]["value"]);
            foreach($castLinks as $row) {
                $row = explode('">', $row);
                $row = end($row);
                $row = explode("as", $row);
                $actor = str_replace("</a>", "", $row[0]);
                $character = $row[1];

                $cast = new Cast;
                $cast->actor = $actor;
                $cast->character = $character;
                $cast->imdb_id = $movie->id;
                $cast->save();
            }
        }
    }

    /**
        * Insert new Tags and imdb_tags relation rows into DB
        *
        * @param  (Array) $data, (Object) $movie 
        * @return null
    */
    public function InsertTags($data, $movie) {

        if(is_object($data)) {
            $keywords = explode("|", $data->keywords);
            foreach($keywords as $row) {
                $tag = Tag::where("tag", $row)->first();
                if(!$tag) {
                    $tag = new Tag;
                    $tag->tag = $row;
                    $tag->save();
                }
                DB::Table("imdb_tags")->Insert(['tag_id' => $tag->id, 'imdb_id' => $movie->id]);
            }
        } else {
            $keywords = explode("/", $data["PlotKeywords"]["value"]);
            foreach($keywords as $row) {
                $tag = Tag::where("tag", $row)->first();
                if(!$tag) {
                    $tag = new Tag;
                    $tag->tag = $row;
                    $tag->save();
                }
                DB::Table("imdb_tags")->Insert(['tag_id' => $tag->id, 'imdb_id' => $movie->id]);
            }
        }
    }

    /**
        * Insert new Genres and imdb_genres relation rows into DB
        *
        * @param  (Array) $data, (Object) $movie 
        * @return null
    */
    public function insertGenre($data, $movie) {

        if(is_object($data)) {
            $genre = explode(",", $data->theGenres);
            foreach($genre as $row) {
                $genre = Genre::where("genre", $row)->first();
                if(!$genre) {
                    $genre = new Genre;
                    $genre->genre = $row;
                    $genre->save();
                }
                DB::Table("imdb_genres")->Insert(['genre_id' => $genre->id, 'imdb_id' => $movie->id]);
            }
        } else {
            $genre = explode("/", $data["Genre"]["value"]);
            foreach($genre as $row) {
                $genre = Genre::where("genre", $row)->first();
                if(!$genre) {
                    $genre = new Genre;
                    $genre->genre = $row;
                    $genre->save();
                }
                DB::Table("imdb_genres")->Insert(['genre_id' => $genre->id, 'imdb_id' => $movie->id]);
            }
        }
    }

    /**
        * Insert new Certifications and imdb_certifications relation rows into DB
        *
        * @param  (Array) $data, (Object) $movie 
        * @return null
    */
    public function insertCertifications($data, $movie) {
        $certifications = explode(" | ", $data["Certification"]["value"]);
        foreach($certifications as $row) {
            $certification = Certification::where("certification", $row)->first();
            if(!$certification) {
                $certification = new Certification;
                $certification->certification = $row;
                $certification->save();
            }
            DB::Table("imdb_certifications")->Insert(['certification_id' => $certification->id, 'imdb_id' => $movie->id]);
        }
    }


    /* ------------ Everything below this line is a "show" blade/view controller method ---------------- */

    
    public function info(Request $request) {
        $movie = Movie::find($request->input("id"));
        if(!$movie)  return response()->json(['error' => 'Movie not found.']);
        $uploads = $movie->uploads();
        return view('layouts.hover_info', ["movie"=>$movie, "uploads"=>$uploads]);
    }


    public function player(Request $request) {
        $upload = Upload::find($request->input("id"));
        if(!$upload)  return response()->json(['error' => 'Upload not found.']);
        $movie = $upload->Movie();

        /* Got uploads? */
        if(isset($upload->ident_id)) {

            /* Cache player url in redis for 4 hours */
            $file = Redis::get('playerUrl:'.$upload->id);
            if(!$file) {
                $json = file_get_contents(
                    'https://cloud-api.yandex.net/v1/disk/public/resources/download?public_key='.$upload->referral_url
                );
                $arr = json_decode($json);
                $file = $arr->href;
                Redis::set('playerUrl:'.$upload->id, $file);
                Redis::expire('playerUrl:'.$upload->id,(60*60)*3); 
            }     

            /* Try our local cloudbot redirector API 
            //$api = 'http://cloudbot2.123movies.fun/gdrive/?v=https://drive.google.com/file/d/'.$uploads->first()->ident_id.'/view';
            //$curl = curl($api);
            //$data = json_decode($curl);

            //If we got a response, use that URL for streaming, otherwise deploy alt-methods 
            if(is_array($data) && is_object($data->link)) {
                if(isset(end($data->link)->file)) $file = end($data->link)->file;
                    else $file = null;
            } else {
                $api = 'http://api.anyplayer.net/?url='.$uploads->first()->referral_url;
                $curl = curl($api);
                $data = json_decode($curl);
                if(is_object($data)) $file = end($data->link)->file;
                    else $file = null;
            }
            
             Still no stream URL... oh noes */
            if($file == null) { 
                $colors = IRCController::colors();
                IRCController::alert($colors["red"].'[Watch]'.$colors["nc"].' Error getting redirector URL - '.$movie->title." (".$movie->year.")", "#errors");
                IRCController::alert($api, "#errors");
            }
        } else { /* No Uploads found.... uh oh */
            $colors = IRCController::colors();
            IRCController::alert($colors["red"].'[Uploads]'.$colors["nc"].' Error, no uplaods found for - '.$movie->title." (".$movie->year.")", "#errors");
            $file = null;
        }


        return view('watch.player', ["movie"=>$movie, "upload"=>$upload, "file_url"=>$file]);
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showGenre($genre)
    {
        $genre = str_replace("_", " ", $genre);
        $genre = Genre::where("genre", "=", $genre)->first();
        if(!$genre) die("Nothing found.");
        $movies = $genre->Movies();

        return view('genreSearch', ["movies"=>$movies, 'genre'=>$genre]);
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showTag($tag)
    {
        $tag = str_replace("-", " ", $tag);
        $explode = explode("__", $tag);
        
        if(isset($explode[1])) {
            $title = $explode[0];
            $tagExtra = " ".$explode[1];
        } else {
            $title = $tag;
            $tagExtra = "";
        }
        $tagTitle = ucwords($title).$tagExtra;

        $movies1 = Movie::where("title", "LIKE", "%".$title."%")->paginate(40);

        $tag = Tag::where("tag", "=", $tag)->first();
        $ids = Array();
        if($tag) {
            $titles = DB::Table("imdb_tags")->where("tag_id", "=", $tag->id)->get();
            foreach($titles as $title) $ids[] = $title->imdb_id;
            $movies2 = Movie::whereIn("id", $ids)->get();
        }

        if(isset($movies2)) $movies =  $movies1->merge($movies2);
            else $movies = $movies1;


        $referrer = \URL::previous();
        $id = explode("watch/", $referrer);
        if(isset($id[1])) {
            $id = explode("/", $id[1])[0];
            $movies3 = Movie::where("id", "=", $id)->get();
            $movies = Movie::where("id", ">=", 1)->paginate(40);
            $movies = $movies->merge($movies3);
        }


        if(count($movies)) $movies = Movie::where("id", ">=", 1)->paginate(40);

        return view('tag', ["movies"=>$movies, 'tag'=>$tag, "tagTitle"=>$tagTitle]);
        
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showCountry($country)
    {
        $country = str_replace("-", " ", $country);
        $movies = Movie::where("country", "LIKE", "%".$country."%")->get();
        if(count($movies)) $country = $movies[0]->country;
            else $country = $country;

        return view('countrySearch', ["movies"=>$movies, "country"=>$country]);
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showImdbTop250()
    {
        $movies = Movie::where("id", ">", "1")
            ->Where("rating", "!=", "n/A")
            ->Where("seasons", "=", "n/A")
            ->OrderBy("rating", "DESC")->OrderBy("votes", "DESC")->paginate(40);

        return view('imdbTop', ["movies"=>$movies]);
    }


    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showTVSeries()
    {
        $movies = Movie::where("id", ">", "1")
            ->Where("rating", "!=", "n/A")
            ->Where("seasons", "!=", "n/A")
            ->OrderBy("rating", "DESC")->OrderBy("votes", "DESC")->paginate(40);

        return view('imdbTop', ["movies"=>$movies]);
    }


    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showLibrary($letter = null)
    {

        if(!($letter) || $letter == "0-9") $letter = "[0-9]";
            else $letter = $letter[0];

        $count = $movies = Movie::where('title', 'regexp', '^'.$letter.'+')->count();
        $movies = Movie::where('title', 'regexp', '^'.$letter.'+')->OrderBy("title", "ASC")->paginate(40);
        return view('library', ["movies"=>$movies, "activeLetter"=>$letter, "count"=>$count]);
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showMoviesFilter($letter = null)
    {

        if(!($letter) || $letter == "0-9") $letter = "[0-9]";
            else $letter = $letter[0];

        $movies = Movie::where('id', '>', 1)->OrderBy("id", "DESC")->paginate(40);
        return view('filter', ["movies"=>$movies, "type"=>"Movies"]);
    }

    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showTVFilter($letter = null)
    {

        if(!($letter) || $letter == "0-9") $letter = "[0-9]";
            else $letter = $letter[0];

        $movies = Movie::where('id', '=', 1)->OrderBy("id", "DESC")->paginate(40);
        return view('filter', ["movies"=>$movies, "type"=>"TV Series"]);
    }
    /**
     * Movie Search Results Page
     *
     * @return \Illuminate\Http\Response
     */
    public function showNews()
    {
        $movies = Movie::where("id", ">", "1")->OrderBy("rating", "DESC")->OrderBy("votes", "DESC")->get();
        return view('news', ["movies"=>$movies]);
    }

    public function ajaxSearch(Request $request) {
        $keyword = $request->input("keyword");
        $movies = Movie::where("title", "LIKE", "%".$keyword."%")->get();

        $view = View::make('layouts.searchResults', ['movies' => $movies, 'keyword' => $keyword]);
        $contents = (string) $view;    

        $json["status"] = 1;
        $json["message"] = "Success";
        $json["content"] = $contents;
        echo json_encode($json);
    }


}