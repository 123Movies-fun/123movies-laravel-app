<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Server;

class Image extends Model
{
    protected $table = 'images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'original_filename', 'filename'
    ];
    public $timestamps = true;
    
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
    public function Server()
    {
        return $this->belongsTo('Server');
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           ///'title' => 'required|unique:posts|max:255',
           // 'body' => 'required',
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'title.required' => 'A title is required',
           // 'body.required'  => 'A message is required',
        ];
    }

    public function fullUrl() {
        return $this->Server()->http_url."/".$this->location;
    }
    
}
