<?php

namespace App;

use \App\Genre;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Movie;

class Upload extends Model
{
  protected $table = 'uploads';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'server_id', 'imdb_id', 'ident_id', 'finished_at', 'last_checked', 'size_bytes', 'quality', 'views', 'episode_num', 'title'
  ];
  public $timestamps = true;

  /* Database Relationships: */
  public function Movie()
  {
    return $this->belongsTo('App\Movie', 'imdb_id', "id")->first();
  }

  public function Rating() {
    $total = DB::table('ratings')->where("upload_id", "=", $this->id)->sum('rating');
    $count = DB::table('ratings')->where("upload_id", "=", $this->id)->count();
    if($count) $rating = $total / $count;
      else $rating = 0;
    return number_format($total, 1);
  }

  public function RatingCount() {
    $count = DB::table('ratings')->where("upload_id", "=", $this->id)->count();
    return number_format($count);
  }

  public function Server()
  {
    return $this->belongsTo('App\Server');
  }
}
