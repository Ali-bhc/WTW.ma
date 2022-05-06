@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/movie.css') . "?" . time()}}" type="text/css">

@endpush


@push('scripts')
{{--    <script src="{{asset('js/movie.js')}}"></script>--}}
@endpush


@section('pageTitle', $movie->get('movie')->getProperty('title'))

@php
    use App\DAOs\Actors;
    use App\DAOs\Directors;
    use App\DAOs\Movies;
    use App\DAOs\Users;
    use Illuminate\Support\Facades\Auth;

@endphp

@section('content')

    <section class="movie-detail">

        <div class="container">

            <div class="movie-detail-banner">
                <img class="poster" src="{{$movie->get('movie')->getProperty('poster')}}" alt="" >

                <div class="card-overlay">

                    @if(Auth::user() == null  || !Users::isBookmarked(Auth::user()->id, $movie->get('movie')['id'] ))
                        <form action="{{route('bookmark', $movie->get('movie')['id'])}}" method="POST">
                            @csrf
                                <button type="submit" class="bookmark">
                                    <ion-icon name="bookmark-outline"></ion-icon>
                                </button>
                        </form>
                    @else
                        <form action="{{route('UnBookmark', $movie->get('movie')['id'])}}" method="POST">
                            @csrf
                            <button type="submit" class="bookmark">
                                <ion-icon name="checkmark-circle-outline"></ion-icon>
                            </button>
                        </form>
                    @endif

                </div>
            </div>

            <div class="movie-detail-content">

                <h1 class="detail-title">
                    {{$movie->get('movie')->getProperty('title')}}
                </h1>

                <div class="meta-wrapper">

                    <div class="ganre-wrapper">

                        @foreach(Movies::getMovieGenresByMovieId($id) as $genre)
                            <a href="#">{{$genre->get('genre')}}</a>
                        @endforeach
                    </div>

                    <div class="date-time">

                        <div>
                            <ion-icon name="calendar-outline"></ion-icon>

                            <time datetime="2021">{{$movie->get('movie')->getProperty('year')}}</time>
                        </div>

                        <div>
                            <ion-icon name="time-outline"></ion-icon>

                            <time datetime="PT115M">
                                {{intval($movie->get('movie')->getProperty('runtime')/60) . 'h' . $movie->get('movie')->getProperty('runtime')%60 . 'm'}}
                            </time>
                        </div>
                    </div>


                </div>

                <div class="line">
                    IMDB Rating :
                    <span>
                        <ion-icon name="star-outline"></ion-icon>
                        <span>{{$movie->get('movie')->getProperty('imdbRating')}}</span>
                    </span>
                </div>

                <div class="line">
                    Languages :
                    <span>
                        <span>
                            @foreach($movie->get('movie')->getProperty('languages') as $language)
                                {{$language}}
                            @endforeach
                        </span>
                    </span>
                </div>

                <div class="line">
                    Viewed :
                    <span>
                        <span>{{$movie->get('movie')->getProperty('nbrVisits') . ' times'}}</span>
                    </span>
                </div>

                <div class="line">
                    Released :
                    <span>
                        <span>{{$movie->get('movie')->getProperty('released')}}</span>
                    </span>
                </div>

                <div class="line">
                    Revenue:
                    <span>
                        <span>$ {{$movie->get('movie')->getProperty('revenue')}}</span>
                    </span>
                </div>

                <p class="storyline">
                    <h5>Plot: </h5>
                    {{$movie->get('movie')->getProperty('plot')}}
                </p>


            </div>


            <div class="simlar-movies">
                <div class="simlar-title">
                    <h3>Similar Movies</h3>
                </div>
                <div class="movies-grid">

                    @foreach(Movies::getNSimilarMovies($id, 4) as $similarMovie)
                        <div class="movie-card" onclick='{{ 'window.location = "' . route('movie', $similarMovie->get('movie')['id']). '";' }}'>
                            <div class="card-head">
                                <img src="{{$similarMovie->get('movie')->getProperty('poster')}}" alt="" class="card-img">
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"> {{$similarMovie->get('movie')->getProperty('title')}} </h3>

                                <div class="card-info">
                                    <div class="card-year">{{$similarMovie->get('movie')->getProperty('year')}}  </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </section>

    <!--Directors Section: -->
    <section class="actors" id="actors">

        <h2 style="margin-bottom: 20px"> Director(s):</h2>

        <div class="actors-grid">

            <!--Director-->
            @foreach(Directors::getMovieDirectors($id) as $director)
                <div class="actor-card" onclick='{{ 'window.location = "' . route('person', $director->get('director')['id']). '";' }}'>

                    <div class="card-head">
                        <img src="{{$director->get('director')->getProperty('poster')}}" alt="" class="card-img">
                    </div>
                    <div class="card-body">
                        <div class="name"> {{$director->get('director')->getProperty('name')}} </div>
                    </div>
                </div>
            @endforeach


        </div>
    </section>

    <!--Actors Section: -->
    <section class="actors" id="actors">

        <h2 style="margin-bottom: 20px"> Actors:</h2>

        <div class="actors-grid">

            @foreach(Actors::getMovieActors($id) as $actor)
                <!--Actor-->
                <div class="actor-card" onclick='{{ 'window.location = "' . route('person', $actor->get('actor')['id']). '";' }}'>
                    <div class="card-head">
                        <img src="{{$actor->get('actor')->getProperty('poster')}}" alt="" class="card-img">
                    </div>
                    <div class="card-body">

                        <div class="name"> {{$actor->get('actor')->getProperty('name')}} </div>
                    </div>
                </div>
            @endforeach


        </div>
    </section>
@endsection
