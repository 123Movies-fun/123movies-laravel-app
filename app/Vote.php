<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use App\User;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'user_id',
                'url',
                'url_canonical',
                'community_link_id',
                'value'
    ];

    /**
     * Define a one-many relationship with users.
     *
     * @return array
     */
    public function Link()
    {
        return $this->belongsTo('CommunityLink');
    }

}
