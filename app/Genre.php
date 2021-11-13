<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;
use \App\Movie;

class Genre extends Model
{
  protected $table = 'genre';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'genre', 'imdb_id'
  ];
  public $timestamps = true;
  

  /* Database Relationships: */
  public function Movies($limit = 40)
  {
    $return = Array();
    $movies = DB::table("imdb_genres")->where("genre_id", "=", $this->id)->get();
    foreach($movies as $movie) {
      $movie = Movie::find($movie->imdb_id);
      if($movie) $return[] = $movie;
    }

    if($limit != 0) return array_slice($return, 0, $limit);
      else return $return;
  }

}
