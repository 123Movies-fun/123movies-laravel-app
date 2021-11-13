<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use App\Link;
use App\User;

class CommunityLink extends Model
{
	public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'user_id', 'title', 'link_id', 'community_id', 'views'
    ];

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tag_id'    => 'A tag is required.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag_id' => 'required',
        ];
    }

    public function validator($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules());
        // return the result
        return $v;
    }

    /**
     * Define a many-one relationship with links.
     *
     * @return array
     */
    public function Link()
    {
        return $this->belongsTo('App\Link');
    }

    /**
     * Define a many-one relationship with links.
     *
     * @return array
     */
    public function Community()
    {
        return $this->belongsTo('App\Community');
    }
}
