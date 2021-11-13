<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Community extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'descr'
    ];

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => 'A name is required.',
            'name.alpha_num'   => 'Only Alphanumeric characters allowed in name.',
            'name.without_spaces'   => 'No spaces allowed in name.',
            'name.unique'   => 'Sorry, that community name is already taken.',
            'descr.required'    => 'The description field is required'
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
            'name' => 'required|alpha_num|without_spaces|unique:communities',
            'descr' => 'required',
        ];
    }

    public function validator($data)
    {
		Validator::extend('without_spaces', function($attr, $value){
		    return preg_match('/^\S*$/u', $value);
		});

        // make a new validator object
        $v = Validator::make($data, $this->rules());
        // return the result
        return $v;
    }

    /**
     * Define a one-many relationship with users.
     *
     * @return array
     */
    public function User()
    {
        return $this->belongsTo('User');
    }


    /**
     * Define a one-many relationship with users.
     *
     * @return array
     */
    public function LiveDocs()
    {
        return $this->hasMany('Pages');
    }

}
