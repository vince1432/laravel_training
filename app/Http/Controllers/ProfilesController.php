<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    //for showing the profile of the specific user.
    public function index(User $user)
    {
        // if the user is authenticated  then check if the authenticated user is follwing the the given user otherwise false.
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id):false;
        // dd($follows);
        // $user = User::findOrFail($user);

        //for caching the posts count for 30 seconds
        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(30),
            function() use ($user){
                return $user->posts->count();
        });

        //for caching the followers count for 30 seconds
        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function () use ($user){
                return $user->profile->followers->count();
        });

        //for caching the following count for 30 seconds
        $followingCount = Cache::remember(
            'count.following.' . $user->id,
             now()->addSeconds(30),
              function () use ($user){
            return $user->following->count();
        });

        return view('profiles/index',compact('user','follows','postCount','followersCount','followingCount'));
    }

    //for redirecting to profiles.edit.
    public function edit(User $user)
    {
        //if user is authorize to update.Profile Policies.
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    //updating the profiles of the user.
    public function update(User $user)
    {
        //for validating the given data.
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        //if the given data has image.
        if (request('image')) {
            //storing the image in the storage/profile.
            $imagePath = request('image')->store('profile', 'public');
            //for resizing the stored image then saving it.
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);
            $image->save();
            //passing the image path into $ImageArray.
            $imageArray = ['image' => $imagePath];
        }
        // dd(array_merge(
        //     $data,
        //     ['image' => $imagePath]
        // ));
        //if update the profile if the user is authenticated
        auth()->user()->profile->update(array_merge(
                $data,
                //if $imageArray is not empty else null array.
                $imageArray ?? []
            ));

            //redirect to the updated profile.
        return redirect("/profile/{$user->id}");
    }
}
