@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="/Images/freeCodeGram.jpg" class="rounded-circle" alt="">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{$user->username}}</h1>
                <a href="#">Add new Post</a>

            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>153</strong> posts</div>
                <div class="pr-5"><strong>23k</strong> followers</div>
                <div class="pr-5"><strong>212</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{$user->profile->title}}</div>
            <div>{{$user->profile->description}}</div>
            <div><a href="#">{{$user->profile->url}}</a></div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-4"><img class="w-100" src="\Images\84217667_548898739065440_6328985649004661540_n.jpg" alt=""></div>
        <div class="col-4"><img class="w-100" src="\Images\88374782_543733416501650_6638052850750298038_n.jpg" alt=""></div>
        <div class="col-4"><img class="w-100" src="\Images\89485502_198087498118276_8717397081789116228_n.jpg" alt=""></div>
    </div>
</div>
@endsection
