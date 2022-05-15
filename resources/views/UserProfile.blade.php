@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') . "?" . time()}}" type="text/css">

@endpush

@push('scripts')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endpush



@section('pageTitle', "UserProfile")
@section('content')


<section class="UserPage">
    <div class="profile">
        <div class="test">
                <img src={{asset('img/uploads/' .$userdata->get('user')->getProperty('img'))}}>
        </div>
        <div class="Userinfo">
            <div class="UserData">
                    <div class="data">
                        <p class="Usertitle">Userid:</p>
                        <p>{{$userdata->get('user')->getProperty('userId')}}</p>
                    </div>
                <hr>
                    <div class="data">
                        <p class="Usertitle">Name:</p>
                        <p>{{$userdata->get('user')->getProperty('name')}}</p>
                    </div>
                <hr>
                    <div class="data">
                        <p class="Usertitle">Username:</p>
                        <p>{{$userdata->get('user')->getProperty('username')}}</p>
                    </div>
                <hr>
                    <div class="data">
                        <p class="Usertitle">Email:</p>
                        <p>{{$userdata->get('user')->getProperty('email')}}</p>
                    </div>
                <hr>
                    <div class="data">
                        <p class="Usertitle">Bookmarks Movies:</p>
                        <p>{{$bookmarkedcount}}</p>
                    </div>
                <hr>
            </div>

            <a href="/Editprofile"> <button class="button-1" role="button">Edit Profile</button> </a>
        </div>

    </div>
</section>
@endsection


