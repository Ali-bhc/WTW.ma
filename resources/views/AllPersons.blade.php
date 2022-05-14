@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/home.css') . "?" . time()}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/filter.css') . "?" . time()}}" type="text/css">
@endpush

@push('scripts')
    <script src="{{asset('js/home.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

@endpush


@section('pageTitle', 'All Persons page')

@section('content')


    <section class="actors">

        <form action="/AllPersons/1">
            @csrf
            <div class="myfilter">
                <div class="search_container">
                    <p class="search_title">Search Term</p>
                    <input class="search_input" type="search" placeholder="Search" name="search" value="{{request('search')}}">
                    <button type="submit" class="search_button">Search</button>
                </div>

                <div class="filter_container filter-bar">
                    <!-- Genres -->
                    <div class="filter_item">
                        <p class="search_filter"> Genre of movies</p>
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
                        <p class="search_filter"> Director </p>
                        <select name="type" class="search_select">
                            <option value="all">Persons</option>

                            @if(request('type')=="director")
                                <option selected="selected" value="director">Director</option>
                                <option  value="actor">Actor</option>
                            @elseif(request('type')=="actor")
                                <option selected="selected" value="actor">Actor</option>
                                <option  value="director">Director</option>
                            @else
                                <option selected="selected" value="actor">Actor</option>
                                <option  value="director">Director</option>
                            @endif
                        </select>
                    </div>
                    <!-- Years -->
                    <div class="filter_item">
                        <p class="search_filter"> Age </p>
                        <select name="age" class="search_select">
                            <option value="all">All</option>
                            @foreach($ages_intervals as $age)
                                @if(request('age')==$age)
                                    <option selected="selected" value="{{$age}}">{{$age}}</option>
                                @else
                                    <option value="{{$age}}">{{$age}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <!-- languages -->
                    <div class="filter_item">
                        <p class="search_filter">Living Status</p>
                        <select name="livingstatus" class="search_select">
                            <option value="all">All</option>

                            @if(request('livingstatus')=="died")
                                <option value="alive">alive</option>
                                <option selected="selected" value="died">died</option>
                            @elseif(request('livingstatus')=="alive")
                                <option selected="selected" value="alive">alive</option>
                                <option  value="died">died</option>
                            @else
                                <option  value="alive">alive</option>
                                <option  value="died">died</option>
                            @endif
                        </select>
                    </div>
                    <!-- Order By -->
                    <div class="filter_item">
                        <p class="search_filter">Nationality</p>
                        <select name="nationality" class="search_select">
                            <option value="all">All</option>
                            @foreach($Nationalities as $nationality)
                                @if(request('nationality') == $nationality)
                                    <option value="{{$nationality}}" selected="selected">{{$nationality}}</option>
                                @else
                                    <option value="{{$nationality}}">{{$nationality}}</option>
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
                        <a href="/AllPersons/1/?{{request()->getQueryString()}}">First</a>
                        @if($i > 1)
                            <a href="/AllPersons/{{$i-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllPersons/{{$i}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @endif

                        @if( $i> 3 && $i<= $nbrpage -3)
                            @for($j=$i-2 ; $j<$i+3 ; $j++)
                                @if($j == $i)
                                    <a class="active" href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @elseif($i <= 3)
                            @for($j=1;$j<6;$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllPersons/{{$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @else
                            @for($j=($nbrpage)-4 ;$j<=($nbrpage);$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @endif

                        @if($i < (int)($nbrpage))
                            <a href="/AllPersons/{{(int)$i+1}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @endif

                        <a href="/AllPersons/{{$nbrpage}}/?{{request()->getQueryString()}}">Last</a>

                    @endif
                @endfor

            @else
                @if($nbr == 0)
                    <p> resultat  introuvable !!!</p>
                @else
                    @if(request()->route('page') == 1)
                        <a href="/AllPersons/1/?{{request()->getQueryString()}}">First</a>
                        <a style="pointer-events: none;" href="/AllPersons/1/?{{request()->getQueryString()}}">&laquo;</a>
                    @elseif(request()->route('page')> 1 && request()->route('page')<=(string)($nbrpage))
                        <a href="/AllPersons/{{request()->route('page')-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                    @endif

                    @for($i=1 ; $i<=(int)($nbrpage) ; $i++)

                        @if( request()->route('page') == (string)($i))
                            <a class="active" href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @else
                            <a href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @endif
                    @endfor


                    @if(request()->route('page') == (string)($nbrpage))
                        <a style="pointer-events: none;" href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @else
                        <a href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @endif
                    <a href="/AllPersons/{{(int)(($nbrpage))}}/?{{request()->getQueryString()}}">Last</a>

                @endif
            @endif

        </div>


        <div class="actors-grid">

            <!--person-->

            @foreach($Persons as $person)
                <div class="actor-card" onclick='{{ 'window.location = "' . route('person', $person->get('person')['id']). '";' }}'>
                    <div class="card-head">
                        <img src="{{$person->get('person')->getProperty('poster')}}" alt="" class="card-img">
                    </div>
                    <div class="card-body">
                        <div class="name"> {{$person->get('person')->getProperty('name')}} </div>
                    </div>
                </div>
            @endforeach



        </div>

        <div class="pagination">
            @if($nbrpage >= 5)
                @for($i=1 ; $i<=$nbrpage ; $i++)
                    @if( request()->route('page') == (string)($i))
                        <a href="/AllPersons/1/?{{request()->getQueryString()}}">First</a>
                        @if($i > 1)
                            <a href="/AllPersons/{{$i-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllPersons/{{$i}}/?{{request()->getQueryString()}}">&laquo;</a>
                        @endif

                        @if( $i> 3 && $i<= $nbrpage -3)
                            @for($j=$i-2 ; $j<$i+3 ; $j++)
                                @if($j == $i)
                                    <a class="active" href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @elseif($i <= 3)
                            @for($j=1;$j<6;$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllPersons/{{$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @else
                            @for($j=($nbrpage)-4 ;$j<=($nbrpage);$j++)
                                @if($j == $i)
                                    <a class="active" href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @else
                                    <a href="/AllPersons/{{(int)$j}}/?{{request()->getQueryString()}}">{{(int)$j}}</a>
                                @endif
                            @endfor
                        @endif

                        @if($i < (int)($nbrpage))
                            <a href="/AllPersons/{{(int)$i+1}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @else
                            <a style="pointer-events: none;" href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                        @endif

                        <a href="/AllPersons/{{$nbrpage}}/?{{request()->getQueryString()}}">Last</a>

                    @endif
                @endfor

            @else
                @if($nbr == 0)
                    <p></p>
                @else
                    @if(request()->route('page') == 1)
                        <a href="/AllPersons/1/?{{request()->getQueryString()}}">First</a>
                        <a style="pointer-events: none;" href="/AllPersons/{{1}}/?{{request()->getQueryString()}}">&laquo;</a>
                    @elseif(request()->route('page')> 1 && request()->route('page')<=(string)($nbrpage))
                        <a href="/AllPersons/{{request()->route('page')-1}}/?{{request()->getQueryString()}}">&laquo;</a>
                    @endif

                    @for($i=1 ; $i<=(int)($nbrpage) ; $i++)

                        @if( request()->route('page') == (string)($i))
                            <a class="active" href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @else
                            <a href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">{{(int)$i}}</a>

                        @endif
                    @endfor


                    @if(request()->route('page') == (string)($nbrpage))
                        <a style="pointer-events: none;" href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @else
                        <a href="/AllPersons/{{(int)$i}}/?{{request()->getQueryString()}}">&raquo;</a>
                    @endif
                    <a href="/AllPersons/{{$nbrpage}}/?{{request()->getQueryString()}}">Last</a>

                @endif
            @endif

        </div>


    </section>






@endsection
