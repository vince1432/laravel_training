<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowsController extends Controller
{
    //only the authenticated user can access the functions.
    public function __construct()
    {
        $this->middleware('auth');
    }

    //for changing following status using toggle function.
    public function store(User $user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
