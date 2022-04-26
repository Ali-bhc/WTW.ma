@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/home.css') . "?" . time()}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/filter.css') . "?" . time()}}" type="text/css">
@endpush

@push('scripts')
    <script src="{{asset('js/home.js')}}"></script>
@endpush


@section('pageTitle', 'All movies page')

@section('content')


    <section class="movies">

        <h2 class="section-heading"> Movies </h2>

        <div class="movies-grid" id="featured-movies">

            @foreach($Movies as $movie)
                <div class="movie-card">
                <h3>  </h3>
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
                                @php
                                    $Moviegenres = \App\DAOs\Movies::getMovieGenresByMovieId($movie->get('movie')['id']);
                                @endphp

                                @foreach($Moviegenres as $genre)
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

        <div class="pagination">
            <a href="#">&laquo;</a>
            @for($i=0 ; $i< (int)\App\DAOs\Movies::getMoviesCount() /800;$i++)
                <a href="./{{$i}}">{{$i}}</a>
            <!--    <a class="active" href="#">2</a>-->

            @endfor
            <a href="#">&raquo;</a>
        </div>

    </section>






@endsection
