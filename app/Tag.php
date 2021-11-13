<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'tag',
    ];

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tag'    => 'A tag is required.',
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
            'tag' => 'required|unique:tags',
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
    public function Movies()
    {
        return $this->belongsTo('Movies');
    }
}
