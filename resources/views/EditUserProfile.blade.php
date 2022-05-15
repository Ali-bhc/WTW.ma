@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') . "?" . time()}}" type="text/css">

@endpush

@push('scripts')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endpush



@section('pageTitle', "UserProfile")
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success text-center">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::get('fail'))
        <div class="alert alert-danger text-center">
            {{ Session::get('fail') }}
        </div>
    @endif
<section>
    <form action="/profile" method="post" enctype="multipart/form-data">
    @csrf
        @method('PATCH')
    <div class="UserPage">


            <div class="profile">

                    <div class="test">
                        <img src={{asset('img/uploads/' .$userdata->get('user')->getProperty('img'))}}>
                            <input type="file" name="IMG_USER"/>
                           <!-- <a href="/upload"> <button class="button-1" role="button">Upload</button> </a>-->

                    </div>
                    <div class="Userinfo">
                        <div class="UserData">
                            <div class="data">
                                <p class="Usertitle">Name:</p>
                                <label class="omrs-input-underlined">
                                    <input type="text" name="name" value="{{$userdata->get('user')->getProperty('name')}}">
                                </label>
                            </div>
                            <input type="submit" class="button-1" role="button" value="Save Changes">

                            <!--<button class="button-1" role="button" type="submit">Save Changes</button>-->

                        </div>

                    </div>
            </div>

    </div>
    </form>
</section>
@endsection


