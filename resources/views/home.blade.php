@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/home.css') . "?" . time()}}" type="text/css">
@endpush

@push('scripts')
    <script src="{{asset('js/home.js')}}"></script>
@endpush


@section('content')

    <!--Banner section: Random Movie-->
    <section class="banner">
        <div class="banner-card">

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
                        <span>2h 54min</span>
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

            @foreach($featuredMovies as $featuredMovie)
                <div class="movie-card">

                    <div class="card-head">

                        <img src="{{$featuredMovie->get('movie')->getProperty('poster')}}" alt="" class="card-img">

                        <div class="card-overlay">

                            <div class="bookmark">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </div>

                            <div class="rating">
                                <ion-icon name="star-outline"></ion-icon>
                                <span>{{$featuredMovie->get('movie')->getProperty('imdbRating')}}</span>
                            </div>

                            <div class="genre">
                                @php
                                    $genres = \App\DAOs\Movies::getMovieGenresByMovieId($featuredMovie->get('movie')['id']);
                                @endphp

                                @foreach($genres as $genre)
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
            <div class="movie-card">

                <div class="card-head">

                    <img src="images/movies/eternals.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>6.4</span>
                        </div>

                        <div class="genre">
                            Action Adventure Fantasy
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> Eternals </h3>

                    <div class="card-info">
                        <div class="card-year"> 2021 </div>

                    </div>
                </div>

            </div>

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="images/movies/gladiator.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>8.5</span>
                        </div>

                        <div class="genre">
                            Action Adventure Drama
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> Gladiator </h3>

                    <div class="card-info">
                        <div class="card-year"> 2000 </div>

                    </div>
                </div>

            </div>

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="images/movies/interstaller.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>8.3</span>
                        </div>

                        <div class="genre">
                            Drama Sci-Fi Thriller
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> Interstellar </h3>

                    <div class="card-info">
                        <div class="card-year"> 2014 </div>

                    </div>
                </div>

            </div>

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="images/movies/LOTR.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>6.8</span>
                        </div>

                        <div class="genre">
                            Adventure Drama Fantasy
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> The Lord of the Rings: The Fellowship of the Ring </h3>

                    <div class="card-info">
                        <div class="card-year"> 2001 </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Movies Grid Newest-->
        <div class="movies-grid" id="newest-movies">

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="https://image.tmdb.org/t/p/w440_and_h660_face/wR5HZWdVpcXx9sevV1bQi7rP4op.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>8.9</span>
                        </div>

                        <div class="genre">
                            Drama Crime Thriller
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> Fight Club </h3>

                    <div class="card-info">
                        <div class="card-year"> 1999 </div>

                    </div>
                </div>

            </div>

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="https://image.tmdb.org/t/p/w440_and_h660_face/yAaf4ybTENKPicqzsAoW6Emxrag.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>8.0</span>
                        </div>

                        <div class="genre">
                            Crime Comedy Drama
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> Pulp Fiction </h3>

                    <div class="card-info">
                        <div class="card-year"> 1994 </div>

                    </div>
                </div>

            </div>

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="https://image.tmdb.org/t/p/w440_and_h660_face/7sf9CgJz30aXDvrg7DYYUQ2U91T.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>8.3</span>
                        </div>

                        <div class="genre">
                            Action Drama War
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> 12 Angry Men </h3>

                    <div class="card-info">
                        <div class="card-year"> 1957 </div>

                    </div>
                </div>

            </div>

            <!--Movie-->
            <div class="movie-card">

                <div class="card-head">

                    <img src="https://image.tmdb.org/t/p/w440_and_h660_face/eWivEg4ugIMAd7d4uWI37b17Cgj.jpg" alt="" class="card-img">

                    <div class="card-overlay">

                        <div class="bookmark">
                            <ion-icon name="bookmark-outline"></ion-icon>
                        </div>

                        <div class="rating">
                            <ion-icon name="star-outline"></ion-icon>
                            <span>6.8</span>
                        </div>

                        <div class="genre">
                            Action Adventure Sci-Fi
                        </div>

                        <div class="view-details">
                            <span class="button-view-details">View Details</span>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title"> The Good, The Bad and The Ugly </h3>

                    <div class="card-info">
                        <div class="card-year"> 1966 </div>

                    </div>
                </div>

            </div>

        </div>

        <!--Load more button-->
        <button class="load-more">LOAD MORE</button>
    </section>
@endsection
