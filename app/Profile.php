<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    //for getting the path of profile picture.
    public function profileImage()
    {
        $imagePath = ($this->image) ?  $this->image : 'profile\1024px-No_image_available.svg.png';
        return '/storage/' . $imagePath;
    }

    //This profile is followed by Many User. Many to Many Relationship to User.
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    //Profile belongs to Only one user. One to One Relationship.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
