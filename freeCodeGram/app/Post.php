<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    //relationship to User. This Post belong to only one User.(One to Many).
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
