@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/home.css') . "?" . time()}}" type="text/css">
@endpush


@push('scripts')
    <script src="{{asset('js/home.js')}}"></script>
@endpush

@php
    use App\DAOs\Users;
@endphp

@section('pageTitle', 'WTW - Home Page')

@section('content')

    <!--Banner section: Random Movie-->
    <section class="banner">
        <div class="banner-card" onclick='{{ 'window.location = "' . route('movie', $bannerMovie['id']). '";' }}'>

            <img src="{{$bannerMovie->getProperty('cover')}}" class="banner-img">

            <div class="card-content">
                <div class="card-info">

                    <div class="">
                        <ion-icon name="film"></ion-icon>
                        <span>
                            @for($i=0; $i<count($bannerMovieGenres); $i++)
                                @if($i == count($bannerMovieGenres)-1)
                                    {{$bannerMovieGenres[$i]->get('genre')}}
                                @else
                                    {{$bannerMovieGenres[$i]->get('genre') . '/'}}
                                @endif
                            @endfor
                        </span>
                    </div>

                    <div class="">
                        <ion-icon name="calendar"></ion-icon>
                        <span>{{$bannerMovie->getProperty('year')}}</span>
                    </div>

                    <div class="">
                        <ion-icon name="time"></ion-icon>
                        <span>
                            @php
                                $runtime = $bannerMovie->getProperty('runtime');
                                $hours = intval($runtime/60);
                                $min = $runtime%60;

                                echo $hours . 'h' . $min .'min';
                            @endphp
                        </span>
                    </div>

                    <div class="">
                        <ion-icon name="star-half-outline"></ion-icon>
                        <span>{{$bannerMovie->getProperty('imdbRating')}}</span>
                    </div>
                </div>

                <h2 class="card-title"> {{$bannerMovie->getProperty('title')}} </h2>

            </div>
        </div>
    </section>


    <!--Movies Section: -->
    <section class="movies">

        <h2 class="section-heading"> Movies </h2>

        <!--Filter bar-->
        <div class="filter-bar">

            <!--year and genre filter-->
            <div class="filter-dropdowns">

                <select name="genre" id="" class="genre-dropdown">
                    <option value="all genres">All genres</option>
                    <option value="action">Action</option>
                    <option value="adventure">Adventure</option>
                    <option value="animation">Animation</option>
                    <option value="biography">Biography</option>
                </select>

                <select name="year" id="" class="year-dropdown">
                    <option value="all years">All years</option>
                    <option value="2022">2022</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2010-2019">2010-2019</option>
                    <option value="2000-2009">2000-2009</option>
                    <option value="2000-2009">1990-1999</option>
                    <option value="older"> older </option>
                </select>
            </div>

            <!--Trending - Featured - newest Filter-->
            <div class="filter-radios">

                <input type="radio" name="grade" id="featured-btn" checked>
                <label for="featured-btn">Featured</label>

                <input type="radio" name="grade" id="trending-btn">
                <label for="trending-btn">Trending</label>

                <input type="radio" name="grade" id="newest-btn">
                <label for="newest-btn">Newest</label>

                <div class="checked-radio-bg"></div>
            </div>

        </div>

        <!-- Movies Grid Featured -->
        <div class="movies-grid" id="featured-movies">

            @foreach(\App\DAOs\Movies::getNHighestRatedMovies(14) as $featuredMovie)
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
                                    $featuredMoviegenres = \App\DAOs\Movies::getMovieGenresByMovieId($featuredMovie->get('movie')['id']);
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

        <!-- Movies Grid Trending-->
        <div class="movies-grid" id="trending-movies">

            <!--Movie-->
            @foreach(\App\DAOs\Movies::getNMostVisitedMovies(14) as $trendingMovie)
                <div class="movie-card" onclick='{{ 'window.location = "' . route('movie', $trendingMovie->get('movie')['id']). '";' }}'>
                    <div class="card-head">
                        <img src="{{$trendingMovie->get('movie')->getProperty('poster')}}" alt="" class="card-img">
                        <div class="card-overlay">

                            {{-- if user is not connected or he didn't bookmark this movie--}}
                            @if(Auth::user() == null  || !Users::isBookmarked(Auth::user()->id, $trendingMovie->get('movie')['id'] ))
                                <form action="{{route('bookmark', $trendingMovie->get('movie')['id'])}}" method="POST">
                                    @csrf
                                    <button type="submit" class="bookmark">
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                    </button>
                                </form>
                            @else
                                <form action="{{route('UnBookmark', $trendingMovie->get('movie')['id'])}}" method="POST">
                                    @csrf
                                    <button type="submit" class="bookmark">
                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                                    </button>
                                </form>
                            @endif


                            <div class="rating">
                                <ion-icon name="star-outline"></ion-icon>
                                <span>{{$trendingMovie->get('movie')->getProperty('imdbRating')}}</span>
                            </div>
                            <div class="genre">
                                @php
                                    $trendingMoviegenres = \App\DAOs\Movies::getMovieGenresByMovieId($trendingMovie->get('movie')['id']);
                                @endphp

                                @foreach($trendingMoviegenres as $genre)
                                    {{$genre->get('genre')}}
                                @endforeach
                            </div>

                            <div class="view-details">
                                <span class="button-view-details">View Details</span>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title"> {{$trendingMovie->get('movie')->getProperty('title')}} </h3>

                        <div class="card-info">
                            <div class="card-year"> {{$trendingMovie->get('movie')->getProperty('year')}} </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Movies Grid Newest-->
        <div class="movies-grid" id="newest-movies">

            <!--Movie-->
            @foreach(\App\DAOs\Movies::getNNewestMovies(14) as $newestMovie)
                <div class="movie-card" onclick='{{ 'window.location = "' . route('movie', $newestMovie->get('movie')['id']). '";' }}'>

                    <div class="card-head">

                        <img src="{{$newestMovie->get('movie')->getProperty('poster')}}" alt="" class="card-img">

                        <div class="card-overlay">

                            {{-- if user is not connected or he didn't bookmark this movie--}}
                            @if(Auth::user() == null  || !Users::isBookmarked(Auth::user()->id, $newestMovie->get('movie')['id'] ))
                                <form action="{{route('bookmark', $newestMovie->get('movie')['id'])}}" method="POST">
                                    @csrf
                                    <button type="submit" class="bookmark">
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                    </button>
                                </form>
                            @else
                                <form action="{{route('UnBookmark', $newestMovie->get('movie')['id'])}}" method="POST">
                                    @csrf
                                    <button type="submit" class="bookmark">
                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                                    </button>
                                </form>
                            @endif

                            <div class="rating">
                                <ion-icon name="star-outline"></ion-icon>
                                <span>{{$newestMovie->get('movie')->getProperty('imdbRating')}}</span>
                            </div>

                            <div class="genre">
                                @php
                                    $newestMoviegenres = \App\DAOs\Movies::getMovieGenresByMovieId($newestMovie->get('movie')['id']);
                                @endphp

                                @foreach($newestMoviegenres as $genre)
                                    {{$genre->get('genre')}}
                                @endforeach
                            </div>

                            <div class="view-details">
                                <span class="button-view-details">View Details</span>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title"> {{$newestMovie->get('movie')->getProperty('title')}} </h3>

                        <div class="card-info">
                            <div class="card-year"> {{$newestMovie->get('movie')->getProperty('year')}} </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <!--Load more button-->
        <form action="/AllMovies/1" method="GET">
                <button class="load-more" type="submit">LOAD MORE</button>
        </form>
    </section>


    <!--Categories Section: -->
    <section class="category" id="category">

        <h2 class="section-heading"> Category</h2>

        <div class="category-grid">

            <!--category-->

            @foreach(\App\DAOs\Genres::allGenresWithNbrOfMovies() as $genre)
                <div class="category-card">

                    <img src="{{$genre->get('genre')->getProperty('img')}}" alt="" class="card-img">

                    <div class="name"> {{$genre->get('genre')->getProperty('name')}} </div>

                    <div class="total"> {{$genre->get('nbrMovies')}} </div>
                </div>
            @endforeach

        </div>

    </section>

    <!--Actors Section: -->
    <section class="actors" id="actors">

        <h2 class="section-heading"> Actors</h2>

        <div class="actors-grid">

            <!--actor-->

            @foreach(\App\DAOs\Actors::getNRandomActors(21) as $actor)
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



        <!--Load more button-->
        <form action="/AllPersons/1" method="GET">
            <button class="load-more" type="submit">LOAD MORE</button>
        </form>
    </section>



@endsection
