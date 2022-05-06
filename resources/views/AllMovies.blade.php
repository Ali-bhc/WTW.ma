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
        <form action="/AllMovies/1">
            <div class="myfilter">
            <div class="search_container">
                <p class="search_title">Search Term</p>
                <input class="search_input" type="search" placeholder="Search" name="search" value="{{request('search')}}">
                <button type="submit" class="search_button">Search</button>
             </div>

            <div class="filter_container filter-bar">
                <!-- Genres -->
                <div class="filter_item">
                    <p class="search_filter"> Genre </p>
                    <select name="genre" class="search_select">
                        <option class="filter-bar" value="all"> All</option>
                        @foreach(\App\DAOs\Genres::allGenres() as $genre)
                            @if( request('genre') == $genre->get('genre')->getProperty('name'))
                                <option selected="selected" value="{{$genre->get('genre')->getProperty('name')}}">
                                    {{$genre->get('genre')->getProperty('name')}}
                                </option>
                            @else
                                <option value="{{$genre->get('genre')->getProperty('name')}}">
                                    {{$genre->get('genre')->getProperty('name')}}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <!-- Ratings -->
                <div class="filter_item">
                    <p class="search_filter"> Rating </p>
                    <select name="rating" class="search_select">
                        <option value="all">All</option>
                        @for($i=1;$i<10;$i++)
                            @if( request('rating') == $i)
                                <option selected="selected" value="{{$i}}">
                                    +{{$i}}
                                </option>
                            @else
                        <option value="{{$i}}">+{{$i}}</option>

                            @endif
                        @endfor
                    </select>
                </div>
                <!-- Years -->
                <div class="filter_item">
                    <p class="search_filter"> Year </p>
                    <select name="year" class="search_select">
                        <option value="all">All</option>
                        @foreach($years as $year)
                            @if(request('year')==$year)
                            <option selected="selected" value="{{$year}}">{{$year}}</option>
                            @else
                            <option value="{{$year}}">{{$year}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                 <!-- languages -->
                <div class="filter_item">
                    <p class="search_filter">Languages</p>
                    <select name="language" class="search_select">
                        <option value="all">All</option>
                        @foreach(\App\DAOs\Movies::getAllLanguages() as $language)
                            @if(request('language')==$language->get('lang'))
                             <option selected="selected" value="{{$language->get('lang')}}">{{$language->get('lang')}}</option>
                            @endif
                        <option value="{{$language->get('lang')}}">{{$language->get('lang')}}</option>

                        @endforeach
                    </select>
                </div>
                <!-- Order By -->
                <div class="filter_item">
                    <p class="search_filter"> Order By </p>
                    <select name="orderby" class="search_select">
                        <option value="all">All</option>
                        @foreach($conditions as $condition)
                            @if(request('orderby') == $condition)
                            <option value="{{$condition}}" selected="selected">{{$condition}}</option>
                            @else
                            <option value="{{$condition}}">{{$condition}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        </form>

        <div class="pagination">
            @if($nbrpage >= 5)
                @for($i=1 ; $i<=$nbrpage ; $i++)
                    @if( request()->route('page') == (string)($i))
                        <a href="/AllMovies/1/?{{request()->getQueryString()}}">First</a>
                        @if($i > 1)
                            <a href="/AllMovies/{{$i-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllMovies/{{$i}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @endif

                        @if( $i> 3 && $i<= $nbrpage -3)
                            @for($j=$i-2 ; $j<$i+3 ; $j++)
                                @if($j == $i)
                                    <a class="active" href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @elseif($i <= 3)
                            @for($j=1;$j<6;$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllMovies/{{$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @else
                            @for($j=($nbrpage)-4 ;$j<=($nbrpage);$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @endif

                        @if($i < (int)($nbrpage))
                            <a href="/AllMovies/{{(int)$i+1}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @endif

                        <a href="/AllMovies/{{$nbrpage}}/?{{request()->getQueryString()}}">Last</a>

                    @endif
                @endfor

            @else
                @if($nbr == 0)
                    <p> resultat  introuvable !!!</p>
                @else
                    @if(request()->route('page') == 1)
                        <a href="/AllMovies/1/?{{request()->getQueryString()}}">First</a>
                        <a style="pointer-events: none;" href="/AllMovies/1/?{{request()->getQueryString()}}">&laquo;</a>
                    @elseif(request()->route('page')> 1 && request()->route('page')<=(string)($nbrpage))
                        <a href="/AllMovies/{{request()->route('page')-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                    @endif

                    @for($i=1 ; $i<=(int)($nbrpage) ; $i++)

                        @if( request()->route('page') == (string)($i))
                            <a class="active" href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @else
                            <a href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @endif
                    @endfor


                    @if(request()->route('page') == (string)($nbrpage))
                        <a style="pointer-events: none;" href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @else
                        <a href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @endif
                    <a href="/AllMovies/{{(int)(($nbrpage))}}/?{{request()->getQueryString()}}">Last</a>

                @endif
            @endif

        </div>

        <div class="movies-grid" id="feared-movies">

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
            @if($nbrpage >= 5)
                @for($i=1 ; $i<=$nbrpage ; $i++)
                    @if( request()->route('page') == (string)($i))
                        <a href="/AllMovies/1/?{{request()->getQueryString()}}">First</a>
                        @if($i > 1)
                            <a href="/AllMovies/{{$i-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllMovies/{{$i}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @endif

                        @if( $i> 3 && $i<= $nbrpage -3)
                            @for($j=$i-2 ; $j<$i+3 ; $j++)
                                @if($j == $i)
                                    <a class="active" href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @elseif($i <= 3)
                            @for($j=1;$j<6;$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllMovies/{{$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @else
                            @for($j=($nbrpage)-4 ;$j<=($nbrpage);$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllMovies/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @endif

                        @if($i < (int)($nbrpage))
                            <a href="/AllMovies/{{(int)$i+1}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @endif

                        <a href="/AllMovies/{{$nbrpage}}/?{{request()->getQueryString()}}">Last</a>

                    @endif
                @endfor

            @else
                @if($nbr == 0)
                    <p></p>
                @else
                    @if(request()->route('page') == 1)
                        <a href="/AllMovies/1/?{{request()->getQueryString()}}">First</a>
                        <a style="pointer-events: none;" href="/AllMovies/1/?{{request()->getQueryString()}}">&laquo;</a>
                    @elseif(request()->route('page')> 1 && request()->route('page')<=(string)($nbrpage))
                        <a href="/AllMovies/{{request()->route('page')-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                    @endif

                    @for($i=1 ; $i<=(int)($nbrpage) ; $i++)

                        @if( request()->route('page') == (string)($i))
                            <a class="active" href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @else
                            <a href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @endif
                    @endfor


                    @if(request()->route('page') == (string)($nbrpage))
                        <a style="pointer-events: none;" href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @else
                        <a href="/AllMovies/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @endif
                    <a href="/AllMovies/{{(int)(($nbrpage))}}/?{{request()->getQueryString()}}">Last</a>

                @endif
            @endif

        </div>

    </section>






@endsection
