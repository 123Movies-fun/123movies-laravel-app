<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
  protected $table = 'certification';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'certification'
  ];
  public $timestamps = true;
  

  /* Database Relationships: */
  public function Movies()
  {
    return $this->hasMany('Movie');
  }

}
