<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
  protected $table = 'cast';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'actor', 'character', 'imdb_id'
  ];
  public $timestamps = true;
  

  /* Database Relationships: */
  public function Movie()
  {
    return $this->belongsTo('Movie');
  }

}
