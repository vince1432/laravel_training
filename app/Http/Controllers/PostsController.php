<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Post;

class PostsController extends Controller
{

    //only the authenticated user can access the functions.
    public function __construct()
    {
        $this->middleware('auth');
    }

    //for viewing post and adding pagination
    public function index()
    {
        //getting the user that authenticated user followed.
        $users = auth()->user()->following()->pluck('profiles.user_id');
        //getting the posts of of all the $users.
        $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);
        //redirect to post/index and sending $posts.
        return view('posts.index',compact('posts'));
        // dd($posts);
    }

    //go to create.blade in post
    public function create()
    {
        return view('posts/create');
    }

    //for posting
    public function store()
    {
        //getting data and then validating it
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required','image'],
        ]);

        //getting the image then store it in the uploads directory
        $imagePath = request('image')->store('uploads', 'public');
        //resize the image and save.
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
        $image->save();

        //getting the authenticated user creating the post for that user.
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        //redirect to the profile of the authenticated user.
        return redirect('/profile/'. auth()->user()->id );
    }

    //view the specific posts.
    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
