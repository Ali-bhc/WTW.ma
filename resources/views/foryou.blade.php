@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/home.css') . "?" . time()}}" type="text/css">
@endpush


@push('scripts')

@endpush

@section('pageTitle', 'Recommended For You')


@php
    use \Illuminate\Support\Facades\Auth;
    use \App\DAOs\Movies;
    use \App\DAOs\Users;
@endphp

@section('content')

    <!--Movies Section: -->
    <section class="movies">

        <h2 class="section-heading" style="text-align: center"> Recommended for you </h2>

        @php
            $movies = Movies::getNRecommendedMovies(Auth::user()->id, 50);
        @endphp

        @if(count($movies) > 0)
            <!-- Movies Grid -->
            <div class="movies-grid" id="featured-movies">

                @foreach($movies as $featuredMovie)
                    <div class="movie-card" onclick='{{ 'window.location = "' . route('movie', $featuredMovie->get('movie')['id']). '";' }}'>
                        <div class="card-head">

                            <img src="{{$featuredMovie->get('movie')->getProperty('poster')}}" alt="" class="card-img">

                            <div class="card-overlay">

                                {{-- if user is not connected or he didn't bookmark this movie--}}
                                @if(Auth::user() == null  || !Users::isBookmarked(Auth::user()->id, $featuredMovie->get('movie')['id'] ))
                                    <form action="{{route('bookmark', $featuredMovie->get('movie')['id'])}}" method="POST">
                                        @csrf
                                        <button type="submit" class="bookmark">
                                            <ion-icon name="bookmark-outline"></ion-icon>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{route('UnBookmark', $featuredMovie->get('movie')['id'])}}" method="POST">
                                        @csrf
                                        <button type="submit" class="bookmark">
                                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                                        </button>
                                    </form>
                                @endif

                                <div class="rating">
                                    <ion-icon name="star-outline"></ion-icon>
                                    <span>{{$featuredMovie->get('movie')->getProperty('imdbRating')}}</span>
                                </div>

                                <div class="genre">
                                    @php
                                        $featuredMoviegenres = Movies::getMovieGenresByMovieId($featuredMovie->get('movie')['id']);
                                    @endphp

                                    @foreach($featuredMoviegenres as $genre)
                                        {{$genre->get('genre')}}
                                    @endforeach
                                </div>

                                <div class="view-details">
                                    <span class="button-view-details">View Details</span>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <h3 class="card-title"> {{$featuredMovie->get('movie')->getProperty('title')}} </h3>

                            <div class="card-info">
                                <div class="card-year"> {{$featuredMovie->get('movie')->getProperty('year')}} </div>
                            </div>
                        </div>

                    </div>

                @endforeach

            </div>
        @else

            <p>Please add some movies to your favorites so we can recommend some movies for you!</p>
        @endif
    </section>


@endsection
