<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class TagRelation extends Model
{
	public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'tag_id', 'link_id', 'type'
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
     * Define a one-many relationship with links.
     *
     * @return array
     */
    public function Tag()
    {
        return $this->belongsTo('Tag');
    }
}
