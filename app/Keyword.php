<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    /**
     * Define a one-many relationship with links.
     *
     * @return array
     */
    public function Links()
    {
        return $this->belongsTo('Link');
    }
}
