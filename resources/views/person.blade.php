@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/person.css') . "?" . time()}}" type="text/css">

@endpush


@push('scripts')
    {{--    <script src="{{asset('js/movie.js')}}"></script>--}}
@endpush

@section('pageTitle', $person->get('person')->getProperty('name'))


@section('content')

    <section class="movie-detail">

        <div class="container">

            <div class="movie-detail-banner">
                <img class="poster" src="{{$person->get('person')->getProperty('poster')}}" alt="" >
            </div>

            <div class="movie-detail-content">

                <h1 class="detail-title">
                    {{$person->get('person')->getProperty('name')}}
                </h1>

                <div class="meta-wrapper">


                    <div class="date-time">

                        <div>
                            <ion-icon name="calendar-outline"></ion-icon>
                            Birthday:
                            <time datetime="">
                                {{$person->get('person')->getProperty('born')->convertToBolt()}}
                                @php
                                    $today = date('Y-m-d');
                                    $birth = $person->get('person')->getProperty('born')->convertToBolt();
                                    try{
                                        $death = $person->get('person')->getProperty('died')->convertToBolt();
                                        $diff = date_diff(date_create($birth), date_create($death));
                                        echo   ' -> ' . $death . ' (' . $diff->format('%y') . ' Years old )';
                                    }catch (\Laudis\Neo4j\Exception\PropertyDoesNotExistException $e)
                                    {
                                        $diff = date_diff(date_create($birth), date_create($today));
                                        echo   ' -> Present' . ' ( ' . $diff->format('%y') . ' Years old )';
                                    }



                                @endphp
                            </time>
                        </div>


                    </div>


                </div>

                <div class="line">
                    @php
                        $nbrActedIn = \App\DAOs\Persons::getNbrOfPersonActedInMovies($id)->get('nbr')
                    @endphp
                    @if($nbrActedIn > 0)
                        Acted In {{ $nbrActedIn . ' Movies'}}
                    @endif
                </div>

                <div class="line">

                    @php
                        $nbrDirected = \App\DAOs\Persons::getNbrOfPersonDirectedMovies($id)->get('nbr')
                    @endphp
                    @if($nbrDirected > 0)
                        Directed {{$nbrDirected . ' Movies'}}
                    @endif
                </div>

                <p class="storyline">
                    <h5>Biography: </h5> <br>
                    {{$person->get('person')->getProperty('bio')}}
                </p>


            </div>


            <div class="simlar-movies">
                @if($nbrActedIn >= $nbrDirected)
                    <div class="simlar-title">
                        <h3>Similar Actors</h3>
                    </div>

                    <div class="moviess-grid">
                        @foreach(\App\DAOs\Actors::getNSimilarActors($id,4) as $similarActor)
                            <div class="moviee-card" onclick='{{ 'window.location = "' . route('person', $similarActor->get('actor')['id']). '";' }}'>
                                <div class="cardd-head">
                                    <img src="{{$similarActor->get('actor')->getProperty('poster')}}" alt="" class="cardd-img">
                                </div>
                                <div class="cardd-body">
                                    <h3 class="cardd-title"> {{$similarActor->get('actor')->getProperty('name')}} </h3>

                                </div>
                             </div>
                        @endforeach
                    </div>
                @else
                    <div class="simlar-title">
                        <h3>See also..</h3>
                    </div>
                    <div class="moviess-grid">
                        @foreach(\App\DAOs\Directors::getNRandomDirectors(4) as $otherDirector)
                            <div class="moviee-card" onclick='{{ 'window.location = "' . route('person', $otherDirector->get('director')['id']). '";' }}'>
                                <div class="cardd-head">
                                    <img src="{{$otherDirector->get('director')->getProperty('poster')}}" alt="" class="cardd-img">
                                </div>
                                <div class="cardd-body">
                                    <h3 class="cardd-title"> {{$otherDirector->get('director')->getProperty('name')}} </h3>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>
    </section>


    @if($nbrActedIn > 0)
        <!--Acted In Section: -->
        <section class="movies">

        <h2 class="section-heading"> Acted In : </h2>
        <div class="movies-grid" id="featured-movies">

            @foreach(\App\DAOs\Movies::getAllPersonActedInMovies($id) as $movie)
                <div class="movie-card" onclick='{{ 'window.location = "' . route('movie', $movie->get('movie')['id']). '";' }}'>
                <div class="card-head">
                    <img src="{{$movie->get('movie')->getProperty('poster')}}" alt="" class="card-img">
                    <div class="card-overlay">
                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>
                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>{{$movie->get('movie')->getProperty('imdbRating')}}</span>
                        </div>
                        <div class="genre">
                            @foreach(\App\DAOs\Movies::getMovieGenresByMovieId($movie->get('movie')['id']) as $genre)
                                {{$genre->get('genre')}}
                            @endforeach
                        </div>
                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> {{$movie->get('movie')->getProperty('title')}} </h3>

                    <div class="card-info">
                        <div class="card-year"> {{$movie->get('movie')->getProperty('year')}} </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($nbrDirected > 0)
        <!--Directed Section: -->
        <section class="movies">

        <h2 class="section-heading"> Directed : </h2>
        <div class="movies-grid">

            @foreach(\App\DAOs\Movies::getAllPersonDirectedMovies($id) as $movie)
                <div class="movie-card" onclick='{{ 'window.location = "' . route('movie', $movie->get('movie')['id']). '";' }}'>
                    <div class="card-head">
                        <img src="{{$movie->get('movie')->getProperty('poster')}}" alt="" class="card-img">
                        <div class="card-overlay">
                            <div class="bookmark">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </div>
                            <div class="rating">
                                <ion-icon name="star-outline"></ion-icon>
                                <span>{{$movie->get('movie')->getProperty('imdbRating')}}</span>
                            </div>
                            <div class="genre">
                                @foreach(\App\DAOs\Movies::getMovieGenresByMovieId($movie->get('movie')['id']) as $genre)
                                    {{$genre->get('genre')}}
                                @endforeach
                            </div>
                            <div class="view-details">
                                <span class="button-view-details">View Details</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title"> {{$movie->get('movie')->getProperty('title')}} </h3>

                        <div class="card-info">
                            <div class="card-year"> {{$movie->get('movie')->getProperty('year')}} </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </section>
    @endif

@endsection
