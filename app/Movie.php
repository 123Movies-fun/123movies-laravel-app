<?php

namespace App;

use \App\Genre;
use \App\Upload;
use \App\Image;
use \App\Server;

use Illuminate\Database\Eloquent\Model;
use DB;


class Movie extends Model
{
  protected $table = 'imdb';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'title', 'akas', 'aspect_ratio', 'awards', 'company', 'country', 'creator', 'director', 'is_released',  'language', 'location', 'mpaa', 'plot', 'poster', 'rating', 'release_date', 'runtime', 'seasons', 'soundmix', 'tagline', 'trailer_link', 'url', 'user_review', 'votes', 'year', 'poster_image_id'
  ];
  public $timestamps = true;


  /* Database Relationships: */
  public function Cast()
  {
    return $this->hasMany('Cast');
  }

  public function Certifications()
  {
    return $this->hasMany('App\Certification');
  }

  public function Genres($limit = 0)
  {
    $return = Array();
    $genres = DB::table("imdb_genres")->where("imdb_id", "=", $this->id)->get();
    foreach($genres as $genre) $return[] = Genre::find($genre->genre_id);

    if($limit != 0) return array_slice($return, 0, $limit);
      else return $return;

  }

  public function watchUrl() {
    if($this->seasons == "n/A") return '/movie/'.str_slug($this->title, '-').'-'.$this->id;
      else return '/tv-series/'.str_slug($this->title, '-').'-'.$this->id;
  }

  public function Keywords()
  {
      $tags = DB::table("imdb_tags")
        ->join('tags', 'tags.id', '=', 'imdb_tags.tag_id')
        ->where("imdb_id", "=", $this->id)->get();
      return $tags;
  }

  public function Actors()
  {
      $actors = DB::table("cast")
        ->where("imdb_id", "=", $this->id)->get();
      return $actors;
  }

  public function PosterImageUrl() {
    if(($this->poster_image_id) == null) return "";

    $image = Image::find($this->poster_image_id);
    if(isset($image->server_id)) $server = Server::find($image->server_id);
    if($image->server_id == 1) $image->location = str_replace("/var/www/harsh/public/", "", $image->location);
    if(isset($image->id) && isset($server->id)) return $server->http_url."/".$image->location."/".$image->filename;
      else return "";
  }

  public function Uploads()
  {
    $return = Array();
    $uploads = Upload::where("imdb_id", "=", $this->id);
    return $uploads;
  }

  public function Servers() {
    $uploads = $this->Uploads()->groupBy("server_id")->orderByRaw("abs(`episode_title`)", "ASC")->get();
    foreach($uploads as $upload) $ids[] = $upload->server_id;
    return Server::whereIn("id", $ids);
  }

  public function isFavorited() {
    if(!\Auth::user()) return false;
    $favorited = Favorite::where("user_id", "=", \Auth::user()->id)->where("imdb_id", "=", $this->id)->count();
    if($favorited) return true;
      else return false;
  }

  public function bestQuality() {
      $uploads = $this->Uploads();
      if(isset($uploads->first()->quality)) $quality = $uploads->first()->quality;
          else $quality = "N/A";
      return $quality;
  }

  public function actorLinks($type, $limit) {
    $i = 0; if(!isset($limit)) $limit = 5; $links = Array();
    foreach($this->Actors() as $actor) {
      $i++;
      if($i > $limit) break;
      $actor->actor = trim($actor->actor);
      $links[] = '<a href="/actor/'.strtolower($actor->actor).'" title="'.$actor->actor.'">'.$actor->actor.'</a>';
    }

    if($type == "html") return implode(", ", $links);
        else return $links;
  }

  public function genreLinks($type, $limit) {
    $links = Array();
    if(!isset($limit)) $limit = 8;
    foreach($this->Genres($limit = $limit) as $genre) {
      $genre->genre = trim($genre->genre);
      $links[] = '<a href="/genre/'.strtolower($genre->genre).'" title="'.$genre->genre.'">'.$genre->genre.'</a>';
    }

    if($type == "html") return implode(", ", $links);
        else return $links;
  }

  public function tagLinks($type, $limit) {
    $links = Array(); $i = 0;
    if(!isset($limit)) $limit = 8;
    foreach($this->Keywords() as $tag) {
      $i++;
      if($i > $limit) break;
      $tag->tag = trim($tag->tag);
      $links[] = '<a href="/tag/'.strtolower(str_replace(" ", "-", $tag->tag)).'" title="'.$tag->tag.'">'.$tag->tag.'</a>';
    }

    if($type == "html") return implode(" ", $links);
        else return $links;
  }

  public function countryLinks($type, $limit) {
    $links = Array();
    if(!isset($limit)) $limit = 8;
    $countries = explode("/", $this->country);

    foreach($countries as $country) {
      $country = trim($country);
      $links[] = '<a href="/country/'.strtolower($country).'" title="'.$country.'">'.$country.'</a>';
    }

    if($type == "html") return implode(", ", $links);
        else return $links;
  }

  public function highestEp() {
    $upload = $this->Uploads()->orderBy("episode_num", "DESC")->first();
    $c = (isset($upload->episode_num)) ? $upload->episode_num : 0;
    return ($c > 0) ? $c : 1;
  }

  public function url() {
    return '/watch/'.$this->id.'/'.str_slug($this->title, '-');
  }

}
