@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/home.css') . "?" . time()}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/pagination.css') . "?" . time()}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/Allmovies.css') . "?" . time()}}" type="text/css">
@endpush

@push('scripts')
    <script src="{{asset('js/home.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endpush


@section('pageTitle', 'All Actors page')

@section('content')


    <section class="actors">
        <form action="">
            <div class="myfilter">
                <div class="search_container">
                    <p class="search_title">Search Term</p>
                    <input class="search_input" type="text" placeholder="Search">
                    <button type="submit" class="search_button">Search</button>
                </div>

                <div class="filter_container filter-bar">
                    <!-- Genres -->
                    <div class="filter_item">
                        <p class="search_filter"> Genre </p>
                        <select name="genre" class="search_select">
                            <option class="filter-bar" value="all"> All</option>
                            @foreach(\App\DAOs\Genres::allGenres() as $genre)
                                <option value="{{$genre->get('genre')->getProperty('name')}}">
                                    {{$genre->get('genre')->getProperty('name')}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Ratings -->
                    <div class="filter_item">
                        <p class="search_filter"> Rating </p>
                        <select name="" class="search_select">
                            <option value="all ratings"> All</option>
                            <option value="1">+1</option>
                            <option value="2">+2</option>
                            <option value="3">+3</option>
                            <option value="4">+4</option>
                            <option value="5">+5</option>
                            <option value="6">+6</option>
                            <option value="7">+7</option>
                            <option value="8">+8</option>
                            <option value="9">+9</option>
                        </select>
                    </div>
                    <!-- Years -->
                    <div class="filter_item">
                        <p class="search_filter"> Year </p>
                        <select name="" class="search_select">
                            <option value="all years">All</option>
                            <option value="2022">2022</option>
                            <option value="2020-2021">2020-2021</option>
                            <option value="2010-2019">2010-2019</option>
                            <option value="2000-2009">2000-2009</option>
                            <option value="2000-2009">1990-1999</option>
                            <option value="older"> older </option>
                        </select>
                    </div>
                    <!-- languages -->
                    <div class="filter_item">
                        <p class="search_filter">Languages</p>
                        <select name="" class="search_select">
                            <option value="all languages">All</option>
                            @foreach(\App\DAOs\Genres::getAllLanguages() as $language)
                                <option value="{{$language->get('lang')}}">{{$language->get('lang')}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Order By -->
                    <div class="filter_item">
                        <p class="search_filter"> Order By </p>
                        <select name="" class="search_select">
                            <option value="all"> All</option>
                            <option value="Latest">Latest</option>
                            <option value="Oldest">Oldest</option>
                            <option value="Featured">Featured</option>
                            <option value="Seeds">Seeds</option>
                            <option value="Peers">Peers</option>
                            <option value="Year">Year</option>
                            <option value="ImdbRating">ImdbRating</option>
                            <option value="RT Audiance">RT Audiance</option>
                            <option value="revenue">revenue</option>
                            <option value="Alphabetical">Alphabetical</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <div class="pagination">
            <a href="#">&laquo;</a>
            @for($i=0 ; $i< (int)\App\DAOs\Movies::getMoviesCount()/800;$i++)
                <a href="./{{$i}}">{{$i}}</a>
            @endfor
            <a href="#">&raquo;</a>
        </div>

        <div class="actors-grid">

            <!--actor-->

            @foreach($Actors as $actor)
                <div class="actor-card">
                    <div class="card-head">
                        <img src="{{$actor->get('actor')->getProperty('poster')}}" alt="" class="card-img">
                    </div>
                    <div class="card-body">
                        <div class="name"> {{$actor->get('actor')->getProperty('name')}} </div>
                    </div>
                </div>
            @endforeach



        </div>

        <div class="pagination">
            <a href="#">&laquo;</a>
            @for($i=0 ; $i< (int)\App\DAOs\Movies::getMoviesCount()/800;$i++)
                <a href="./{{$i}}">{{$i}}</a>
            @endfor
            <a href="#">&raquo;</a>
        </div>

    </section>






@endsection
