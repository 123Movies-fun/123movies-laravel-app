<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Page;
use App\Image;
use App\Rating;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'class',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    

  public function pages()
  {
    return $this->hasMany('App\Page');
  }

  public function createdCommunities()
  {
    return $this->hasMany('App\Community');
  }

  public function Favorites() {
    $return = [];
    $favorites = Favorite::where("user_id", "=", $this->id)->get();
    foreach($favorites as $favorite) {
      $return[] = $favorite->imdb_id;
    }
    return $return;
  }
  public function Ratings() {
    $return = [];
    $rateds = Rating::where("user_id", "=", $this->id)->get();
    foreach($rateds as $rated) {
      $return[] = $upload = Upload::find($rated->upload_id)->imdb_id;
    }
    return $return;
  }

  public function isAdmin() {
    if($this->class == "admin") return true;
      else return false;
  }

  public function Avatar() {
    if($this->profile_image_id) {
        $image = Image::find($this->profile_image_id);
        if($image) return "/cdn/users/".$this->id."/thumbnails/".$image->filename;
    }
  }
    
}
